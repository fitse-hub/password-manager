# 🧪 Local Testing Guide - Password Manager

## What "Test Locally" Means

**Local testing** = Running your app on your computer (localhost) to catch bugs BEFORE deploying to production.

**Your Setup:** Laravel Herd (http://localhost:8000)

---

## 🎯 Why Test Locally?

### Bugs You'll Catch Early:
- ❌ Missing PHP extensions
- ❌ Database connection errors
- ❌ Permission issues (storage, cache)
- ❌ .env configuration mistakes
- ❌ Email sending issues
- ❌ Encryption/decryption errors
- ❌ Authentication flow problems
- ❌ UI/UX issues
- ❌ Form validation errors
- ❌ API endpoint failures

### Why It Matters:
✅ **Fast debugging** - Instant feedback, detailed error messages
✅ **Safe environment** - No real users affected
✅ **Easy rollback** - Just refresh the database
✅ **Cost-free** - No server costs while testing
✅ **Professional workflow** - Industry standard practice

---

## 🚀 Your Local Testing Workflow

### Step 1: Start Your Local Environment

**Using Laravel Herd (Your Current Setup):**
```bash
# Herd runs automatically in the background
# Your app is available at: http://localhost:8000
```

**Check if it's running:**
- Open: http://localhost:8000
- You should see your welcome page

### Step 2: Database Setup

**Check database connection:**
```bash
# Test database connection
php artisan db:show

# Run migrations (if not done)
php artisan migrate

# Seed default data (if needed)
php artisan db:seed
```

**Your database config (`.env`):**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=password_manager
DB_USERNAME=root
DB_PASSWORD=
```

### Step 3: Clear All Caches

**Before testing, always clear caches:**
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

---

## ✅ Complete Testing Checklist

### 1. Authentication Testing

#### Registration Flow
- [ ] Go to: http://localhost:8000/register
- [ ] Fill in registration form
  - Name: Test User
  - Email: test@example.com
  - Password: TestPassword123!@#
  - Confirm password
  - Accept terms
- [ ] Click "Register"
- [ ] **Expected:** Redirect to email verification notice
- [ ] **Check:** User created in database
- [ ] **Check:** Email sent (check inbox or logs)

#### Email Verification
- [ ] Check email inbox (securevault.official@gmail.com)
- [ ] Click verification link
- [ ] **Expected:** Redirect to dashboard
- [ ] **Expected:** Success message shown
- [ ] **Check:** `email_verified_at` set in database
- [ ] **Check:** Activity log entry created

#### Login Flow
- [ ] Go to: http://localhost:8000/login
- [ ] Enter credentials
- [ ] Click "Login"
- [ ] **Expected:** Redirect to dashboard
- [ ] **Check:** Session created
- [ ] **Check:** Activity log entry

#### Password Reset
- [ ] Go to: http://localhost:8000/login
- [ ] Click "Forgot Password?"
- [ ] Enter email
- [ ] **Expected:** Success message
- [ ] **Check:** Email received
- [ ] Click reset link in email
- [ ] Enter new password
- [ ] **Expected:** Redirect to login
- [ ] Login with new password
- [ ] **Expected:** Login successful

#### 2FA Testing (if enabled)
- [ ] Enable 2FA in Settings
- [ ] **Expected:** QR code shown
- [ ] Scan with authenticator app
- [ ] Enter verification code
- [ ] **Expected:** 2FA enabled
- [ ] **Expected:** Recovery codes shown
- [ ] Logout and login again
- [ ] **Expected:** 2FA verification page shown
- [ ] Enter 2FA code
- [ ] **Expected:** Access granted

### 2. Credential Management Testing

#### Create Credential
- [ ] Go to dashboard
- [ ] Click "Add New Credential"
- [ ] Fill in form:
  - Website: https://example.com
  - Username: testuser
  - Password: TestPass123!
  - Category: Work
  - Notes: Test notes
- [ ] Click "Save"
- [ ] **Expected:** Success message
- [ ] **Expected:** Credential appears in list
- [ ] **Check:** Password encrypted in database
- [ ] **Check:** Activity log entry

#### View Password
- [ ] Click eye icon on credential
- [ ] **Expected:** Modal shows with password
- [ ] **Expected:** Copy button works
- [ ] **Expected:** Timer counts down (30 seconds)
- [ ] **Expected:** Modal auto-closes
- [ ] **Check:** Activity log entry

#### Edit Credential
- [ ] Click edit icon
- [ ] **Expected:** Modal opens with pre-filled data
- [ ] Change website name
- [ ] Click "Update"
- [ ] **Expected:** Success message
- [ ] **Expected:** Changes reflected
- [ ] **Check:** Activity log entry

#### Delete Credential
- [ ] Click delete icon
- [ ] **Expected:** Confirmation modal
- [ ] Click "Delete"
- [ ] **Expected:** Success message
- [ ] **Expected:** Credential removed from list
- [ ] **Check:** Deleted from database
- [ ] **Check:** Activity log entry

#### Toggle Favorite
- [ ] Click star icon
- [ ] **Expected:** Star fills/unfills
- [ ] **Expected:** Favorites count updates
- [ ] **Check:** Database updated
- [ ] **Check:** Activity log entry

### 3. Search & Filter Testing

#### Search Functionality
- [ ] Enter search term in search bar
- [ ] **Expected:** Results filter in real-time
- [ ] Test search by:
  - [ ] Website name
  - [ ] Username
  - [ ] Category name
- [ ] Clear search
- [ ] **Expected:** All credentials shown

#### Category Filter
- [ ] Click category in sidebar
- [ ] **Expected:** Only credentials in that category shown
- [ ] Click "All Credentials"
- [ ] **Expected:** All credentials shown

### 4. Password Generator Testing

#### Generate Password
- [ ] Click "Generate Password" in add/edit modal
- [ ] **Expected:** Random password generated
- [ ] **Expected:** Password meets requirements
- [ ] Test different lengths
- [ ] Test with/without symbols
- [ ] Test with/without numbers
- [ ] **Expected:** All options work

### 5. Password Health Testing

#### Password Health Dashboard
- [ ] Go to: http://localhost:8000/password-health
- [ ] **Expected:** Dashboard loads
- [ ] **Check:** Weak passwords detected
- [ ] **Check:** Reused passwords detected
- [ ] **Check:** Old passwords detected (90+ days)
- [ ] **Check:** Compromised passwords detected
- [ ] **Expected:** Recommendations shown

### 6. Export Testing

#### Export Unencrypted
- [ ] Go to: http://localhost:8000/export
- [ ] Select format: JSON
- [ ] Leave password empty
- [ ] Click "Export"
- [ ] **Expected:** File downloads
- [ ] **Check:** Passwords are decrypted in file
- [ ] **Check:** Valid JSON format

#### Export Encrypted
- [ ] Select format: JSON
- [ ] Enter encryption password
- [ ] Click "Export"
- [ ] **Expected:** File downloads (.encrypted.json)
- [ ] **Check:** Content is encrypted
- [ ] **Check:** Can decrypt with password

#### Export CSV
- [ ] Select format: CSV
- [ ] Click "Export"
- [ ] **Expected:** CSV file downloads
- [ ] **Check:** Valid CSV format
- [ ] **Check:** All fields present

### 7. Settings Testing

#### Profile Update
- [ ] Go to Settings
- [ ] Update name
- [ ] Update username
- [ ] Update email
- [ ] Click "Update Profile"
- [ ] **Expected:** Success message
- [ ] **Check:** Database updated
- [ ] **Check:** Activity log entry

#### Password Change
- [ ] Enter current password
- [ ] Enter new password
- [ ] Confirm new password
- [ ] Click "Change Password"
- [ ] **Expected:** Success message
- [ ] Logout and login with new password
- [ ] **Expected:** Login successful

#### Same Password Prevention
- [ ] Try to change password to current password
- [ ] **Expected:** Error message
- [ ] **Expected:** Password not changed

#### Theme Toggle
- [ ] Click "Dark" theme
- [ ] **Expected:** UI changes to dark mode
- [ ] **Expected:** Theme saved (refresh page)
- [ ] Click "Light" theme
- [ ] **Expected:** UI changes to light mode

### 8. Activity Log Testing

#### View Activity Log
- [ ] Go to Settings
- [ ] Scroll to "Recent Activity"
- [ ] **Expected:** Activities listed
- [ ] **Expected:** Scrollbar appears (if 50+ activities)
- [ ] **Check:** All actions logged:
  - User registered
  - Email verified
  - Login
  - Credential created/updated/deleted
  - Password viewed
  - Password changed
  - 2FA enabled/disabled

### 9. Security Testing

#### Session Management
- [ ] Login
- [ ] Open new incognito window
- [ ] Try to access dashboard directly
- [ ] **Expected:** Redirect to login

#### CSRF Protection
- [ ] Try to submit form without CSRF token
- [ ] **Expected:** 419 error

#### Authorization
- [ ] Create credential as User A
- [ ] Try to access/edit as User B (different browser)
- [ ] **Expected:** 403 Forbidden

#### SQL Injection Prevention
- [ ] Try SQL injection in search: `' OR '1'='1`
- [ ] **Expected:** No results, no error

#### XSS Prevention
- [ ] Try XSS in credential notes: `<script>alert('XSS')</script>`
- [ ] **Expected:** Script not executed, displayed as text

### 10. Email Testing

#### Test Email Configuration
```bash
php artisan email:test
```
- [ ] **Expected:** Test email sent
- [ ] **Check:** Email received in inbox

#### Registration Email
- [ ] Register new user
- [ ] **Check:** Verification email received
- [ ] **Check:** Email has correct subject
- [ ] **Check:** Verification link works

#### Password Reset Email
- [ ] Request password reset
- [ ] **Check:** Reset email received
- [ ] **Check:** Reset link works
- [ ] **Check:** Link expires after 60 minutes

### 11. UI/UX Testing

#### Responsive Design
- [ ] Test on desktop (1920x1080)
- [ ] Test on tablet (768px)
- [ ] Test on mobile (375px)
- [ ] **Expected:** UI adapts properly

#### Modal Functionality
- [ ] Test all modals open/close
- [ ] Test clicking outside modal
- [ ] Test ESC key closes modal
- [ ] **Expected:** All work correctly

#### Form Validation
- [ ] Submit empty forms
- [ ] **Expected:** Validation errors shown
- [ ] Enter invalid email
- [ ] **Expected:** Email validation error
- [ ] Enter weak password
- [ ] **Expected:** Password strength error

#### Loading States
- [ ] Check loading indicators
- [ ] **Expected:** Shown during async operations

#### Success/Error Messages
- [ ] Perform actions
- [ ] **Expected:** Messages appear
- [ ] **Expected:** Messages auto-dismiss (5 seconds)
- [ ] **Expected:** Can manually close

### 12. Performance Testing

#### Page Load Speed
- [ ] Check dashboard load time
- [ ] **Expected:** < 2 seconds
- [ ] Check with 100+ credentials
- [ ] **Expected:** Still fast

#### Search Performance
- [ ] Search with 100+ credentials
- [ ] **Expected:** Instant results

#### Database Queries
```bash
# Enable query logging in .env
DB_LOG_QUERIES=true

# Check logs
tail -f storage/logs/laravel.log
```
- [ ] **Check:** No N+1 query problems

---

## 🐛 Common Issues to Test For

### Database Issues
- [ ] Test with empty database
- [ ] Test with large dataset (1000+ records)
- [ ] Test concurrent users (multiple browsers)
- [ ] Test database connection failure

### File Permission Issues
- [ ] Check `storage/` is writable
- [ ] Check `bootstrap/cache/` is writable
- [ ] Test file uploads (if any)

### Environment Issues
- [ ] Test with `.env` missing values
- [ ] Test with wrong database credentials
- [ ] Test with wrong email credentials
- [ ] Test with wrong APP_KEY

### Browser Compatibility
- [ ] Test in Chrome
- [ ] Test in Firefox
- [ ] Test in Edge
- [ ] Test in Safari (if available)

---

## 🔧 Testing Commands

### Database Testing
```bash
# Fresh database
php artisan migrate:fresh

# With seeders
php artisan migrate:fresh --seed

# Check database
php artisan db:show

# Tinker (interactive testing)
php artisan tinker
```

### Cache Testing
```bash
# Clear all caches
php artisan optimize:clear

# Or individually
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

### Email Testing
```bash
# Test email
php artisan email:test

# Check mail logs
tail -f storage/logs/laravel.log | grep -i mail
```

### Queue Testing (if using)
```bash
# Process queue jobs
php artisan queue:work

# Check failed jobs
php artisan queue:failed
```

---

## 📊 Testing Checklist Summary

### Critical Tests (Must Pass)
- [ ] User registration works
- [ ] Email verification works
- [ ] Login/logout works
- [ ] Password reset works
- [ ] Create credential works
- [ ] View password works (decryption)
- [ ] Edit credential works
- [ ] Delete credential works
- [ ] Search works
- [ ] Export works
- [ ] Settings update works

### Security Tests (Must Pass)
- [ ] Passwords encrypted in database
- [ ] Authorization works (can't access others' data)
- [ ] CSRF protection works
- [ ] Session management works
- [ ] SQL injection prevented
- [ ] XSS prevented

### Optional Tests (Nice to Have)
- [ ] 2FA works
- [ ] Password health works
- [ ] Activity logs work
- [ ] Theme toggle works
- [ ] Favorites work
- [ ] Responsive design works

---

## 🚨 What to Do When Tests Fail

### 1. Check Logs
```bash
# Laravel logs
tail -f storage/logs/laravel.log

# Web server logs (Herd)
# Check Herd UI for logs
```

### 2. Enable Debug Mode
```env
# In .env
APP_DEBUG=true
APP_ENV=local
```

### 3. Check Database
```bash
# Connect to database
php artisan tinker

# Check user
User::all();

# Check credentials
Credential::all();
```

### 4. Clear Everything
```bash
php artisan optimize:clear
php artisan config:clear
composer dump-autoload
```

### 5. Check Permissions
```bash
# Windows (PowerShell as Admin)
icacls storage /grant Users:F /T
icacls bootstrap/cache /grant Users:F /T
```

---

## 📝 Testing Log Template

Create a file: `TESTING_LOG.md`

```markdown
# Testing Log - [Date]

## Environment
- OS: Windows
- PHP: 8.4.16
- Laravel: 12.x
- Database: MySQL
- Server: Laravel Herd

## Tests Performed

### Authentication
- [x] Registration: PASS
- [x] Email Verification: PASS
- [x] Login: PASS
- [x] Logout: PASS
- [x] Password Reset: PASS

### Credentials
- [x] Create: PASS
- [x] Read: PASS
- [x] Update: PASS
- [x] Delete: PASS
- [x] Search: PASS

### Issues Found
1. None

### Notes
- All tests passed
- Ready for deployment
```

---

## 🎯 Before Deploying to Production

### Final Checklist
- [ ] All critical tests pass
- [ ] All security tests pass
- [ ] No errors in logs
- [ ] Database migrations work
- [ ] Email sending works
- [ ] Backups configured
- [ ] `.env` configured for production
- [ ] `APP_DEBUG=false`
- [ ] `APP_ENV=production`
- [ ] HTTPS enabled
- [ ] Security headers configured

---

## 💡 Pro Tips

1. **Test after every change** - Don't accumulate untested changes
2. **Use multiple browsers** - Different browsers, different bugs
3. **Test with real data** - Create realistic test scenarios
4. **Test edge cases** - Empty forms, long inputs, special characters
5. **Test error scenarios** - Wrong passwords, expired tokens, etc.
6. **Keep testing logs** - Document what you tested and results
7. **Automate when possible** - Write automated tests for critical features

---

## 🚀 Your Current Status

**Local Environment:** ✅ Laravel Herd (Running)
**Database:** ✅ MySQL (Connected)
**Email:** ✅ Gmail SMTP (Configured)
**Application:** ✅ Fully Functional

**You're ready to test!**

**Start here:**
1. Open: http://localhost:8000
2. Register a new user
3. Follow the testing checklist above
4. Document any issues found
5. Fix issues locally
6. Re-test
7. Deploy when all tests pass

---

**Remember:** Pros never debug on production. They catch bugs locally first! 🎯
