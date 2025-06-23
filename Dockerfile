FROM php:8.2.0-fpm

# Accept build arguments (for Docker Compose or CodeBuild)
ARG user=sammy
ARG uid=1000

# Create a group and user with the given UID
RUN addgroup --gid ${uid} ${user} \
    && adduser --disabled-password --gecos "" --uid ${uid} --ingroup ${user} ${user}

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
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Get Composer from official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Setup composer home directory for the user
RUN mkdir -p /home/${user}/.composer \
    && chown -R ${user}:${user} /home/${user}

# Set working directory
WORKDIR /var/www

# Switch to the non-root user
USER ${user}
