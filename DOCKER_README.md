# 🐳 Docker Deployment - Quick Start

## ⚡ Super Quick Start (Windows)

### Option 1: Using Batch Files (Easiest)

```bash
# Start containers
docker-start.bat

# Stop containers
docker-stop.bat
```

### Option 2: Using Commands

```bash
# Start
docker compose up --build -d

# Stop
docker compose down
```

---

## 📋 What You Get

- ✅ **Laravel 12** with PHP 8.4
- ✅ **Apache** web server
- ✅ **MySQL 8.0** database
- ✅ **phpMyAdmin** for database management
- ✅ **Production-ready** configuration
- ✅ **Automatic migrations**
- ✅ **Email functionality** (Gmail SMTP)

---

## 🚀 Access Your Application

After running `docker-start.bat` or `docker compose up -d`:

**Password Manager:** http://localhost:8000

**phpMyAdmin:** http://localhost:8080
- Username: `laravel`
- Password: `secret`

---

## 📦 Files Structure

```
password-manager/
├── Dockerfile                      # PHP 8.4 + Apache container
├── docker-compose.yml              # Multi-container setup
├── docker/
│   └── apache/
│       └── 000-default.conf        # Apache configuration
├── .env.docker                     # Docker environment variables
├── .dockerignore                   # Files to exclude
├── docker-entrypoint.sh            # Startup script
├── docker-start.bat                # Windows start script
├── docker-stop.bat                 # Windows stop script
├── DOCKER_DEPLOYMENT_GUIDE.md      # Complete guide
└── DOCKER_README.md                # This file
```

---

## 🔧 Common Commands

### Start/Stop

```bash
# Start containers (background)
docker compose up -d

# Start containers (with logs)
docker compose up

# Stop containers
docker compose down

# Restart containers
docker compose restart
```

### View Logs

```bash
# All logs
docker compose logs

# Application logs
docker compose logs app

# Follow logs (live)
docker compose logs -f app
```

### Run Laravel Commands

```bash
# Access container shell
docker compose exec app bash

# Run migrations
docker compose exec app php artisan migrate

# Clear cache
docker compose exec app php artisan cache:clear

# Test email
docker compose exec app php artisan email:test

# Optimize application
docker compose exec app php artisan optimize
```

### Database Management

```bash
# Access MySQL
docker compose exec mysql mysql -u laravel -p
# Password: secret

# Backup database
docker compose exec mysql mysqldump -u laravel -psecret password_manager > backup.sql

# Restore database
docker compose exec -T mysql mysql -u laravel -psecret password_manager < backup.sql
```

---

## 🔍 Troubleshooting

### Problem: Port already in use

**Error:** `Bind for 0.0.0.0:8000 failed: port is already allocated`

**Solution:**
```bash
# Check what's using the port
netstat -ano | findstr :8000

# Stop the process or change port in docker-compose.yml
ports:
  - "8001:80"  # Use different port
```

### Problem: Database connection failed

**Solution:**
```bash
# Check MySQL is running
docker compose ps mysql

# Restart containers
docker compose restart

# Check logs
docker compose logs mysql
```

### Problem: Changes not reflecting

**Solution:**
```bash
# Clear all caches
docker compose exec app php artisan cache:clear
docker compose exec app php artisan config:clear
docker compose exec app php artisan view:clear

# Restart
docker compose restart app
```

### Problem: Permission errors

**Solution:**
```bash
# Fix permissions
docker compose exec app chown -R www-data:www-data /var/www/html/storage
docker compose exec app chmod -R 775 /var/www/html/storage
```

---

## 📊 Container Status

```bash
# List running containers
docker compose ps

# View container stats
docker stats

# View container details
docker inspect password_manager_app
```

---

## 🔒 Security Notes

### Development (Current Setup)

- Database password: `secret`
- Root password: `root_secret_password`
- Debug mode: `false`

### Production Deployment

**Update these in `.env.docker`:**

```env
# Strong passwords
DB_PASSWORD=your_strong_password_here
MYSQL_ROOT_PASSWORD=your_strong_root_password

# Production settings
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Remove phpMyAdmin from docker-compose.yml
```

---

## 🌐 Deployment to Cloud

### DigitalOcean

1. Create Droplet with Docker
2. Clone your repository
3. Run `docker compose up -d`
4. Configure domain and SSL

### AWS ECS

1. Push image to ECR
2. Create ECS cluster
3. Define task and service
4. Configure load balancer

### Railway.app

1. Connect GitHub repository
2. Railway auto-detects Docker
3. Deploy automatically
4. Get public URL

---

## 📈 Performance Tips

### Optimize Laravel

```bash
# Run all optimizations
docker compose exec app php artisan optimize

# Cache configuration
docker compose exec app php artisan config:cache

# Cache routes
docker compose exec app php artisan route:cache

# Cache views
docker compose exec app php artisan view:cache
```

### Monitor Resources

```bash
# Real-time stats
docker stats

# Container logs
docker compose logs -f
```

---

## 🎯 Testing Checklist

- [ ] Containers start successfully
- [ ] Application loads at http://localhost:8000
- [ ] Can register new user
- [ ] Can login
- [ ] Email verification works
- [ ] Password reset works
- [ ] All features functional
- [ ] phpMyAdmin accessible
- [ ] Database connection working

---

## 📞 Quick Reference

**Start:** `docker-start.bat` or `docker compose up -d`

**Stop:** `docker-stop.bat` or `docker compose down`

**Logs:** `docker compose logs -f app`

**Shell:** `docker compose exec app bash`

**Migrate:** `docker compose exec app php artisan migrate`

**Cache Clear:** `docker compose exec app php artisan cache:clear`

**Optimize:** `docker compose exec app php artisan optimize`

---

## 🎉 Success!

Your Password Manager is now running in Docker containers!

**Application:** http://localhost:8000

**Database:** http://localhost:8080

**Documentation:** See `DOCKER_DEPLOYMENT_GUIDE.md` for complete guide

---

**Need Help?**

- Check logs: `docker compose logs -f`
- Read guide: `DOCKER_DEPLOYMENT_GUIDE.md`
- Docker docs: https://docs.docker.com

---

🐳 **Happy Dockerizing!**
