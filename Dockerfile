FROM php:8.2.0-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libfreetype6-dev libjpeg62-turbo-dev \
    zip \
    unzip \
    libmagickwand-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*  # Clean up to save space

RUN docker-php-ext-install -j$(nproc) gd
# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user \
    && mkdir -p /home/$user/.composer \
    && chown -R $user:$user /home/$user

# Set the working directory
WORKDIR /var/www

# Switch to the user created
USER $user
