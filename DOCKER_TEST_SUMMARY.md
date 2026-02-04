# 🐳 Docker Testing - Quick Summary

## What is `docker compose up --build`?

This command:
1. **Builds** your Docker image (PHP 8.4 + Apache + your app)
2. **Starts** 3 containers:
   - Laravel app (http://localhost:8000)
   - MySQL database
   - phpMyAdmin (http://localhost:8080)
3. **Runs** migrations automatically
4. **Caches** routes, views, and config

---

## 🚀 Quick Start

### Option 1: Automated Script (Recommended)
```bash
docker-test.bat
```

This script:
- Checks Docker is installed
- Prepares environment
- Builds and starts containers
- Opens your app in browser
- Shows logs

### Option 2: Manual Commands
```bash
# 1. Copy Docker environment
copy .env.docker .env

# 2. Build and start containers
docker compose up --build

# 3. Open browser
start http://localhost:8000
```

---

## 🎯 What You Get

### Running Containers
- **App Container:** Your Laravel app with Apache
- **MySQL Container:** Database server
- **phpMyAdmin Container:** Database management UI

### Access Points
- **Application:** http://localhost:8000
- **phpMyAdmin:** http://localhost:8080
  - Username: laravel
  - Password: secret

---

## ✅ Quick Testing Checklist

### 1. Check Containers (1 minute)
```bash
docker ps
```
**Expected:** 3 containers running

### 2. Test Application (5 minutes)
- [ ] Open http://localhost:8000
- [ ] Register new user
- [ ] Check email verification
- [ ] Login to dashboard
- [ ] Create credential
- [ ] View password (check decryption)

### 3. Check Database (2 minutes)
- [ ] Open http://localhost:8080
- [ ] Login with: laravel / secret
- [ ] Check `password_manager` database
- [ ] Verify passwords are encrypted

### 4. Check Logs (1 minute)
```bash
docker logs password_manager_app
```
**Expected:** No errors

---

## 🔧 Useful Commands

### Container Management
```bash
# Start containers
docker compose up -d

# Stop containers
docker compose down

# Rebuild containers
docker compose up --build

# View logs
docker logs -f password_manager_app

# Check status
docker ps
```

### Run Artisan Commands
```bash
# Test email
docker exec password_manager_app php artisan email:test

# Clear cache
docker exec password_manager_app php artisan config:clear

# Run migrations
docker exec password_manager_app php artisan migrate

# Access container shell
docker exec -it password_manager_app bash
```

### Database Commands
```bash
# Access MySQL
docker exec -it password_manager_mysql mysql -ularavel -psecret password_manager

# Backup database
docker exec password_manager_mysql mysqldump -ularavel -psecret password_manager > backup.sql

# Fresh database
docker exec password_manager_app php artisan migrate:fresh
```

---

## 🐛 Troubleshooting

### Problem: Port already in use

**Solution:**
```bash
# Stop Herd or other services using ports 8000, 3306, 8080
# Or change ports in docker-compose.yml
```

### Problem: Containers won't start

**Check logs:**
```bash
docker compose logs
```

**Restart:**
```bash
docker compose down
docker compose up --build
```

### Problem: Database connection failed

**Wait for MySQL:**
```bash
# MySQL takes ~30 seconds to initialize
docker logs password_manager_mysql
```

### Problem: Changes not reflected

**Rebuild:**
```bash
docker compose down
docker compose up --build
```

---

## 📊 Docker vs Local Testing

### Local (Herd)
- ✅ Fast startup
- ✅ Easy debugging
- ❌ Different from production

### Docker
- ✅ Production-like
- ✅ Includes Apache
- ✅ Consistent environment
- ❌ Slower startup

**Use both:** Develop locally, test with Docker before deployment.

---

## 🎯 Testing Workflow

```
1. Develop locally (Herd)
   ↓
2. Test locally (quick checks)
   ↓
3. Test with Docker (production-like)
   ↓
4. All tests pass?
   ↓
5. Deploy to production
```

---

## 📚 Complete Documentation

For detailed guide, see:
**DOCKER_TESTING_GUIDE.md**

Includes:
- Complete testing checklist
- All Docker commands
- Troubleshooting guide
- Performance testing
- Security testing

---

## ✨ Quick Reference

### Start Testing
```bash
docker-test.bat
```

### Access Application
- App: http://localhost:8000
- Database: http://localhost:8080

### View Logs
```bash
docker logs -f password_manager_app
```

### Stop Testing
```bash
docker compose down
```

---

## 🎊 You're Ready!

**Run this command:**
```bash
docker compose up --build
```

**Then test at:** http://localhost:8000

**Complete guide:** DOCKER_TESTING_GUIDE.md

---

**Docker testing = Production-like environment on your local machine!** 🐳
