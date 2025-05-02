FROM php:8.2-apache

# Instalar mysqli
RUN docker-php-ext-install mysqli

# Copiar tu código al directorio raíz del servidor web
COPY . /var/www/html/

# Puerto que expone Apache (Railway espera que uses el 80)
EXPOSE 80
