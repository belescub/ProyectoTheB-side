Instrucciones para levantar el proyecto:

Clonar el repositorio.

Crear la base de datos grupo3 vacía.

Ejecutar composer install y npm install.

Copiar .env.example a .env y configurar la base de datos.

Ejecutar php artisan migrate --seed para poblar la base de datos.

IMPORTANTE: Ejecutar php artisan storage:link para poder visualizar las imágenes de los productos.

Tuvimos que ejecutar el comando php artisan storage:link ya que surgio un problema con las imagenes, estas no cargaban cuando se clonaba el proyecto en otro dispositivo. 