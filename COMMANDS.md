# 🛠️ Command Reference

Quick reference for all common commands used in the Password Manager project.

## 📦 Installation Commands

### Initial Setup
```bash
# Clone repository
git clone <repository-url>
cd Password_Manager

# Install PHP dependencies
composer install

# Install Node dependencies
npm install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Create database
mysql -u root -p -e "CREATE DATABASE password_manager;"

# Run migrations
php artisan migrate

# Build assets
npm run build
```

### Quick Setup (All-in-One)
```bash
composer install && npm install && cp .env.example .env && php artisan key:generate && php artisan migrate && npm run build
```

## 🚀 Development Commands

### Start Development Server
```bash
# Laravel server only
php artisan serve

# All services (server + vite + queue)
composer run dev
```

### Asset Compilation
```bash
# Development build
npm run dev

# Production build
npm run build

# Watch mode (auto-rebuild)
npm run dev
```

## 🗄️ Database Commands

### Migrations
```bash
# Run migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Rollback all migrations
php artisan migrate:reset

# Fresh migration (drop all tables)
php artisan migrate:fresh

# Refresh migrations (rollback + migrate)
php artisan migrate:refresh

# Check migration status
php artisan migrate:status
```

### Seeders
```bash
# Run all seeders
php artisan db:seed

# Run specific seeder
php artisan db:seed --class=DefaultCategoriesSeeder

# Fresh migration with seeding
php artisan migrate:fresh --seed
```

### Database Inspection
```bash
# Open Tinker (Laravel REPL)
php artisan tinker

# Test database connection
php artisan tinker
>>> DB::connection()->getPdo();

# Count users
php artisan tinker
>>> App\Models\User::count();
```

## 🔧 Artisan Commands

### Cache Management
```bash
# Clear all caches
php artisan optimize:clear

# Clear specific caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Cache for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### Code Generation
```bash
# Create controller
php artisan make:controller ControllerName

# Create model
php artisan make:model ModelName

# Create migration
php artisan make:migration create_table_name

# Create seeder
php artisan make:seeder SeederName

# Create policy
php artisan make:policy PolicyName --model=ModelName

# Create middleware
php artisan make:middleware MiddlewareName

# Create request
php artisan make:request RequestName
```

### Application Info
```bash
# Show application info
php artisan about

# List all routes
php artisan route:list

# Show specific route
php artisan route:list --name=dashboard

# List all commands
php artisan list
```

## 🧪 Testing Commands

### Run Tests
```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/ExampleTest.php

# Run with coverage
php artisan test --coverage

# Run in parallel
php artisan test --parallel
```

### Code Quality
```bash
# Run Pint (code style fixer)
./vendor/bin/pint

# Check code style without fixing
./vendor/bin/pint --test
```

## 🔐 Security Commands

### Key Management
```bash
# Generate new application key
php artisan key:generate

# Show current key
php artisan tinker
>>> config('app.key');
```

### Session Management
```bash
# Clear sessions
php artisan session:table
php artisan migrate
```

## 📊 Queue Commands

### Queue Workers
```bash
# Start queue worker
php artisan queue:work

# Start with specific connection
php artisan queue:work database

# Process one job
php artisan queue:work --once

# Restart all workers
php artisan queue:restart

# List failed jobs
php artisan queue:failed

# Retry failed job
php artisan queue:retry <job-id>

# Retry all failed jobs
php artisan queue:retry all
```

## 🔄 Maintenance Commands

### Application Maintenance
```bash
# Put application in maintenance mode
php artisan down

# Bring application back up
php artisan up

# Down with secret bypass
php artisan down --secret="bypass-token"
# Access: https://yourdomain.com/bypass-token
```

### Storage Commands
```bash
# Create storage link
php artisan storage:link

# Clear storage
rm -rf storage/framework/cache/*
rm -rf storage/framework/sessions/*
rm -rf storage/framework/views/*
```

## 📝 Log Commands

### View Logs
```bash
# Tail Laravel log
tail -f storage/logs/laravel.log

# View last 50 lines
tail -n 50 storage/logs/laravel.log

# Clear logs
> storage/logs/laravel.log
```

## 🌐 Server Commands

### PHP Built-in Server
```bash
# Start on default port (8000)
php artisan serve

# Start on specific port
php artisan serve --port=8080

# Start on specific host
php artisan serve --host=0.0.0.0

# Start on specific host and port
php artisan serve --host=0.0.0.0 --port=8080
```

## 🔍 Debugging Commands

### Debug Information
```bash
# Show environment
php artisan env

# Show configuration
php artisan config:show

# Show routes with details
php artisan route:list -v

# Show database tables
php artisan tinker
>>> DB::select('SHOW TABLES');
```

### Performance Profiling
```bash
# Show slow queries
php artisan tinker
>>> DB::enableQueryLog();
>>> // Run your code
>>> DB::getQueryLog();
```

## 📦 Composer Commands

### Dependency Management
```bash
# Install dependencies
composer install

# Install for production
composer install --optimize-autoloader --no-dev

# Update dependencies
composer update

# Update specific package
composer update vendor/package

# Show installed packages
composer show

# Dump autoload
composer dump-autoload
```

## 📦 NPM Commands

### Package Management
```bash
# Install dependencies
npm install

# Install specific package
npm install package-name

# Install dev dependency
npm install --save-dev package-name

# Update dependencies
npm update

# Remove package
npm uninstall package-name

# List installed packages
npm list
```

## 🚀 Production Commands

### Deployment
```bash
# Pull latest code
git pull origin main

# Install dependencies
composer install --optimize-autoloader --no-dev
npm install

# Build assets
npm run build

# Run migrations
php artisan migrate --force

# Clear and cache
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Restart services
sudo systemctl restart php8.2-fpm
sudo supervisorctl restart password-manager-worker:*
```

### Backup
```bash
# Backup database
mysqldump -u username -p database_name > backup.sql

# Backup with gzip
mysqldump -u username -p database_name | gzip > backup.sql.gz

# Restore database
mysql -u username -p database_name < backup.sql
```

## 🔧 Troubleshooting Commands

### Permission Issues
```bash
# Fix storage permissions
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

# Fix all permissions
sudo chown -R www-data:www-data .
sudo chmod -R 755 .
sudo chmod -R 775 storage bootstrap/cache
```

### Clear Everything
```bash
# Nuclear option - clear all caches
php artisan optimize:clear
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
composer dump-autoload
npm run build
```

### Reset Application
```bash
# Complete reset
php artisan migrate:fresh
php artisan optimize:clear
npm run build
```

## 📊 Monitoring Commands

### System Status
```bash
# Check PHP version
php -v

# Check Laravel version
php artisan --version

# Check Composer version
composer --version

# Check Node version
node -v

# Check NPM version
npm -v

# Check MySQL version
mysql --version
```

### Service Status
```bash
# Check PHP-FPM
sudo systemctl status php8.2-fpm

# Check Nginx
sudo systemctl status nginx

# Check MySQL
sudo systemctl status mysql

# Check Redis
sudo systemctl status redis

# Check Supervisor
sudo supervisorctl status
```

## 🎯 Quick Commands

### Daily Development
```bash
# Start working
composer run dev

# Run migrations
php artisan migrate

# Clear cache
php artisan optimize:clear

# Run tests
php artisan test
```

### Before Commit
```bash
# Fix code style
./vendor/bin/pint

# Run tests
php artisan test

# Check for errors
php artisan about
```

### Before Deployment
```bash
# Build assets
npm run build

# Run migrations
php artisan migrate --force

# Cache everything
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

## 📚 Help Commands

### Get Help
```bash
# General help
php artisan help

# Help for specific command
php artisan help migrate

# List all commands
php artisan list

# Show application info
php artisan about
```

## 🔗 Useful Aliases

Add to your `.bashrc` or `.zshrc`:

```bash
# Laravel aliases
alias pa='php artisan'
alias pas='php artisan serve'
alias pam='php artisan migrate'
alias pamf='php artisan migrate:fresh'
alias pac='php artisan optimize:clear'
alias pat='php artisan test'

# Composer aliases
alias ci='composer install'
alias cu='composer update'
alias cda='composer dump-autoload'

# NPM aliases
alias ni='npm install'
alias nb='npm run build'
alias nd='npm run dev'

# Git aliases
alias gs='git status'
alias ga='git add .'
alias gc='git commit -m'
alias gp='git push'
```

---

**Last Updated:** February 3, 2026
**Version:** 1.0.0

**Tip:** Bookmark this file for quick reference! 📌
