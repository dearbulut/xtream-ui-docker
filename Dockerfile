FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm \
    netcat-traditional \
    libzip-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy existing application directory contents
COPY . .

# Install composer dependencies without scripts
RUN composer install --no-scripts --no-interaction

# Install and build frontend dependencies
RUN npm install && npm run build

# Change ownership of our applications
RUN chown -R www-data:www-data /var/www/html

# Make start script executable
COPY start.sh .
RUN chmod +x start.sh

# Start the application
CMD ["./start.sh"]