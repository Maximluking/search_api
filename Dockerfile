FROM yiisoftware/yii2-php:8.1-apache
RUN apt-get update && apt-get install -y

COPY . /app
WORKDIR  /app
RUN composer install --prefer-dist --optimize-autoloader
RUN composer dump-autoload
RUN composer update --no-scripts
RUN mkdir runtime && chown www-data:www-data runtime


RUN echo "zend_extension=xdebug.so" > /usr/local/etc/php/conf.d/xdebug.ini && \
    echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/xdebug.ini && \
    echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/xdebug.ini && \
    echo "xxdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/xdebug.ini && \
    echo "xdebug.discover_client_host=true" >> /usr/local/etc/php/conf.d/xdebug.ini && \
    echo "xdebug.client_port=8000" >> /usr/local/etc/php/conf.d/xdebug.ini