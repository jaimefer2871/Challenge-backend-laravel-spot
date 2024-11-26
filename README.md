# Backend Laravel Lumen Framework - URLShorter

Este proyecto se encuentra desarrollo en Laravel Lumen, un microframework de Laravel que contiene solo los paquetes necesarios para la construccion de API.

## Requerimientos

-   PHP8.1 o mayor
-   OpenSSL PHP
-   PDO PHP Extension
-   Mbstring PHP Extension

## Instalación

Luego de clonar el proyecto, se deben ejecutar los siguientes pasos:

-   php composer.phar install
-   Configurar el archivo .env con las variables de entornos requeridas (pueden tomar de ejemplo el archivo .env.example)
-   Generar el APP_KEY. Ejecutar: `php artisan key:generate` y colocar el valor en la variable mencionada.
-   php artisan swagger-lume:generate (_Para generacion de documentación mediante Swagger_)

## Ejecución (Local)

Desde la raiz del proyecto, ejecutar: **php -S localhost:8000 public/index.php**

## Ejecución (Produccion)

Para efectos de esta prueba, se desplegara la API medainte apache en un ambiente
Linux de la siguiente manera:

1. Crear un punto de conexion en la carpeta `/etc/apache/sites-availables/`

Ej: `001-api-backend.conf`

```

ServerName localhost
<VirtualHost _default_:7000>
        ServerAdmin xxx@xx.net
        ServerAlias url.domain.com
        DocumentRoot /var/www/Challenge-backend-laravel-spot/public/

        <Directory  />
                Options FollowSymLinks
                AllowOverride all
                Require all granted
        </Directory>

    <Directory /var/www/Challenge-backend-laravel-spot >
            Options Indexes FollowSymLinks MultiViews ExecCGI
            AllowOverride All
            Order allow,deny
            Allow from all
            Require all granted
    </Directory>

        ErrorLog /var/www/Challenge-backend-laravel-spot/error.log
        LogLevel error
        CustomLog /var/www/Challenge-backend-laravel-spot/access.log combined
</VirtualHost>

```

**\*Nota**: Para este caso concreto, se uso el puerto 7000\*

2. Luego se activa mediante el comando: `sudo a2ensite 001-api-backend.conf`

3. Por ultimo, se recarga la configuracion del apache mediante el comando:
   `sudo systemctl reload apache2`

Al completar los pasos anteriores, accedemos a la api desde el dominio que
tengamos configurado mediante la url:

`http://my-domain.com:7000`

## Acceso documentacion Swagger

Para acceder a la documentacion, basta con ingresar a la ruta (Ya con el proyecto previamente levantado):

`http://my-domain.com/api/documentation`
