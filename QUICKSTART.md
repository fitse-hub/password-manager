# 🚀 Quick Start Guide

Get your Password Manager up and running in 5 minutes!

## Prerequisites

- PHP 8.2+
- Composer
- MySQL/MariaDB
- Node.js & NPM

## Installation Steps

### 1. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 2. Environment Setup

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 3. Configure Database

Edit `.env` file:
```env
DB_DATABASE=password_manager
DB_USERNAME=root
DB_PASSWORD=your_password
```

Create database:
```bash
mysql -u root -p -e "CREATE DATABASE password_manager;"
```

### 4. Run Migrations

```bash
php artisan migrate
```

### 5. Build Assets

```bash
npm run build
```

### 6. Start Server

```bash
php artisan serve
```

Visit: **http://localhost:8000**

## First Steps

### 1. Register Account
- Go to `/register`
- Create account with strong password (12+ chars)
- Accept terms & conditions

### 2. Add First Credential
- Click "Add New" button
- Fill in website details
- Enter username and password
- Select category (optional)
- Click "Save"

### 3. View Password
- Find credential in dashboard
- Click eye icon to reveal password
- Password is decrypted securely

### 4. Explore Settings
- Update your profile
- Change password
- View activity logs

## Development Mode

Run all services at once:
```bash
composer run dev
```

This starts:
- Laravel server (http://localhost:8000)
- Vite dev server (hot reload)
- Queue worker

## Default Categories

The system includes these default categories:
- 🔵 Work
- 🟢 Personal
- 🟠 Banking
- 🟣 Social

## Security Tips

✅ Use strong, unique passwords
✅ Enable 2FA when available
✅ Regularly review activity logs
✅ Keep your master password secure
✅ Never share your credentials

## Troubleshooting

**Issue: Migration fails**
```bash
php artisan migrate:fresh
```

**Issue: Assets not loading**
```bash
npm run build
php artisan optimize:clear
```

**Issue: Permission errors**
```bash
chmod -R 775 storage bootstrap/cache
```

## Next Steps

- [ ] Add your first 10 credentials
- [ ] Organize with categories
- [ ] Review security settings
- [ ] Check activity logs
- [ ] Explore password generator (coming soon)

## Support

Need help? Check:
- README.md for detailed documentation
- docs/IMPLEMENTATION.md for technical details
- GitHub issues for known problems

---

**Happy Password Managing! 🔐**
