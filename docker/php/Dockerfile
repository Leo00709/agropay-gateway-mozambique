FROM php:8.3-fpm-alpine

# Install dependencies
RUN apk add --no-cache \
    libpq-dev \
    postgresql-client \
    openssl \
    curl \
    git \
    zip \
    unzip

# Install PHP extensions
RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    bcmath \
    json \
    curl \
    mbstring

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Set working directory
WORKDIR /var/www/backend

# Copy application
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Expose port
EXPOSE 9000

CMD ["php-fpm"]
