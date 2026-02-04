# 🚀 Deployment Guide

Complete guide for deploying the Password Manager to production.

## Pre-Deployment Checklist

### Security
- [ ] Change APP_KEY in production
- [ ] Set APP_ENV=production
- [ ] Set APP_DEBUG=false
- [ ] Configure HTTPS/SSL certificate
- [ ] Set secure session cookies
- [ ] Configure CORS if needed
- [ ] Review and set security headers
- [ ] Enable rate limiting
- [ ] Configure firewall rules

### Database
- [ ] Create production database
- [ ] Configure database credentials
- [ ] Run migrations
- [ ] Set up database backups
- [ ] Configure connection pooling

### Performance
- [ ] Run `php artisan optimize`
- [ ] Run `npm run build`
- [ ] Enable OPcache
- [ ] Configure Redis/Memcached
- [ ] Set up queue workers
- [ ] Configure cron jobs

### Monitoring
- [ ] Set up error logging
- [ ] Configure log rotation
- [ ] Set up uptime monitoring
- [ ] Configure backup strategy
- [ ] Set up performance monitoring

## Environment Configuration

### Production .env

```env
APP_NAME="Password Manager"
APP_ENV=production
APP_KEY=base64:YOUR_PRODUCTION_KEY_HERE
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=your-db-host
DB_PORT=3306
DB_DATABASE=password_manager_prod
DB_USERNAME=your-db-user
DB_PASSWORD=your-secure-password

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=true
SESSION_SECURE_COOKIE=true

CACHE_STORE=redis
QUEUE_CONNECTION=redis

REDIS_HOST=your-redis-host
REDIS_PASSWORD=your-redis-password
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=your-mail-host
MAIL_PORT=587
MAIL_USERNAME=your-mail-username
MAIL_PASSWORD=your-mail-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@yourdomain.com"
MAIL_FROM_NAME="${APP_NAME}"
```

## Deployment Steps

### 1. Server Setup

#### Requirements
- Ubuntu 20.04+ or similar
- PHP 8.2+
- MySQL 8.0+
- Nginx or Apache
- Redis (recommended)
- Supervisor (for queues)

#### Install Dependencies

```bash
# Update system
sudo apt update && sudo apt upgrade -y

# Install PHP and extensions
sudo apt install php8.2-fpm php8.2-mysql php8.2-mbstring php8.2-xml php8.2-bcmath php8.2-curl php8.2-zip php8.2-redis -y

# Install MySQL
sudo apt install mysql-server -y

# Install Redis
sudo apt install redis-server -y

# Install Nginx
sudo apt install nginx -y

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install Node.js
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt install nodejs -y
```

### 2. Application Deployment

```bash
# Clone repository
cd /var/www
sudo git clone your-repo-url password-manager
cd password-manager

# Set permissions
sudo chown -R www-data:www-data /var/www/password-manager
sudo chmod -R 755 /var/www/password-manager
sudo chmod -R 775 storage bootstrap/cache

# Install dependencies
composer install --optimize-autoloader --no-dev
npm install
npm run build

# Configure environment
cp .env.example .env
nano .env  # Edit with production values
php artisan key:generate

# Run migrations
php artisan migrate --force

# Optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### 3. Nginx Configuration

Create `/etc/nginx/sites-available/password-manager`:

```nginx
server {
    listen 80;
    server_name yourdomain.com www.yourdomain.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name yourdomain.com www.yourdomain.com;
    root /var/www/password-manager/public;

    # SSL Configuration
    ssl_certificate /etc/letsencrypt/live/yourdomain.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/yourdomain.com/privkey.pem;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;

    # Security Headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "no-referrer-when-downgrade" always;
    add_header Content-Security-Policy "default-src 'self' http: https: data: blob: 'unsafe-inline'" always;
    add_header Strict-Transport-Security "max-age=31536000; includeSubDomains" always;

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Enable site:
```bash
sudo ln -s /etc/nginx/sites-available/password-manager /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

### 4. SSL Certificate (Let's Encrypt)

```bash
# Install Certbot
sudo apt install certbot python3-certbot-nginx -y

# Obtain certificate
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com

# Auto-renewal
sudo certbot renew --dry-run
```

### 5. Queue Worker Setup

Create `/etc/supervisor/conf.d/password-manager-worker.conf`:

```ini
[program:password-manager-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/password-manager/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/password-manager/storage/logs/worker.log
stopwaitsecs=3600
```

Start supervisor:
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start password-manager-worker:*
```

### 6. Cron Jobs

Add to crontab:
```bash
sudo crontab -e -u www-data
```

Add:
```
* * * * * cd /var/www/password-manager && php artisan schedule:run >> /dev/null 2>&1
```

### 7. Database Backup

Create backup script `/usr/local/bin/backup-password-manager.sh`:

```bash
#!/bin/bash
TIMESTAMP=$(date +"%Y%m%d_%H%M%S")
BACKUP_DIR="/var/backups/password-manager"
DB_NAME="password_manager_prod"
DB_USER="your-db-user"
DB_PASS="your-db-password"

mkdir -p $BACKUP_DIR

# Database backup
mysqldump -u $DB_USER -p$DB_PASS $DB_NAME | gzip > $BACKUP_DIR/db_$TIMESTAMP.sql.gz

# Keep only last 7 days
find $BACKUP_DIR -name "db_*.sql.gz" -mtime +7 -delete

echo "Backup completed: $TIMESTAMP"
```

Make executable and add to cron:
```bash
sudo chmod +x /usr/local/bin/backup-password-manager.sh
sudo crontab -e
```

Add:
```
0 2 * * * /usr/local/bin/backup-password-manager.sh
```

## Post-Deployment

### 1. Verify Installation

```bash
# Check PHP version
php -v

# Check Laravel installation
php artisan --version

# Check database connection
php artisan migrate:status

# Check queue workers
sudo supervisorctl status

# Check logs
tail -f storage/logs/laravel.log
```

### 2. Test Application

- [ ] Visit homepage
- [ ] Register new account
- [ ] Login
- [ ] Add credential
- [ ] View encrypted password
- [ ] Update profile
- [ ] Change password
- [ ] Check activity logs

### 3. Monitoring Setup

#### Log Monitoring
```bash
# Install logrotate
sudo apt install logrotate -y

# Create config
sudo nano /etc/logrotate.d/password-manager
```

Add:
```
/var/www/password-manager/storage/logs/*.log {
    daily
    missingok
    rotate 14
    compress
    delaycompress
    notifempty
    create 0640 www-data www-data
    sharedscripts
}
```

#### Uptime Monitoring
- Set up external monitoring (UptimeRobot, Pingdom, etc.)
- Monitor: https://yourdomain.com
- Alert on downtime

### 4. Performance Optimization

```bash
# Enable OPcache
sudo nano /etc/php/8.2/fpm/php.ini
```

Add/Update:
```ini
opcache.enable=1
opcache.memory_consumption=256
opcache.interned_strings_buffer=16
opcache.max_accelerated_files=10000
opcache.revalidate_freq=2
opcache.fast_shutdown=1
```

Restart PHP-FPM:
```bash
sudo systemctl restart php8.2-fpm
```

## Maintenance

### Update Application

```bash
cd /var/www/password-manager

# Backup database first
/usr/local/bin/backup-password-manager.sh

# Pull latest code
git pull origin main

# Update dependencies
composer install --optimize-autoloader --no-dev
npm install
npm run build

# Run migrations
php artisan migrate --force

# Clear and rebuild cache
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Restart services
sudo supervisorctl restart password-manager-worker:*
sudo systemctl restart php8.2-fpm
```

### Monitor Logs

```bash
# Application logs
tail -f storage/logs/laravel.log

# Nginx access logs
tail -f /var/log/nginx/access.log

# Nginx error logs
tail -f /var/log/nginx/error.log

# PHP-FPM logs
tail -f /var/log/php8.2-fpm.log
```

## Troubleshooting

### Common Issues

**Issue: 500 Internal Server Error**
```bash
# Check logs
tail -f storage/logs/laravel.log
tail -f /var/log/nginx/error.log

# Check permissions
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

**Issue: Database Connection Failed**
```bash
# Test connection
php artisan tinker
>>> DB::connection()->getPdo();

# Check credentials in .env
```

**Issue: Queue Not Processing**
```bash
# Check supervisor
sudo supervisorctl status

# Restart workers
sudo supervisorctl restart password-manager-worker:*

# Check logs
tail -f storage/logs/worker.log
```

## Security Hardening

### Firewall Configuration

```bash
# Install UFW
sudo apt install ufw -y

# Configure rules
sudo ufw default deny incoming
sudo ufw default allow outgoing
sudo ufw allow ssh
sudo ufw allow 'Nginx Full'
sudo ufw enable
```

### Fail2Ban Setup

```bash
# Install Fail2Ban
sudo apt install fail2ban -y

# Configure
sudo nano /etc/fail2ban/jail.local
```

Add:
```ini
[nginx-http-auth]
enabled = true

[nginx-noscript]
enabled = true

[nginx-badbots]
enabled = true
```

Restart:
```bash
sudo systemctl restart fail2ban
```

## Conclusion

Your Password Manager is now deployed and secured! Remember to:
- Monitor logs regularly
- Keep backups updated
- Update dependencies
- Review security settings
- Monitor performance

For support, refer to the documentation or open an issue.

---

**Deployment Date:** _____________
**Deployed By:** _____________
**Production URL:** _____________
