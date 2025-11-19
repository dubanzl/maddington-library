FROM php:8.4-cli

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy composer files first
COPY composer.json composer.lock ./

# Install dependencies (production - no dev dependencies)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Copy application source code
COPY Core/ ./Core/
COPY app.php ./

# Regenerate autoloader to include Core namespace
RUN composer dump-autoload --optimize --no-dev --no-interaction

# Create data directory if it doesn't exist
RUN mkdir -p Core/data && \
    touch Core/data/books.json Core/data/members.json \
    Core/data/otherResources.json Core/data/transactions.json && \
    echo '[]' > Core/data/books.json && \
    echo '[]' > Core/data/members.json && \
    echo '[]' > Core/data/otherResources.json && \
    echo '[]' > Core/data/transactions.json

# Set permissions
RUN chmod -R 755 Core/data

# Expose port (if needed for future web interface)
EXPOSE 8000

# Default command
CMD ["php", "app.php"]

