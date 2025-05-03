# Usar una imagen base de PHP con Apache
FROM php:8.2-apache

# Instalar extensiones necesarias de PHP
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Habilitar el módulo rewrite de Apache (útil para URLs amigables)
RUN a2enmod rewrite

# Copiar los archivos de tu proyecto al directorio raíz del servidor
COPY . /var/www/html/

# Cambiar el DocumentRoot a la carpeta Vistas
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/Vistas|' /etc/apache2/sites-available/000-default.conf

# Asegurar permisos adecuados
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Configurar ServerName para evitar el mensaje de advertencia
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Exponer el puerto 80 (usado por Apache)
EXPOSE 80

# Iniciar Apache en modo foreground
CMD ["apache2-foreground"]