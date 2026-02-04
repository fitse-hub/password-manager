# 🐳 Docker Testing Guide - Password Manager

## What is Docker Testing?

**Docker testing** = Running your app in containers (isolated environments) that mimic production servers.

**Benefits:**
- ✅ Tests in production-like environment
- ✅ Consistent across all machines
- ✅ Includes web server (Apache), database (MySQL), and PHP
- ✅ Easy to reset and start fresh
- ✅ No conflicts with local setup

---

## 🚀 Quick Start - Docker Testing

### Prerequisites

**Check if Docker is installed:**
```bash
docker --version
docker compose version
```

**If not installed:**
- Download: https://www.docker.com/products/docker-desktop
- Install Docker Desktop for Windows
- Restart your computer

### Step 1: Prepare Environment

**Copy Docker environment file:**
```bash
copy .env.docker .env
```

This configures your app for Docker (uses `mysql` as DB host instead of `127.0.0.1`).

### Step 2: Build and Start Containers

**Run Docker Compose:**
```bash
docker compose up --build
```

**What this does:**
1. Builds the Docker image (PHP 8.4 + Apache)
2. Starts MySQL database container
3. Starts phpMyAdmin container (database management)
4. Starts your Laravel app container
5. Runs migrations automatically
6. Caches routes, views, and config

**Expected output:**
```
[+] Building ...
[+] Running 3/3
 ✔ Container password_manager_mysql       Started
 ✔ Container password_manager_phpmyadmin  Started
 ✔ Container password_manager_app         Started
```

### Step 3: Access Your Application

**Your app is now running at:**
- **Application:** http://localhost:8000
- **phpMyAdmin:** http://localhost:8080 (database management)

**phpMyAdmin credentials:**
- Server: mysql
- Username: laravel
- Password: secret

---

## 🧪 Testing with Docker

### Test 1: Check Containers are Running

```bash
docker ps
```

**Expected output:**
```
CONTAINER ID   IMAGE                    STATUS         PORTS
abc123...      password_manager_app     Up 2 minutes   0.0.0.0:8000->80/tcp
def456...      mysql:8.0                Up 2 minutes   0.0.0.0:3306->3306/tcp
ghi789...      phpmyadmin/phpmyadmin    Up 2 minutes   0.0.0.0:8080->80/tcp
```

### Test 2: Check Application Logs

```bash
# View app logs
docker logs password_manager_app

# Follow logs in real-time
docker logs -f password_manager_app
```

### Test 3: Access Application

**Open browser:**
```
http://localhost:8000
```

**Expected:** Welcome page loads

### Test 4: Test Database Connection

**Check database:**
```bash
# Access MySQL container
docker exec -it password_manager_mysql mysql -ularavel -psecret password_manager

# List tables
SHOW TABLES;

# Exit
exit
```

**Or use phpMyAdmin:**
- Go to: http://localhost:8080
- Login with: laravel / secret
- Check `password_manager` database

### Test 5: Run Artisan Commands

```bash
# Run any artisan command
docker exec password_manager_app php artisan --version

# Test email
docker exec password_manager_app php artisan email:test

# Check routes
docker exec password_manager_app php artisan route:list

# Run migrations
docker exec password_manager_app php artisan migrate

# Clear cache
docker exec password_manager_app php artisan config:clear
```

---

## ✅ Complete Testing Checklist

### 1. Container Health Check

- [ ] All 3 containers running
- [ ] No error logs
- [ ] Application accessible at http://localhost:8000
- [ ] phpMyAdmin accessible at http://localhost:8080

### 2. Database Testing

- [ ] Database created (`password_manager`)
- [ ] Tables created (users, credentials, categories, etc.)
- [ ] Can connect via phpMyAdmin
- [ ] Can insert/query data

### 3. Application Testing

#### Registration
- [ ] Go to: http://localhost:8000/register
- [ ] Register new user
- [ ] **Expected:** Email verification sent
- [ ] **Check:** User in database (phpMyAdmin)

#### Email Verification
- [ ] Check email inbox
- [ ] Click verification link
- [ ] **Expected:** Redirect to dashboard
- [ ] **Check:** `email_verified_at` set in database

#### Login
- [ ] Go to: http://localhost:8000/login
- [ ] Login with credentials
- [ ] **Expected:** Dashboard loads

#### Credentials CRUD
- [ ] Create credential
- [ ] **Check:** Encrypted in database
- [ ] View password
- [ ] **Expected:** Decrypts correctly
- [ ] Edit credential
- [ ] Delete credential

#### Features
- [ ] Search works
- [ ] Favorites work
- [ ] Export works
- [ ] Settings work
- [ ] Theme toggle works

### 4. Performance Testing

- [ ] Page load < 2 seconds
- [ ] No memory leaks
- [ ] Database queries optimized

### 5. Security Testing

- [ ] Passwords encrypted in database
- [ ] HTTPS headers set (check with browser dev tools)
- [ ] CSRF protection works
- [ ] Session management works

---

## 🔧 Docker Commands Reference

### Container Management

```bash
# Start containers
docker compose up

# Start in background (detached mode)
docker compose up -d

# Stop containers
docker compose down

# Stop and remove volumes (WARNING: Deletes database!)
docker compose down -v

# Rebuild containers
docker compose up --build

# Restart containers
docker compose restart

# View running containers
docker ps

# View all containers (including stopped)
docker ps -a
```

### Logs and Debugging

```bash
# View logs for all containers
docker compose logs

# View logs for specific container
docker logs password_manager_app

# Follow logs in real-time
docker logs -f password_manager_app

# View last 50 lines
docker logs --tail 50 password_manager_app
```

### Execute Commands in Containers

```bash
# Run artisan command
docker exec password_manager_app php artisan [command]

# Access container shell
docker exec -it password_manager_app bash

# Access MySQL
docker exec -it password_manager_mysql mysql -ularavel -psecret password_manager

# Run composer
docker exec password_manager_app composer [command]
```

### Database Management

```bash
# Backup database
docker exec password_manager_mysql mysqldump -ularavel -psecret password_manager > backup.sql

# Restore database
docker exec -i password_manager_mysql mysql -ularavel -psecret password_manager < backup.sql

# Fresh database
docker exec password_manager_app php artisan migrate:fresh

# Seed database
docker exec password_manager_app php artisan db:seed
```

### Cleanup

```bash
# Remove stopped containers
docker container prune

# Remove unused images
docker image prune

# Remove unused volumes
docker volume prune

# Remove everything (WARNING: Nuclear option!)
docker system prune -a --volumes
```

---

## 🐛 Troubleshooting

### Problem: Containers won't start

**Check logs:**
```bash
docker compose logs
```

**Common causes:**
- Port 8000 already in use (stop Herd or other services)
- Port 3306 already in use (stop local MySQL)
- Port 8080 already in use (stop other services)

**Solution:**
```bash
# Stop conflicting services
# Or change ports in docker-compose.yml
```

### Problem: Database connection failed

**Check MySQL is healthy:**
```bash
docker ps
```

Look for "healthy" status on mysql container.

**Wait for MySQL to be ready:**
```bash
# MySQL takes ~30 seconds to initialize
docker logs password_manager_mysql
```

**Solution:**
```bash
# Restart containers
docker compose restart
```

### Problem: Permission denied errors

**Fix permissions:**
```bash
docker exec password_manager_app chown -R www-data:www-data /var/www/html/storage
docker exec password_manager_app chmod -R 775 /var/www/html/storage
```

### Problem: Changes not reflected

**Clear caches:**
```bash
docker exec password_manager_app php artisan config:clear
docker exec password_manager_app php artisan cache:clear
docker exec password_manager_app php artisan view:clear
```

**Or rebuild:**
```bash
docker compose down
docker compose up --build
```

### Problem: Can't access application

**Check container is running:**
```bash
docker ps
```

**Check logs:**
```bash
docker logs password_manager_app
```

**Check port binding:**
```bash
# Should show 0.0.0.0:8000->80/tcp
docker ps
```

---

## 📊 Docker vs Local Testing

### Local Testing (Herd)
- ✅ Faster startup
- ✅ Easier debugging
- ✅ Direct file access
- ❌ Different from production
- ❌ Environment-specific issues

### Docker Testing
- ✅ Production-like environment
- ✅ Consistent across machines
- ✅ Includes web server
- ✅ Easy to reset
- ❌ Slower startup
- ❌ More complex debugging

### When to Use Each

**Use Local (Herd) for:**
- Quick development
- Rapid testing
- Debugging
- Daily work

**Use Docker for:**
- Final testing before deployment
- Testing production configuration
- Testing with Apache (not just PHP server)
- Sharing with team
- CI/CD pipelines

---

## 🎯 Testing Workflow

### Development Workflow

```
1. Develop locally (Herd)
   ↓
2. Test locally (http://localhost:8000)
   ↓
3. Test with Docker (docker compose up)
   ↓
4. All tests pass?
   ↓
5. Deploy to production
```

### Docker Testing Workflow

```
1. docker compose up --build
   ↓
2. Test application (http://localhost:8000)
   ↓
3. Check logs (docker logs)
   ↓
4. Found bug? → Fix → Rebuild
   ↓
5. All tests pass? → Deploy
```

---

## 📝 Docker Testing Checklist

### Before Starting
- [ ] Docker Desktop installed and running
- [ ] Ports 8000, 3306, 8080 available
- [ ] `.env.docker` file exists
- [ ] All code changes committed

### Starting Docker
- [ ] Run `docker compose up --build`
- [ ] Wait for all containers to start
- [ ] Check all containers healthy
- [ ] Check logs for errors

### Testing Application
- [ ] Open http://localhost:8000
- [ ] Test registration
- [ ] Test login
- [ ] Test all features
- [ ] Check database (phpMyAdmin)
- [ ] Check logs for errors

### After Testing
- [ ] Document any issues found
- [ ] Fix issues
- [ ] Rebuild and re-test
- [ ] Stop containers: `docker compose down`

---

## 🚀 Quick Commands

### Start Testing
```bash
# Copy Docker environment
copy .env.docker .env

# Start containers
docker compose up --build

# Open application
start http://localhost:8000
```

### During Testing
```bash
# View logs
docker logs -f password_manager_app

# Run artisan commands
docker exec password_manager_app php artisan [command]

# Access database
start http://localhost:8080
```

### Stop Testing
```bash
# Stop containers
docker compose down

# Stop and remove database
docker compose down -v

# Restore local environment
copy .env.local .env
```

---

## 💡 Pro Tips

1. **Use detached mode** for background running:
   ```bash
   docker compose up -d
   ```

2. **Watch logs in real-time:**
   ```bash
   docker logs -f password_manager_app
   ```

3. **Quick restart after code changes:**
   ```bash
   docker compose restart app
   ```

4. **Fresh database for testing:**
   ```bash
   docker exec password_manager_app php artisan migrate:fresh --seed
   ```

5. **Check container resource usage:**
   ```bash
   docker stats
   ```

---

## 📚 Additional Resources

### Docker Documentation
- **Docker Compose:** https://docs.docker.com/compose/
- **Docker CLI:** https://docs.docker.com/engine/reference/commandline/cli/

### Your Documentation
- **LOCAL_TESTING_GUIDE.md** - Local testing checklist
- **DOCKER_DEPLOYMENT_GUIDE.md** - Production deployment
- **TESTING_SUMMARY.md** - Quick testing reference

---

## ✨ Summary

**Docker testing** gives you a production-like environment on your local machine.

**Quick Start:**
```bash
docker compose up --build
```

**Access:**
- App: http://localhost:8000
- Database: http://localhost:8080

**Test everything, fix bugs, deploy with confidence!**

---

**Ready to test with Docker?** Run `docker compose up --build` and open http://localhost:8000
