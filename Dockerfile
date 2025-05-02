# Imagen base con Apache y PHP
FROM php:8.2-apache

# Instalar extensiones necesarias para MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copiar tus archivos de la carpeta Vistas al contenedor
COPY ./Vistas/src/ /var/www/html/
COPY ./Vistas/css/ /var/www/html/css/
COPY ./index.php /var/www/html/
COPY ./Vistas/conexion.php /var/www/html/

# Dar permisos correctos
RUN chown -R www-data:www-data /var/www/html

# Habilitar módulo de reescritura si usas rutas amigables (opcional)
RUN a2enmod rewrite

# Exponer puerto 80
EXPOSE 80
