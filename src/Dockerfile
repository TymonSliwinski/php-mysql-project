FROM php:8.2-cli
WORKDIR /usr/src/php
EXPOSE 8000
RUN docker-php-ext-install pdo_mysql
CMD ["php", "-S", "0.0.0.0:8000"]
