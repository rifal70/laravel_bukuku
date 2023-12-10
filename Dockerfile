FROM php:8.2-cli

# Instal dependensi
RUN apt-get update && apt-get install -y \
    git \
    unzip

# Pindah ke direktori aplikasi
WORKDIR /var/www/html

# Salin file proyek ke dalam images
COPY . /var/www/html

# Jalankan perintah instalasi
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

# Menambahkan direktori vendor ke PATH
ENV PATH="~/.composer/vendor/bin:$PATH"

# Instal dependensi proyek menggunakan Composer
RUN composer install

# Port yang akan diexpose
EXPOSE 6069

# Perintah default yang akan dijalankan saat kontainer dijalankan
CMD ["php", "artisan", "serve", "--host=127.0.0.1", "--port=6069"]