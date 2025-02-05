FROM phpdockerio/php:8.4-fpm
WORKDIR "/srv"

# Update and install necessary packages
RUN apt-get update \
    && apt-get -y --no-install-recommends install \
        git \
        php8.4-xdebug \
        sqlite3 \
        libsqlite3-dev \
        php8.4-sqlite3 \
        php8.4-pdo \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Create a composer user and group
RUN addgroup --gid 2000 composer && \
    adduser --disabled-password --ingroup composer --uid 2000 composer
