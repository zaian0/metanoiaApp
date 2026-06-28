#!/usr/bin/env bash
#
# MetanoiaApp — install all required tools EXCEPT Node/npm (assumed already installed).
#
# Installs: PHP 8.3 (+ extensions), Composer, and — on Linux — Nginx + MySQL.
# Auto-detects macOS (Homebrew) vs Debian/Ubuntu (apt).
#
# Usage:
#   chmod +x scripts/install-tools.sh
#   ./scripts/install-tools.sh
#
set -euo pipefail

PHP_VER="8.3"

say() { printf '\n\033[1;34m==> %s\033[0m\n' "$*"; }

# ---------------------------------------------------------------------------
install_macos() {
    if ! command -v brew >/dev/null 2>&1; then
        echo "Homebrew is required. Install it first: https://brew.sh" >&2
        exit 1
    fi
    say "macOS detected — installing with Homebrew"
    brew update
    # The brew 'php' formula bundles the common extensions (mbstring, curl, pdo, etc.).
    brew install php composer
    # For a local dev DB you can use the bundled SQLite (no install needed).
    # Uncomment the next line if you want MySQL locally:
    # brew install mysql
    echo "Note: brew PHP may not include 'intl' — MetanoiaApp does not require it."
}

# ---------------------------------------------------------------------------
install_debian() {
    say "Debian/Ubuntu detected — installing with apt"
    export DEBIAN_FRONTEND=noninteractive

    sudo apt-get update
    sudo apt-get install -y software-properties-common ca-certificates curl unzip git lsb-release

    # Ondřej's PPA guarantees a recent PHP on Ubuntu (skip if your distro already has php8.3)
    if [ -f /etc/lsb-release ] && grep -qi ubuntu /etc/lsb-release; then
        sudo add-apt-repository -y ppa:ondrej/php
        sudo apt-get update
    fi

    say "Installing PHP ${PHP_VER} + extensions"
    sudo apt-get install -y \
        "php${PHP_VER}" "php${PHP_VER}-fpm" "php${PHP_VER}-cli" "php${PHP_VER}-common" \
        "php${PHP_VER}-mysql" "php${PHP_VER}-mbstring" "php${PHP_VER}-xml" \
        "php${PHP_VER}-curl" "php${PHP_VER}-zip" "php${PHP_VER}-bcmath" \
        "php${PHP_VER}-intl" "php${PHP_VER}-gd" "php${PHP_VER}-sqlite3"

    say "Installing Composer"
    if ! command -v composer >/dev/null 2>&1; then
        EXPECTED="$(curl -sS https://composer.github.io/installer.sig)"
        curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php
        ACTUAL="$(php -r "echo hash_file('sha384','/tmp/composer-setup.php');")"
        [ "$EXPECTED" = "$ACTUAL" ] || { echo "Composer installer checksum mismatch" >&2; exit 1; }
        sudo php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer
        rm -f /tmp/composer-setup.php
    fi

    say "Installing Nginx + MySQL"
    sudo apt-get install -y nginx mysql-server

    sudo systemctl enable --now "php${PHP_VER}-fpm" nginx mysql
}

# ---------------------------------------------------------------------------
case "$(uname -s)" in
    Darwin) install_macos ;;
    Linux)  install_debian ;;
    *) echo "Unsupported OS: $(uname -s)" >&2; exit 1 ;;
esac

say "Done. Installed versions:"
echo "node:     $(node -v 2>/dev/null || echo 'NOT FOUND — install Node 20+')"
echo "npm:      $(npm -v 2>/dev/null || echo 'NOT FOUND')"
echo "php:      $(php -v | head -1)"
echo "composer: $(composer --version 2>/dev/null || echo 'NOT FOUND')"

cat <<'NEXT'

Next steps (in the project folder):
  composer install --no-dev --optimize-autoloader
  npm ci && npm run build
  cp .env.example .env && php artisan key:generate --force
  # edit .env (DB, MAIL, APP_URL, APP_ENV=production, APP_DEBUG=false)
  php artisan migrate --force
  php artisan app:make-admin --name="Admin" --email="admin@metanoiaenergy.com" --password="..."
  php artisan storage:link && php artisan optimize

See DEPLOYMENT.md for the Nginx config, HTTPS, and the rest.
NEXT
