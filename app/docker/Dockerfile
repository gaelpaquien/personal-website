FROM php:8.3-fpm-alpine

ENV COMPOSER_VERSION=2.8.0 \
    SYMFONY_CLI_VERSION=5.10.0

RUN addgroup -g 1000 appgroup && adduser -D -G appgroup -u 1000 appuser

RUN apk add --no-cache \
        zlib-dev icu-dev zip libzip-dev curl bash autoconf make gcc libc-dev && \
    docker-php-ext-install intl pdo pdo_mysql zip && \
    apk del autoconf make gcc libc-dev

RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin \
    --filename=composer \
    --version=${COMPOSER_VERSION}

RUN curl -sSL -o symfony.tar.gz https://github.com/symfony-cli/symfony-cli/releases/download/v${SYMFONY_CLI_VERSION}/symfony-cli_linux_arm64.tar.gz && \
    tar xzf symfony.tar.gz && \
    mv symfony /usr/local/bin/symfony && \
    rm symfony.tar.gz

COPY /app/docker/scripts/*.sh /usr/local/bin/scripts/
RUN chmod +x /usr/local/bin/scripts/*.sh

WORKDIR /var/www

USER appuser

ENTRYPOINT ["/usr/local/bin/scripts/build-app.sh"]

CMD ["php-fpm"]