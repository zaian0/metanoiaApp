# MetanoiaApp — Production Deployment

Laravel 12 + Inertia + Vue 3 single application. This is a PHP app: it needs
PHP-FPM, a web server (Nginx), and a database — not just static files.

---

## 1. Server prerequisites

Install on the server (Ubuntu example):

```bash
sudo apt update
sudo apt install -y nginx php8.3-fpm php8.3-cli php8.3-mysql php8.3-mbstring \
     php8.3-xml php8.3-curl php8.3-zip php8.3-bcmath php8.3-intl unzip git
# Composer
curl -sS https://getcomposer.org/installer | php && sudo mv composer.phar /usr/local/bin/composer
# Node 20+ (only needed to BUILD the front-end assets)
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash - && sudo apt install -y nodejs
# MySQL (or use a managed DB)
sudo apt install -y mysql-server
```

Required PHP extensions: `mbstring, xml, curl, zip, bcmath, pdo_mysql, intl, openssl`.
PHP **8.3+** (8.5 fine).

Create the database:

```sql
CREATE DATABASE metanoia CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'metanoia'@'localhost' IDENTIFIED BY 'a-strong-password';
GRANT ALL PRIVILEGES ON metanoia.* TO 'metanoia'@'localhost';
FLUSH PRIVILEGES;
```

---

## 2. Get the code

```bash
sudo mkdir -p /var/www/MetanoiaApp && sudo chown -R $USER:www-data /var/www/MetanoiaApp
cd /var/www/MetanoiaApp
git clone <your-repo-url> .          # or rsync/upload the project (NOT node_modules / vendor / .env)
```

> The `dev-server.php` file in the repo is for local previewing only — it is not used in production.

---

## 3. Install dependencies + build assets

```bash
# PHP deps (production, optimized)
composer install --no-dev --optimize-autoloader

# Front-end build (compiles Vue/Inertia into public/build)
npm ci
npm run build
```

(You can build assets on a CI/build machine instead and deploy `public/build/` — Node
is only needed for the build, not at runtime.)

---

## 4. Environment configuration

```bash
cp .env.example .env
php artisan key:generate --force
nano .env
```

Set at minimum:

```dotenv
APP_NAME="Metanoia Energy"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://metanoiaenergy.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=metanoia
DB_USERNAME=metanoia
DB_PASSWORD=a-strong-password

# Real SMTP so quote emails actually send (example: a transactional provider)
MAIL_MAILER=smtp
MAIL_HOST=smtp.yourprovider.com
MAIL_PORT=587
MAIL_USERNAME=...
MAIL_PASSWORD=...
MAIL_FROM_ADDRESS="no-reply@metanoiaenergy.com"
MAIL_FROM_NAME="${APP_NAME}"

# Where new quote requests are emailed
QUOTE_NOTIFY_TO=info@metanoiaenergy.com
```

⚠️ `APP_DEBUG=false` and `APP_ENV=production` are mandatory for security.

---

## 5. Database + admin + storage

```bash
php artisan migrate --force

# Create the dashboard admin (interactive, or pass flags)
php artisan app:make-admin --name="Admin" --email="admin@metanoiaenergy.com" --password="a-strong-password"

php artisan storage:link
```

---

## 6. Cache & optimize (run on every deploy)

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

---

## 7. Permissions

```bash
sudo chown -R www-data:www-data /var/www/MetanoiaApp
sudo find /var/www/MetanoiaApp -type d -exec chmod 755 {} \;
sudo find /var/www/MetanoiaApp -type f -exec chmod 644 {} \;
# storage + cache must be writable by the web user
sudo chmod -R 775 storage bootstrap/cache
```

---

## 8. Nginx (document root = the `public/` folder)

`/etc/nginx/sites-available/metanoiaenergy.com`:

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name metanoiaenergy.com www.metanoiaenergy.com;

    root /var/www/MetanoiaApp/public;   # ← MUST be the public/ subfolder
    index index.php;

    charset utf-8;
    client_max_body_size 20M;

    location / {
        try_files $uri $uri/ /index.php?$query_string;   # route everything to Laravel
    }

    location ~ \.php$ {
        fastcgi_pass unix:/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # cache built assets (Vite content-hashes them)
    location /build/ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }

    location ~ /\.(?!well-known).* { deny all; }   # block dotfiles, allow ACME
    location = /favicon.ico { access_log off; log_not_found off; }
}
```

```bash
sudo ln -s /etc/nginx/sites-available/metanoiaenergy.com /etc/nginx/sites-enabled/
sudo nginx -t && sudo systemctl reload nginx
```

---

## 9. HTTPS (Let's Encrypt)

```bash
sudo apt install -y certbot python3-certbot-nginx
sudo certbot --nginx -d metanoiaenergy.com -d www.metanoiaenergy.com --redirect
sudo certbot renew --dry-run
```

---

## 10. Background workers (recommended)

**Scheduler** (cron) — add to `crontab -e`:
```
* * * * * cd /var/www/MetanoiaApp && php artisan schedule:run >> /dev/null 2>&1
```

**Queue** (optional, if you switch emails to `QUEUE_CONNECTION=database` so the form
responds instantly): run a Supervisor worker:
```ini
[program:metanoia-queue]
command=php /var/www/MetanoiaApp/artisan queue:work --sleep=3 --tries=3
user=www-data
autostart=true
autorestart=true
numprocs=1
```

---

## 11. SSR for SEO (optional — when enabled)

The public marketing pages currently render client-side. To serve crawlers
server-rendered HTML, enable Inertia SSR (`npm run build` then run the SSR node
process under Supervisor):
```ini
[program:metanoia-ssr]
command=php /var/www/MetanoiaApp/artisan inertia:start-ssr
user=www-data
autostart=true
autorestart=true
```
(SSR is a planned step — until then the site works, but public pages are JS-rendered.)

---

## 12. Redeploy (each update)

```bash
cd /var/www/MetanoiaApp
php artisan down
git pull
composer install --no-dev --optimize-autoloader
npm ci && npm run build
php artisan migrate --force
php artisan optimize        # re-caches config/routes/views
php artisan up
```

---

## Quick smoke test after go-live

```bash
curl -I https://metanoiaenergy.com/            # 200, public site
# /quote loads, submitting saves to DB + emails info@metanoiaenergy.com + customer
# /login → dashboard works with the admin you created
```
