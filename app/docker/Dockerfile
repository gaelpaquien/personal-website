FROM php:8.3-fpm-alpine

LABEL maintainer="contact@gaelpaquien.com"
LABEL description="PHP with Symfony CLI and Dart Sass"

ENV COMPOSER_VERSION=2.8.0 \
    SYMFONY_CLI_VERSION=5.10.0 \
    DART_SASS_VERSION=1.80.0

RUN addgroup -g 1000 appgroup && adduser -D -G appgroup -u 1000 appuser

RUN apk add --no-cache \
        zlib-dev icu-dev zip libzip-dev netcat-openbsd curl bash autoconf make gcc libc-dev openssl && \
    pecl install apcu && \
    docker-php-ext-install intl opcache pdo pdo_mysql zip && \
    docker-php-ext-enable apcu && \
    apk del autoconf make gcc libc-dev

RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin \
    --filename=composer \
    --version=${COMPOSER_VERSION}

RUN curl -sSL -o symfony.tar.gz https://github.com/symfony-cli/symfony-cli/releases/download/v${SYMFONY_CLI_VERSION}/symfony-cli_linux_arm64.tar.gz && \
    tar xzf symfony.tar.gz && \
    mv symfony /usr/local/bin/symfony && \
    rm symfony.tar.gz

RUN ARCH=$(uname -m) && \
    if [ "$ARCH" = "x86_64" ]; then \
        curl -sSL -o dart-sass.tar.gz https://github.com/sass/dart-sass/releases/download/${DART_SASS_VERSION}/dart-sass-${DART_SASS_VERSION}-linux-x64.tar.gz && \
        tar -xzf dart-sass.tar.gz -C /usr/local/bin --strip-components=1 && \
        rm dart-sass.tar.gz && \
        ln -s /usr/local/bin/sass /usr/local/bin/dart-sass; \
    elif [ "$ARCH" = "aarch64" ]; then \
        curl -sSL -o dart-sass.tar.gz https://github.com/sass/dart-sass/releases/download/${DART_SASS_VERSION}/dart-sass-${DART_SASS_VERSION}-linux-arm64.tar.gz && \
        tar -xzf dart-sass.tar.gz -C /usr/local/bin --strip-components=1 && \
        rm dart-sass.tar.gz && \
        ln -s /usr/local/bin/sass /usr/local/bin/dart-sass; \
    else \
        echo "Unsupported architecture: $ARCH" && exit 1; \
    fi

COPY /app/docker/scripts/*.sh /usr/local/bin/scripts/
RUN chmod +x /usr/local/bin/scripts/*.sh

WORKDIR /var/www

USER appuser

ENTRYPOINT ["/usr/local/bin/scripts/build-app.sh"]

CMD ["php-fpm"]