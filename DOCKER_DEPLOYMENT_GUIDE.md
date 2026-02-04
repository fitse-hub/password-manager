# 🐳 Docker Deployment Guide - Password Manager

## 📋 Overview

This guide will help you deploy your Laravel 12 + PHP 8.4 Password Manager using Docker.

**What's Included:**
- ✅ PHP 8.4 with Apache
- ✅ MySQL 8.0 Database
- ✅ phpMyAdmin (Database Management)
- ✅ Production-ready configuration
- ✅ Automatic migrations
- ✅ Optimized for performance

---

## 📦 Files Created

### Docker Configuration Files

1. **Dockerfile** - PHP 8.4 + Apache container configuration
2. **docker-compose.yml** - Multi-container orchestration
3. **docker/apache/000-default.conf** - Apache virtual host configuration
4. **.env.docker** - Docker environment variables
5. **.dockerignore** - Files to exclude from Docker build
6. **docker-entrypoint.sh** - Startup script

---

## 🚀 Quick Start (3 Steps)

### Step 1: Install Docker

**Windows:**
- Download Docker Desktop: https://www.docker.com/products/docker-desktop
- Install and restart your computer
- Verify: `docker --version`

**Mac:**
- Download Docker Desktop: https://www.docker.com/products/docker-desktop
- Install and start Docker Desktop
- Verify: `docker --version`

**Linux:**
```bash
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh
sudo usermod -aG docker $USER
```

### Step 2: Build and Run

```bash
# Build and start containers
docker compose up --build -d

# Or use this command (same thing)
docker-compose up --build -d
```

**What happens:**
- ✅ Builds PHP 8.4 + Apache container
- ✅ Pulls MySQL 8.0 image
- ✅ Pulls phpMyAdmin image
- ✅ Creates network and volumes
- ✅ Starts all services
- ✅ Runs database migrations
- ✅ Optimizes Laravel

### Step 3: Access Your Application

**Password Manager:** http://localhost:8000

**phpMyAdmin:** http://localhost:8080
- Username: `laravel`
- Password: `secret`

---

## 🎯 Docker Services

### Service 1: Laravel Application (app)
- **Port:** 8000
- **Container:** password_manager_app
- **PHP Version:** 8.4
- **Web Server:** Apache
- **Auto-restart:** Yes

### Service 2: MySQL Database (mysql)
- **Port:** 3306
- **Container:** password_manager_mysql
- **Version:** MySQL 8.0
- **Database:** password_manager
- **Username:** laravel
- **Password:** secret
- **Root Password:** root_secret_password

### Service 3: phpMyAdmin (phpmyadmin)
- **Port:** 8080
- **Container:** password_manager_phpmyadmin
- **Access:** http://localhost:8080

---

## 🔧 Docker Commands

### Start Containers
```bash
# Start in background
docker compose up -d

# Start with logs
docker compose up

# Rebuild and start
docker compose up --build -d
```

### Stop Containers
```bash
# Stop all containers
docker compose down

# Stop and remove volumes (⚠️ deletes database)
docker compose down -v
```

### View Logs
```bash
# All services
docker compose logs

# Specific service
docker compose logs app
docker compose logs mysql

# Follow logs (live)
docker compose logs -f app
```

### Execute Commands in Container
```bash
# Access Laravel container shell
docker compose exec app bash

# Run artisan commands
docker compose exec app php artisan migrate
docker compose exec app php artisan cache:clear
docker compose exec app php artisan config:clear

# Run composer commands
docker compose exec app composer install
docker compose exec app composer update
```

### Container Status
```bash
# List running containers
docker compose ps

# View container details
docker compose ps -a
```

### Restart Services
```bash
# Restart all services
docker compose restart

# Restart specific service
docker compose restart app
docker compose restart mysql
```

---

## 📊 Database Management

### Using phpMyAdmin

1. **Access:** http://localhost:8080
2. **Login:**
   - Server: `mysql`
   - Username: `laravel`
   - Password: `secret`
3. **Database:** password_manager

### Using MySQL CLI

```bash
# Access MySQL container
docker compose exec mysql mysql -u laravel -p

# Enter password: secret

# Show databases
SHOW DATABASES;

# Use password_manager database
USE password_manager;

# Show tables
SHOW TABLES;

# Query users
SELECT * FROM users;
```

### Backup Database

```bash
# Export database
docker compose exec mysql mysqldump -u laravel -psecret password_manager > backup.sql

# Import database
docker compose exec -T mysql mysql -u laravel -psecret password_manager < backup.sql
```

---

## 🔒 Environment Configuration

### Development Environment

Use `.env` file (current configuration)

### Production Environment

Use `.env.docker` file:

```bash
# Copy Docker environment file
cp .env.docker .env

# Update APP_KEY if needed
docker compose exec app php artisan key:generate

# Clear cache
docker compose exec app php artisan config:clear
```

### Important Environment Variables

```env
# Application
APP_ENV=production
APP_DEBUG=false
APP_URL=http://localhost:8000

# Database (Docker)
DB_HOST=mysql          # ⚠️ IMPORTANT: Use service name
DB_PORT=3306
DB_DATABASE=password_manager
DB_USERNAME=laravel
DB_PASSWORD=secret

# Email (Gmail SMTP)
MAIL_HOST=smtp.gmail.com
MAIL_USERNAME=securevault.official@gmail.com
MAIL_PASSWORD=bpomkmdszhhepzqu
```

---

## 🚀 Production Deployment

### Step 1: Update Environment Variables

Edit `.env.docker`:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Strong database password
DB_PASSWORD=your_strong_password_here

# Update MySQL root password in docker-compose.yml
MYSQL_ROOT_PASSWORD=your_strong_root_password
```

### Step 2: Update docker-compose.yml

```yaml
# Remove phpMyAdmin in production
# Comment out or delete the phpmyadmin service

# Update ports if needed
ports:
  - "80:80"  # Use port 80 for production
```

### Step 3: Build and Deploy

```bash
# Build for production
docker compose -f docker-compose.yml up --build -d

# Run migrations
docker compose exec app php artisan migrate --force

# Optimize
docker compose exec app php artisan optimize
```

### Step 4: Set Up SSL (HTTPS)

Use a reverse proxy like Nginx or Traefik with Let's Encrypt.

---

## 🔍 Troubleshooting

### Problem: Containers won't start

**Solution:**
```bash
# Check logs
docker compose logs

# Check if ports are in use
netstat -ano | findstr :8000
netstat -ano | findstr :3306

# Stop and remove containers
docker compose down

# Rebuild
docker compose up --build -d
```

### Problem: Database connection failed

**Solution:**
```bash
# Check MySQL is running
docker compose ps mysql

# Check MySQL logs
docker compose logs mysql

# Verify DB_HOST in .env
# Must be: DB_HOST=mysql (not localhost or 127.0.0.1)

# Restart containers
docker compose restart
```

### Problem: Permission denied errors

**Solution:**
```bash
# Fix permissions
docker compose exec app chown -R www-data:www-data /var/www/html/storage
docker compose exec app chmod -R 775 /var/www/html/storage
docker compose exec app chmod -R 775 /var/www/html/bootstrap/cache
```

### Problem: Changes not reflecting

**Solution:**
```bash
# Clear all caches
docker compose exec app php artisan cache:clear
docker compose exec app php artisan config:clear
docker compose exec app php artisan view:clear
docker compose exec app php artisan route:clear

# Restart container
docker compose restart app
```

### Problem: MySQL data lost after restart

**Cause:** Volume not persisted

**Solution:**
```bash
# Check volumes
docker volume ls

# Volumes are defined in docker-compose.yml
# Data persists in: mysql_data volume
```

---

## 📈 Performance Optimization

### Laravel Optimizations

```bash
# Run all optimizations
docker compose exec app php artisan optimize

# Individual optimizations
docker compose exec app php artisan config:cache
docker compose exec app php artisan route:cache
docker compose exec app php artisan view:cache
docker compose exec app composer dump-autoload --optimize
```

### Docker Optimizations

1. **Use .dockerignore** - Already configured
2. **Multi-stage builds** - Can be added for smaller images
3. **Layer caching** - Order Dockerfile commands properly
4. **Volume mounts** - Use for development only

---

## 🔄 Development Workflow

### Local Development with Docker

```bash
# Start containers
docker compose up -d

# Watch logs
docker compose logs -f app

# Make code changes (auto-reflected)

# Run migrations
docker compose exec app php artisan migrate

# Clear cache
docker compose exec app php artisan cache:clear

# Stop containers
docker compose down
```

### Hot Reload (Optional)

Add to docker-compose.yml:

```yaml
volumes:
  - .:/var/www/html  # Mount entire project
```

---

## 📝 Useful Commands Cheat Sheet

```bash
# Start
docker compose up -d

# Stop
docker compose down

# Rebuild
docker compose up --build -d

# Logs
docker compose logs -f app

# Shell access
docker compose exec app bash

# Artisan commands
docker compose exec app php artisan migrate
docker compose exec app php artisan cache:clear
docker compose exec app php artisan optimize

# Database backup
docker compose exec mysql mysqldump -u laravel -psecret password_manager > backup.sql

# Database restore
docker compose exec -T mysql mysql -u laravel -psecret password_manager < backup.sql

# View running containers
docker compose ps

# Restart service
docker compose restart app

# Remove everything (⚠️ including volumes)
docker compose down -v
```

---

## 🎯 Testing Your Deployment

### Test 1: Application Access

1. Open: http://localhost:8000
2. Should see welcome page
3. Register a new user
4. Login and test features

### Test 2: Database Connection

1. Open: http://localhost:8080 (phpMyAdmin)
2. Login with credentials
3. Check `password_manager` database
4. Verify tables exist

### Test 3: Email Functionality

```bash
# Test email
docker compose exec app php artisan email:test
```

### Test 4: Migrations

```bash
# Run migrations
docker compose exec app php artisan migrate:status
```

---

## 🌐 Hosting Platforms

### Recommended Docker Hosting

1. **DigitalOcean App Platform**
   - Easy Docker deployment
   - $5/month starter plan
   - Automatic SSL

2. **AWS ECS (Elastic Container Service)**
   - Scalable
   - Pay-as-you-go
   - Full control

3. **Google Cloud Run**
   - Serverless containers
   - Auto-scaling
   - Free tier available

4. **Heroku**
   - Easy deployment
   - Container support
   - Free tier (limited)

5. **Railway.app**
   - Simple Docker deployment
   - Free tier
   - Great for testing

---

## 📊 Monitoring

### View Container Stats

```bash
# Real-time stats
docker stats

# Specific container
docker stats password_manager_app
```

### View Logs

```bash
# Application logs
docker compose logs -f app

# MySQL logs
docker compose logs -f mysql

# All logs
docker compose logs -f
```

---

## 🎉 Success Checklist

- [ ] Docker installed
- [ ] Containers built successfully
- [ ] Application accessible at http://localhost:8000
- [ ] phpMyAdmin accessible at http://localhost:8080
- [ ] Database connection working
- [ ] Migrations ran successfully
- [ ] Can register and login
- [ ] Email functionality tested
- [ ] All features working

---

## 📞 Support

**Docker Documentation:** https://docs.docker.com

**Docker Compose:** https://docs.docker.com/compose

**Laravel Docker:** https://laravel.com/docs/deployment

**Troubleshooting:** Check `docker compose logs`

---

**Deployment Date:** February 4, 2026

**Status:** ✅ Ready for Docker deployment

**Next Action:** Run `docker compose up --build -d`

---

🐳 **Your Password Manager is ready for Docker deployment!**
