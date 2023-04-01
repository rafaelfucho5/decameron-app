## Instalación

- Clone el repositorio del proyecto en su máquina local:
```
git clone https://github.com/rafaelfucho5/decameron-app
```

- Acceda al directorio del proyecto:
```
cd decameron-app
```
- Copie el archivo .env.example y cree un archivo .env:
```
cp .env.example .env
```
- Configure las variables de entorno en el archivo .env según sea necesario (por ejemplo, la conexión de la base de datos):
```
DB_CONNECTION=pgsql
DB_HOST=pgsql
DB_PORT=5432
DB_DATABASE=nombre_de_la_base_de_datos
DB_USERNAME=nombre_de_usuario_de_la_base_de_datos
DB_PASSWORD=contraseña_de_la_base_de_datos
```
- Ejecute el siguiente comando para construir las imágenes de Docker y ejecutar los contenedores:
```
./vendor/bin/sail up -d
```
- Ejecute el siguiente comando para instalar las dependencias del proyecto:
```
./vendor/bin/sail composer install
```
- Ejecute el siguiente comando para ejecutar las migraciones de la base de datos:
```
./vendor/bin/sail artisan migrate --seed --force
```

- Ejecute el siguiente comando para ejecutar las pruebas:
```
./vendor/bin/sail artisan test
```

## Servicios API

Los siguientes son los servicios API especificados en el archivo JSON de Postman proporcionado:

### Hotel

- index: Obtener una lista de hoteles.
- store: Crear un nuevo hotel.
- show: Obtener los detalles de un hotel.
- update: Actualizar los detalles de un hotel.
- delete: Elimina el registro de un hotel.

### Room

- index: Obtener una lista de habitaciones de un hotel.
- store: Crear un nuevo registro de habitaciones de un hotel.
- show: Obtener los detalles de habitaciones de un hotel.
- update: Actualizar los detalles de habitaciones de un hotel.
- delete: Elimina el registro de habitaciones de un hotel.

Para probar estos servicios, puede importar el archivo JSON de Postman proporcionado y ejecutar las solicitudes correspondientes. Asegúrese de actualizar la variable baseUrl en la configuración de la colección Postman con la URL correspondiente de su entorno local.

¡Listo! Ahora debería tener una instancia local del proyecto con Docker y Laravel Sail en ejecución, y estar listo para probar los servicios API especificados.
