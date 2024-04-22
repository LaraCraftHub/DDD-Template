#
# Application
# Build "laravel-ddd-php82" from ./docker/php-fpm
#
FROM laravel-ddd-php83

# Labels
LABEL Maintainer="Abdelhamid Abouhassane <abdu.abou@gmail.com>"

WORKDIR /var/www/html

# Environment
ENV APP_ENV production

# Copy composer dependecies
COPY database/ database/
COPY composer.json composer.json
COPY composer.lock composer.lock

# Check packages
RUN composer validate \
    --no-check-all \
    --no-check-publish

# Install packages
RUN composer install \
    --ignore-platform-reqs \
    --prefer-dist \
    --no-dev \
    --no-scripts \
    --no-progress \
    --no-ansi \
    --no-interaction \
    --no-plugins

# Copy project files
COPY . .
RUN composer dump-autoload --no-dev --optimize
COPY docker/entrypoint /usr/local/bin/entrypoint

# redirect access log to /dev/null
RUN sed -i 's;access\.log = .*;access.log = /dev/null;' /usr/local/etc/php-fpm.d/docker.conf \
# create first-in-first-out file for log output
    && mkfifo -m 666 /tmp/stderr \
# Redirect error log to /tmp/stderr
    && sed -i 's;error\.log = .*;error_log = /tmp/stderr;' /usr/local/etc/php-fpm.d/docker.conf \
# Finalize application optimizations
    && ./artisan optimize:clear --no-ansi --no-interaction \
    && ./artisan package:discover --no-ansi --no-interaction \
# Apply permissions
    && chown -R www-data:www-data /var/www/html \
# Display installation summary
    && ./artisan --version --no-ansi --no-interaction

# Define entry point to re exec Laravel config cache
ENTRYPOINT [ "/usr/local/bin/entrypoint" ]

# Set command 'cause of Laravel use config:cache to read env var
CMD ["sh", "-c", "exec 3<>/tmp/stderr; cat <&3 >&2 & exec php-fpm >/tmp/stderr 2>&1"]
