FROM alpine:latest

RUN apk add --no-cache \
    php7 \
    php7-phar \
    php7-tokenizer \
    php7-json \
    php7-mbstring

RUN apk add --no-cache \
    curl

RUN curl -L -s https://cs.symfony.com/download/php-cs-fixer-v2.phar -o /usr/local/bin/phpcs \
    && chmod a+x /usr/local/bin/phpcs

RUN apk del curl

VOLUME ["/app"]
WORKDIR /app

ENTRYPOINT ["phpcs"]
