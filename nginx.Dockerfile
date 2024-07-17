FROM nginx:alpine

WORKDIR /var/www

# Copy custom nginx config
COPY nginx.conf /etc/nginx/conf.d/default.conf

# Copy the application code
COPY . /var/www

# Set permissions for the storage and bootstrap/cache directories
# RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache && \
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

CMD ["nginx", "-g", "daemon off;"]