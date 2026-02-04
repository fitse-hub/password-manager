# 🔍 Deployment Sanity Checklist

## ⚠️ DON'T SKIP THIS - Common Deployment Issues

This checklist prevents the most common deployment failures that cause blank pages, 500 errors, and broken apps.

---

## ✅ Critical Checks (Must Pass)

### 1️⃣ Apache Configuration

**Location:** `docker/apache/000-default.conf`

**Required settings:**
```apache
DocumentRoot /var/www/html/public

<Directory /var/www/html/public>
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>
```

**Why it matters:**
- ❌ Wrong DocumentRoot = 404 errors
- ❌ Missing `AllowOverride All` = Routes don't work
- ❌ Missing `Require all granted` = 403 Forbidden

**Your status:** ✅ CORRECT

---

### 2️⃣ Laravel Environment Variables

**Critical variables that MUST be set:**

```env
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:c68UgnIwR7Pv3WQmx1+e9qGCp493RjiPl5udHZ6IlgU=
APP_URL=https://yourdomain.com
```

**Why each matters:**

#### APP_ENV=production
- ✅ Enables production optimizations
- ✅ Disables debug routes
- ✅ Uses production error handling
- ❌ If missing: Development mode in production (security risk)

#### APP_DEBUG=false
- ✅ Hides sensitive error details
- ✅ Shows user-friendly error pages
- ❌ If true: Exposes database credentials, file paths, secrets

#### APP_KEY=base64:xxxx
- ✅ Encrypts sessions, cookies, passwords
- ❌ If missing: **BLANK PAGE** (most common issue!)
- ❌ If wrong: Can't decrypt existing data

#### APP_URL=https://yourdomain.com
- ✅ Correct URLs in emails
- ✅ Correct asset URLs
- ❌ If wrong: Broken links, mixed content errors

**Your current APP_KEY:** ✅ SET
```
base64:c68UgnIwR7Pv3WQmx1+e9qGCp493RjiPl5udHZ6IlgU=
```

---

### 3️⃣ Database Configuration

**Required variables:**
```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=password_manager
DB_USERNAME=laravel
DB_PASSWORD=secret
```

**Common issues:**
- ❌ Wrong DB_HOST (use `mysql` in Docker, not `127.0.0.1`)
- ❌ Wrong credentials = Connection refused
- ❌ Database doesn't exist = Table not found errors

**Test connection:**
```bash
docker exec password_manager_app php artisan db:show
```

---

### 4️⃣ File Permissions

**Required permissions:**
```bash
storage/          - 775 (writable)
bootstrap/cache/  - 775 (writable)
```

**Why it matters:**
- ❌ Wrong permissions = Can't write logs
- ❌ Wrong permissions = Can't cache views
- ❌ Wrong permissions = 500 errors

**Fix permissions:**
```bash
docker exec password_manager_app chown -R www-data:www-data /var/www/html/storage
docker exec password_manager_app chmod -R 775 /var/www/html/storage
docker exec password_manager_app chmod -R 775 /var/www/html/bootstrap/cache
```

---

### 5️⃣ Composer Dependencies

**Must run:**
```bash
composer install --no-dev --optimize-autoloader
```

**Why it matters:**
- ✅ `--no-dev` = Excludes development packages (smaller, faster)
- ✅ `--optimize-autoloader` = Faster class loading
- ❌ If skipped: Missing dependencies, slow performance

**Your Dockerfile:** ✅ CORRECT (already includes this)

---

### 6️⃣ Laravel Optimizations

**Must run before deployment:**
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

**Why it matters:**
- ✅ Faster config loading
- ✅ Faster route matching
- ✅ Faster view rendering
- ❌ If skipped: Slower performance

**Your docker-compose.yml:** ✅ CORRECT (already includes this)

---

### 7️⃣ Database Migrations

**Must run:**
```bash
php artisan migrate --force
```

**Why `--force` is needed:**
- Production requires `--force` flag
- Without it, migrations won't run

**Your docker-compose.yml:** ✅ CORRECT (already includes this)

---

### 8️⃣ Email Configuration

**Required for email features:**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=securevault.official@gmail.com
MAIL_PASSWORD=bpomkmdszhhepzqu
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="securevault.official@gmail.com"
MAIL_FROM_NAME="Password Manager"
```

**Your status:** ✅ CONFIGURED

**Test email:**
```bash
docker exec password_manager_app php artisan email:test
```

---

## 🚀 Pre-Deployment Checklist

### Before Building Docker Image

- [ ] **Apache config correct** (DocumentRoot, AllowOverride All)
- [ ] **APP_KEY is set** (not empty!)
- [ ] **APP_ENV=production**
- [ ] **APP_DEBUG=false**
- [ ] **APP_URL set to production domain**
- [ ] **Database credentials correct**
- [ ] **Email credentials correct**
- [ ] **All code committed to git**
- [ ] **Tested locally with Docker**

### After Building Docker Image

- [ ] **Containers start successfully**
- [ ] **No errors in logs**
- [ ] **Database migrations ran**
- [ ] **Can access homepage**
- [ ] **Can register user**
- [ ] **Can login**
- [ ] **Email verification works**
- [ ] **All features work**

---

## 🐛 Common Issues & Solutions

### Issue 1: Blank Page

**Symptoms:**
- White/blank page
- No error message
- Nothing in browser console

**Causes:**
1. ❌ Missing APP_KEY
2. ❌ Wrong file permissions
3. ❌ PHP errors hidden

**Solutions:**
```bash
# Check APP_KEY is set
docker exec password_manager_app php artisan tinker --execute="echo config('app.key');"

# Check logs
docker logs password_manager_app

# Enable debug temporarily
# Set APP_DEBUG=true in .env
# Check error, then set back to false
```

### Issue 2: 404 on All Routes

**Symptoms:**
- Homepage works
- All other pages = 404

**Causes:**
1. ❌ Missing `AllowOverride All` in Apache config
2. ❌ mod_rewrite not enabled
3. ❌ Wrong DocumentRoot

**Solutions:**
```bash
# Check Apache config
docker exec password_manager_app cat /etc/apache2/sites-available/000-default.conf

# Enable mod_rewrite (should already be enabled)
docker exec password_manager_app a2enmod rewrite

# Restart Apache
docker compose restart app
```

### Issue 3: 500 Internal Server Error

**Symptoms:**
- 500 error on all pages
- Or specific pages

**Causes:**
1. ❌ File permission issues
2. ❌ Missing dependencies
3. ❌ Database connection failed
4. ❌ Cache issues

**Solutions:**
```bash
# Check logs
docker logs password_manager_app
tail -f storage/logs/laravel.log

# Fix permissions
docker exec password_manager_app chmod -R 775 storage bootstrap/cache

# Clear cache
docker exec password_manager_app php artisan config:clear
docker exec password_manager_app php artisan cache:clear

# Test database
docker exec password_manager_app php artisan db:show
```

### Issue 4: Database Connection Failed

**Symptoms:**
- "Connection refused"
- "Access denied"
- "Unknown database"

**Causes:**
1. ❌ Wrong DB_HOST (should be `mysql` in Docker)
2. ❌ Wrong credentials
3. ❌ Database not created
4. ❌ MySQL not ready yet

**Solutions:**
```bash
# Check MySQL is running
docker ps | grep mysql

# Check MySQL logs
docker logs password_manager_mysql

# Wait for MySQL to be ready (takes ~30 seconds)
docker exec password_manager_mysql mysqladmin ping -h localhost

# Test connection
docker exec password_manager_app php artisan db:show

# Create database manually if needed
docker exec -it password_manager_mysql mysql -uroot -proot_secret_password
CREATE DATABASE IF NOT EXISTS password_manager;
exit
```

### Issue 5: Assets Not Loading (CSS/JS)

**Symptoms:**
- Page loads but no styling
- JavaScript not working
- 404 on asset files

**Causes:**
1. ❌ Wrong APP_URL
2. ❌ Assets not compiled
3. ❌ Wrong asset paths

**Solutions:**
```bash
# Compile assets
npm run build

# Check APP_URL matches your domain
# In .env: APP_URL=https://yourdomain.com

# Clear cache
docker exec password_manager_app php artisan config:clear
```

### Issue 6: Email Not Sending

**Symptoms:**
- Registration works but no email
- Password reset doesn't send email

**Causes:**
1. ❌ Wrong SMTP credentials
2. ❌ Gmail blocking
3. ❌ Queue not running (if using queues)

**Solutions:**
```bash
# Test email
docker exec password_manager_app php artisan email:test

# Check logs
docker logs password_manager_app | grep -i mail

# Verify Gmail App Password is correct
# Check .env MAIL_PASSWORD has no spaces
```

---

## 📋 Environment Variables Checklist

### Required Variables

```env
# Application
APP_NAME="Password Manager"
APP_ENV=production                    ✅ Must be 'production'
APP_KEY=base64:xxxx                   ✅ Must be set (no blank!)
APP_DEBUG=false                       ✅ Must be false
APP_URL=https://yourdomain.com        ✅ Must match your domain

# Database
DB_CONNECTION=mysql                   ✅ Required
DB_HOST=mysql                         ✅ Use 'mysql' in Docker
DB_PORT=3306                          ✅ Default MySQL port
DB_DATABASE=password_manager          ✅ Database name
DB_USERNAME=laravel                   ✅ Database user
DB_PASSWORD=secret                    ✅ Database password

# Email
MAIL_MAILER=smtp                      ✅ Required for email
MAIL_HOST=smtp.gmail.com              ✅ SMTP server
MAIL_PORT=587                         ✅ TLS port
MAIL_USERNAME=your@gmail.com          ✅ Gmail address
MAIL_PASSWORD=apppassword             ✅ Gmail App Password
MAIL_ENCRYPTION=tls                   ✅ Use TLS
MAIL_FROM_ADDRESS="your@gmail.com"    ✅ From address
MAIL_FROM_NAME="${APP_NAME}"          ✅ From name

# Session
SESSION_DRIVER=database               ✅ Store sessions in DB
SESSION_LIFETIME=120                  ✅ 2 hours

# Cache
CACHE_STORE=database                  ✅ Store cache in DB

# Queue (if using)
QUEUE_CONNECTION=database             ✅ Store jobs in DB
```

---

## 🔧 Quick Verification Commands

### Check Everything at Once

```bash
# 1. Check Apache config
docker exec password_manager_app cat /etc/apache2/sites-available/000-default.conf | grep -A 5 "DocumentRoot"

# 2. Check APP_KEY is set
docker exec password_manager_app php artisan tinker --execute="echo config('app.key') ? 'APP_KEY: SET' : 'APP_KEY: MISSING';"

# 3. Check database connection
docker exec password_manager_app php artisan db:show

# 4. Check file permissions
docker exec password_manager_app ls -la storage

# 5. Check logs for errors
docker logs password_manager_app --tail 50

# 6. Test email
docker exec password_manager_app php artisan email:test

# 7. Check routes work
curl -I http://localhost:8000
```

---

## ✅ Final Pre-Deployment Checklist

### Configuration Files

- [ ] `docker/apache/000-default.conf` - DocumentRoot correct
- [ ] `docker/apache/000-default.conf` - AllowOverride All present
- [ ] `.env` - APP_KEY is set
- [ ] `.env` - APP_ENV=production
- [ ] `.env` - APP_DEBUG=false
- [ ] `.env` - APP_URL matches domain
- [ ] `.env` - Database credentials correct
- [ ] `.env` - Email credentials correct

### Docker Setup

- [ ] `Dockerfile` - Composer install with --no-dev
- [ ] `Dockerfile` - File permissions set
- [ ] `docker-compose.yml` - Migrations run on start
- [ ] `docker-compose.yml` - Cache commands run
- [ ] All containers start successfully

### Testing

- [ ] Homepage loads
- [ ] Registration works
- [ ] Email verification works
- [ ] Login works
- [ ] Dashboard loads
- [ ] Create credential works
- [ ] View password works (decryption)
- [ ] All features tested
- [ ] No errors in logs

### Security

- [ ] APP_DEBUG=false
- [ ] Passwords encrypted in database
- [ ] HTTPS enabled (production)
- [ ] Security headers set
- [ ] File permissions correct

---

## 🎯 Your Current Status

### Apache Configuration
✅ **CORRECT**
- DocumentRoot: `/var/www/html/public`
- AllowOverride: `All`
- Require: `all granted`

### Environment Variables
✅ **APP_KEY SET**
```
base64:c68UgnIwR7Pv3WQmx1+e9qGCp493RjiPl5udHZ6IlgU=
```

⚠️ **NEEDS UPDATE FOR PRODUCTION:**
- APP_ENV: Currently `local` → Change to `production`
- APP_DEBUG: Currently `true` → Change to `false`
- APP_URL: Currently `http://localhost:8000` → Change to your domain

### Docker Configuration
✅ **CORRECT**
- Composer install optimized
- File permissions set
- Migrations run automatically
- Cache commands run

---

## 🚀 Ready to Deploy?

### Quick Test

```bash
# Start Docker
docker compose up --build

# Run all checks
docker exec password_manager_app php artisan about

# Test application
start http://localhost:8000
```

### If All Tests Pass

1. Update `.env` for production:
   - APP_ENV=production
   - APP_DEBUG=false
   - APP_URL=https://yourdomain.com

2. Rebuild Docker image:
   ```bash
   docker compose down
   docker compose up --build
   ```

3. Test again

4. Deploy to production server

---

## 💡 Pro Tips

1. **Always test with Docker locally first** - Catches 90% of deployment issues
2. **Keep APP_DEBUG=false in production** - Never expose sensitive data
3. **Monitor logs after deployment** - `docker logs -f password_manager_app`
4. **Have a rollback plan** - Keep previous Docker image
5. **Test email immediately** - Email issues are common

---

**Remember:** These checks prevent 99% of deployment failures. Don't skip them! 🎯
