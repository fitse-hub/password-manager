# 🔐 Password Manager - Enterprise-Grade Security

A modern, secure password management system built with Laravel 12, featuring enterprise-grade encryption, zero-trust architecture, and comprehensive security features.

## ✨ Features

### 🔒 Security-First Architecture
- **AES-256-GCM Encryption** - Military-grade encryption for all credentials
- **Zero-Trust Model** - Passwords encrypted before reaching the server
- **Bcrypt Password Hashing** - Secure user authentication
- **CSRF Protection** - Built-in Laravel security
- **Rate Limiting** - Brute-force attack prevention
- **Session Security** - HttpOnly & Secure cookies

### 👤 User Authentication & Management
- User registration with strong password policy (12+ chars, mixed case, numbers, symbols)
- Secure login with rate limiting (5 attempts per IP)
- Password reset functionality
- Remember me feature
- Two-Factor Authentication (2FA) ready
- Activity logging (login history, IP tracking)

### 🗂️ Credential Management
- Add, edit, delete credentials
- Encrypted password storage
- Encrypted notes support
- Category organization (Work, Personal, Banking, Social)
- Favorite credentials
- Password age tracking
- Secure password reveal (requires authentication)

### 🎨 Modern UI/UX
- Clean, professional dashboard
- Responsive design (mobile, tablet, desktop)
- Glassmorphism design elements
- Smooth animations and transitions
- Intuitive navigation
- Real-time feedback

### 📊 Advanced Features
- Password generator (coming soon)
- Password strength analyzer (coming soon)
- Secure data export (coming soon)
- Password health dashboard (coming soon)
- Reused password detection (coming soon)

## 🚀 Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- MySQL 5.7+ or MariaDB 10.3+
- Node.js & NPM

### Setup Instructions

1. **Clone the repository**
```bash
git clone <repository-url>
cd Password_Manager
```

2. **Install PHP dependencies**
```bash
composer install
```

3. **Install Node dependencies**
```bash
npm install
```

4. **Environment Configuration**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Configure Database**
Edit `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=password_manager
DB_USERNAME=root
DB_PASSWORD=your_password
```

6. **Create Database**
```bash
mysql -u root -p
CREATE DATABASE password_manager;
exit;
```

7. **Run Migrations**
```bash
php artisan migrate
```

8. **Build Assets**
```bash
npm run build
```

9. **Start Development Server**
```bash
php artisan serve
```

Visit: `http://localhost:8000`

## 📁 Project Structure

```
Password_Manager/
├── app/
│   ├── Http/Controllers/
│   │   ├── Auth/
│   │   │   ├── LoginController.php
│   │   │   └── RegisterController.php
│   │   ├── CredentialController.php
│   │   ├── CategoryController.php
│   │   ├── DashboardController.php
│   │   └── SettingsController.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Credential.php
│   │   ├── Category.php
│   │   └── ActivityLog.php
│   ├── Policies/
│   │   └── CredentialPolicy.php
│   └── Services/
│       ├── EncryptionService.php
│       └── ActivityLogService.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── views/
│   │   ├── auth/
│   │   │   ├── login.blade.php
│   │   │   └── register.blade.php
│   │   ├── layouts/
│   │   │   ├── app.blade.php
│   │   │   └── dashboard.blade.php
│   │   ├── dashboard.blade.php
│   │   ├── settings.blade.php
│   │   └── welcome.blade.php
│   ├── css/
│   └── js/
└── routes/
    └── web.php
```

## 🔐 Security Features

### Encryption
- **Algorithm**: AES-256-GCM
- **Key Management**: Derived from Laravel APP_KEY
- **IV Generation**: Unique initialization vector per credential
- **Tag Authentication**: GCM mode provides authentication

### Password Policy
- Minimum 12 characters
- Must include uppercase letters
- Must include lowercase letters
- Must include numbers
- Must include symbols
- Checked against compromised password database

### Rate Limiting
- 5 login attempts per IP address
- Progressive delays on failed attempts
- Automatic lockout after threshold

### Session Security
- Session regeneration on login
- HttpOnly cookies
- Secure flag in production
- CSRF token validation

## 🎯 Usage

### Register a New Account
1. Navigate to `/register`
2. Fill in your details
3. Accept terms & conditions
4. Create a strong password (12+ characters)

### Add a Credential
1. Login to your dashboard
2. Click "Add New" button
3. Fill in website details
4. Enter username/email
5. Enter password (or generate one)
6. Select category
7. Add optional notes
8. Click "Save"

### View Password
1. Find credential in dashboard
2. Click the eye icon
3. Password will be decrypted and displayed
4. Activity is logged for security

### Update Profile
1. Go to Settings
2. Update name or email
3. Click "Update Profile"

### Change Password
1. Go to Settings
2. Enter current password
3. Enter new password (must meet policy)
4. Confirm new password
5. Click "Change Password"

## 🛠️ Development

### Run Development Server
```bash
composer run dev
```

This will start:
- Laravel development server (port 8000)
- Vite dev server (hot reload)
- Queue worker

### Run Tests
```bash
php artisan test
```

### Code Style
```bash
./vendor/bin/pint
```

## 📊 Database Schema

### Users Table
- id, name, username, email, password
- master_password_hash (for future use)
- two_factor_enabled, two_factor_secret, two_factor_recovery_codes
- last_login_at, last_login_ip
- timestamps

### Credentials Table
- id, user_id, category_id
- website_name, website_url
- username_email
- encrypted_password, encrypted_notes
- encryption_iv
- is_favorite
- password_updated_at
- timestamps

### Categories Table
- id, user_id
- name, color
- is_default
- timestamps

### Activity Logs Table
- id, user_id
- action, entity_type, entity_id
- ip_address, user_agent
- timestamps

## 🔮 Future Enhancements

- [ ] Password generator with customizable options
- [ ] Password strength analyzer
- [ ] Two-Factor Authentication (TOTP)
- [ ] Secure data export (encrypted JSON/CSV)
- [ ] Password health dashboard
- [ ] Reused password detection
- [ ] Password expiration reminders
- [ ] Browser extension
- [ ] Mobile apps (iOS/Android)
- [ ] Shared vaults for teams
- [ ] Emergency access
- [ ] Biometric authentication

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## 📄 License

This project is open-sourced software licensed under the MIT license.

## 🙏 Acknowledgments

- Laravel Framework
- Tailwind CSS
- Heroicons

## 📞 Support

For support, email support@passwordmanager.com or open an issue in the repository.

---

**Built with ❤️ using Laravel 12 & Tailwind CSS**
