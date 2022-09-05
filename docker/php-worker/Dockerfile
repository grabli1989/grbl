ARG PROJECT_PHP_VERSION
FROM php:${PROJECT_PHP_VERSION}-alpine

ARG PROJECT_PHP_VERSION

RUN apk --update add wget \
  curl \
  git \
  build-base \
  libmcrypt-dev \
  libxml2-dev \
  pcre-dev \
  zlib-dev \
  autoconf \
  cyrus-sasl-dev \
  libgsasl-dev \
  oniguruma-dev \
  libressl \
  libressl-dev \
  supervisor


RUN pecl channel-update pecl.php.net; \
    docker-php-ext-install \
      mysqli \
      mbstring \
      pdo \
      pdo_mysql \
      xml

# Add a non-root user:
ARG PUID=1000
ENV PUID ${PUID}
ARG PGID=1000
ENV PGID ${PGID}

RUN addgroup -g ${PGID} www && \
    adduser -D -G www -u ${PUID} www

#Install GD package:
RUN apk add --update --no-cache \
      freetype-dev \
      libjpeg-turbo-dev \
      jpeg-dev \
      libpng-dev; \
    docker-php-ext-configure gd --with-freetype --with-jpeg --with-png; \
    docker-php-ext-install gd

#Install ImageMagick:
RUN set -eux; \
    apk add --update --no-cache imagemagick-dev imagemagick; \
    pecl install imagick-3.7.0; \
    docker-php-ext-enable imagick; \
    php -m | grep -q 'imagick';

#
#--------------------------------------------------------------------------
# Optional Supervisord Configuration
#--------------------------------------------------------------------------
#
# Modify the ./supervisor.conf file to match your App's requirements.
# Make sure you rebuild your container with every change.
#

COPY supervisord.conf /etc/supervisord.conf

ENTRYPOINT ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisord.conf"]

#
#--------------------------------------------------------------------------
# Optional Software's Installation
#--------------------------------------------------------------------------
#
# If you need to modify this image, feel free to do it right here.
#
    # -- Your awesome modifications go here -- #

#
#--------------------------------------------------------------------------
# Check PHP version
#--------------------------------------------------------------------------
#

RUN php -v | head -n 1 | grep -q "PHP ${PHP_VERSION}."

#
#--------------------------------------------------------------------------
# Final Touch
#--------------------------------------------------------------------------
#

# Clean up
RUN rm /var/cache/apk/* \
    && mkdir -p /var/www

WORKDIR /etc/supervisor/conf.d/
