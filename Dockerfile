FROM php:latest
RUN apt-get update && apt-get install -y \
    unzip \
 && apt-get clean \
 && rm -rf /var/lib/apt/lists/*

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_NO_INTERACTION 1
ENV COMPOSER_HOME /opt/composer
ENV PATH $PATH:/opt/composer/vendor/bin

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN composer global require knplabs/github-api:^3.0 guzzlehttp/guzzle:^7.0.1 http-interop/http-factory-guzzle:^1.0
