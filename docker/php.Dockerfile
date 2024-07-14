# Pull the composer image
FROM composer:latest as composer

FROM php:8.3-fpm

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    curl \
    unzip \
    git \
    libzip-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pgsql pdo_pgsql pdo_mysql mbstring exif pcntl bcmath gd zip 

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
# COPY --from=composer /usr/bin/composer /usr/bin/composer

# Remove default server definition
RUN rm -rf /var/www/html

# Install Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Copy existing application directory contents
COPY . .

# Install application dependencies
RUN composer install

# Copy existing application directory contents
RUN chown -R www-data:www-data /var/www

# RUN chown -R www-data:www-data /path/to/your/project/storage /path/to/your/project/bootstrap/cache
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache


# Change current user to www
USER www-data

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]