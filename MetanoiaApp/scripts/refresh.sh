#!/usr/bin/env bash
#
# refresh.sh — pull the latest code and rebuild/refresh the whole MetanoiaApp.
#
# Runs, in order: git pull → composer install → npm build (client + SSR) →
# migrate → clear & re-cache → restart the Inertia SSR server.
#
# Usage:
#   ./scripts/refresh.sh              # auto: prod if APP_ENV=production in .env, else local
#   ./scripts/refresh.sh --prod       # force production (composer --no-dev, supervisor SSR)
#   ./scripts/refresh.sh --local      # force local (dev deps, local node SSR on :13714)
#   ./scripts/refresh.sh --skip-build # don't run npm build (assets rsynced separately)
#   ./scripts/refresh.sh --no-pull    # rebuild current checkout, don't git pull
#   ./scripts/refresh.sh --help
#
set -euo pipefail

# Laravel app root (this script lives in <app>/scripts/).
APP_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$APP_DIR"

MODE=""          # prod | local
DO_PULL=1
DO_BUILD=1

for arg in "$@"; do
    case "$arg" in
        --prod)       MODE="prod" ;;
        --local)      MODE="local" ;;
        --no-pull)    DO_PULL=0 ;;
        --skip-build) DO_BUILD=0 ;;
        -h|--help)    awk 'NR>1 && /^#/{sub(/^# ?/,""); print; next} NR>1{exit}' "$0"; exit 0 ;;
        *) echo "Unknown option: $arg (try --help)" >&2; exit 1 ;;
    esac
done

# Auto-detect environment from .env when not forced.
if [ -z "$MODE" ]; then
    if grep -qE '^APP_ENV=production' .env 2>/dev/null; then MODE="prod"; else MODE="local"; fi
fi

log()  { printf '\n\033[1;34m▶ %s\033[0m\n' "$1"; }
warn() { printf '\033[1;33m  ! %s\033[0m\n' "$1"; }

log "MetanoiaApp refresh — mode: ${MODE}  ·  dir: ${APP_DIR}"

# 1) Latest code. git pulls the whole repo even if the app is a subfolder.
if [ "$DO_PULL" -eq 1 ]; then
    log "Pulling latest code"
    git pull --ff-only
else
    log "Skipping git pull (--no-pull)"
fi

# 2) PHP dependencies
log "Installing Composer dependencies"
if [ "$MODE" = "prod" ]; then
    composer install --no-dev --optimize-autoloader --no-interaction
else
    composer install --no-interaction
fi

# 3) Front-end build (client bundle + SSR bundle)
if [ "$DO_BUILD" -eq 1 ]; then
    log "Building front-end assets (client + SSR)"
    if [ "$MODE" = "prod" ] && [ -f package-lock.json ]; then
        npm ci
    else
        npm install
    fi
    npm run build:ssr
else
    log "Skipping front-end build (--skip-build)"
fi

# 4) Database
log "Running migrations"
php artisan migrate --force

# 5) Caches — always clear; re-cache for production
log "Refreshing caches"
php artisan optimize:clear
if [ "$MODE" = "prod" ]; then
    php artisan optimize   # caches config + routes + views + events
fi

# 6) Restart the Inertia SSR server so it serves the freshly built bundle
log "Restarting Inertia SSR server"
if [ "$MODE" = "prod" ]; then
    if command -v supervisorctl >/dev/null 2>&1; then
        sudo supervisorctl restart metanoia-ssr \
            || warn "supervisor program 'metanoia-ssr' not found — start it per DEPLOYMENT.md §11"
    else
        warn "supervisorctl not found — restart the SSR process manually (DEPLOYMENT.md §11)"
    fi
else
    # Local dev: restart the plain node SSR process on :13714.
    pkill -f 'bootstrap/ssr/ssr.js' 2>/dev/null || true
    sleep 1
    nohup node bootstrap/ssr/ssr.js > storage/logs/ssr.log 2>&1 &
    echo "  local SSR restarted (pid $!) — http://127.0.0.1:13714"
fi

log "Done ✓  MetanoiaApp is up to date."
