FROM php:8.3-fpm

# User and group configuration
RUN groupadd -g 1001 app && useradd -m -u 1001 -g app app

# Global configuration and installation
RUN apt-get update && apt-get upgrade -y \
    && apt-get install -y --no-install-recommends \
        zlib1g-dev g++ git libicu-dev zip libzip-dev netcat-openbsd \
    && pecl install apcu \
    && docker-php-ext-install intl opcache pdo pdo_mysql zip \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
ENV COMPOSER_VERSION=2.8.0
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin \
    --filename=composer \
    --version=${COMPOSER_VERSION}

# Install Symfony CLI
ENV SYMFONY_CLI_VERSION=5.10.0
RUN curl -sSL -o symfony.tar.gz https://github.com/symfony-cli/symfony-cli/releases/download/v${SYMFONY_CLI_VERSION}/symfony-cli_linux_arm64.tar.gz \
    && tar xzf symfony.tar.gz \
    && mv symfony /usr/local/bin/symfony \
    && rm symfony.tar.gz

# Install Dart Sass
ENV DART_SASS_VERSION=1.80.0
RUN ARCH=$(uname -m) && \
    if [ "$ARCH" = "x86_64" ]; then \
        curl -sSL -o dart-sass.tar.gz https://github.com/sass/dart-sass/releases/download/${DART_SASS_VERSION}/dart-sass-${DART_SASS_VERSION}-linux-x64.tar.gz; \
    elif [ "$ARCH" = "aarch64" ]; then \
        curl -sSL -o dart-sass.tar.gz https://github.com/sass/dart-sass/releases/download/${DART_SASS_VERSION}/dart-sass-${DART_SASS_VERSION}-linux-arm64.tar.gz; \
    else \
        echo "Unsupported architecture: $ARCH" && exit 1; \
    fi && \
    tar -xzf dart-sass.tar.gz -C /usr/local/bin --strip-components=1 && \
    rm dart-sass.tar.gz

# Set working directory
WORKDIR /var/www

# Copy and give execute permissions to scripts
COPY scripts/*.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/*.sh

# Switch to non-root user
USER app

# Start script to build and run the application
CMD ["/usr/local/bin/start.sh"]