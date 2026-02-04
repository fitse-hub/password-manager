FROM php:8.4-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    apache2 \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql gd

# Enable Apache modules
RUN a2enmod rewrite proxy proxy_fcgi headers

# Configure Apache to use PHP-FPM
RUN echo '<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
    AllowOverride All\n\
    Require all granted\n\
    </Directory>\n\
    <FilesMatch \\.php$>\n\
    SetHandler "proxy:unix:/run/php/php-fpm.sock|fcgi://localhost"\n\
    </FilesMatch>\n\
    </VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

# Permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# Install PHP deps
RUN composer install --no-dev --optimize-autoloader \
    && php artisan optimize || true

EXPOSE 80

CMD service apache2 start && php-fpm
