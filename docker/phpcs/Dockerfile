FROM alpine:latest

RUN apk add --no-cache \
    php7 \
    php7-phar \
    php7-tokenizer \
    php7-xmlwriter \
    php7-simplexml

RUN apk add --no-cache \
    curl

RUN curl -s https://squizlabs.github.io/PHP_CodeSniffer/phpcs.phar > /usr/local/bin/phpcs \
    && chmod +x /usr/local/bin/phpcs

RUN apk del curl

VOLUME ["/app"]
WORKDIR /app

ENTRYPOINT ["phpcs"]
