# Proyecto Backend PHP - Laravel

Este es un proyecto de backend desarrollado con el framework Laravel. A continuación, se detallan las instrucciones para desplegar y configurar el proyecto.

## Requisitos Previos

Antes de comenzar, asegúrate de tener instalados los siguientes componentes:

- **PHP**: Versión 7.3 o superior (recomendado: 8.*)
- **Composer**: Administrador de dependencias para PHP
- **Node.js**: Para gestión de assets front-end (opcional, si usas Laravel Mix)
- **Base de datos**: MySQL, PostgreSQL, SQLite o cualquier base de datos soportada por Laravel

## Instalación

### 1. Clonar el repositorio

```bash
git clone <URL-del-repositorio>
cd Prueba-Backend-PHP
```

### 2. Instalar dependencias de PHP

Ejecuta el siguiente comando para instalar todas las dependencias definidas en `composer.json`:

```bash
composer install
```

Este comando instalará los siguientes paquetes principales:

#### Dependencias de Producción:
- `php`: ^7.3|^8.0
- `fruitcake/laravel-cors`: ^2.0 (Para manejo de CORS)
- `guzzlehttp/guzzle`: ^7.0.1 (Cliente HTTP)
- `laravel/framework`: ^8.75 (Framework Laravel)
- `laravel/tinker`: ^2.5 (Consola interactiva)

#### Dependencias de Desarrollo:
- `facade/ignition`: ^2.5 (Página de errores mejorada)
- `fakerphp/faker`: ^1.9.1 (Generación de datos falsos)
- `laravel/sail`: ^1.0.1 (Entorno de desarrollo Docker)
- `mockery/mockery`: ^1.4.4 (Framework de mock para pruebas)
- `nunomaduro/collision`: ^5.10 (Mejor salida de errores en consola)
- `phpunit/phpunit`: ^9.5.10 (Framework de pruebas unitarias)

### 3. Configurar el entorno

Copia el archivo de configuración de ejemplo:

```bash
cp .env.example .env
```

Edita el archivo `.env` para configurar:
- Conexión a la base de datos (DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD)
- APP_KEY (generar con `php artisan key:generate`)
- Otras configuraciones específicas del proyecto

### 4. Generar clave de aplicación

```bash
php artisan key:generate
```

### 5. Ejecutar migraciones de base de datos

```bash
php artisan migrate
```

Si deseas poblar la base de datos con datos de prueba:

```bash
php artisan db:seed
```



## Estructura del Proyecto

- `app/`: Código de la aplicación
  - `Http/Controllers/`: Controladores (ProductoController, InventarioController, BodegaController)
  - `Models/`: Modelos Eloquent (Producto, Inventario, Bodega, Historiale, User)
- `database/migrations/`: Migraciones de base de datos
- `database/seeders/`: Seeders para poblar datos
- `routes/api.php`: Definición de rutas API
- `config/`: Archivos de configuración

## Funcionalidades Principales

Este proyecto implementa un sistema completo de gestión de inventario que permite:

### Gestión de Productos
- **Crear productos**: Permite crear nuevos productos con descripción y asignar una cantidad inicial automáticamente a la "Bodega General".
- **Listar productos**: Obtiene la lista de productos activos ordenados por el total de inventario descendente, incluyendo el total acumulado en todas las bodegas.

### Gestión de Inventarios
- **Agregar inventario**: Permite añadir cantidades adicionales de un producto existente a una bodega específica.
- **Transferir inventario**: Facilita el traslado de productos entre diferentes bodegas, validando la disponibilidad en el origen y actualizando ambos inventarios.

### Gestión de Bodegas
- **Crear bodegas**: Permite registrar nuevas bodegas con información de responsable y estado.
- **Listar bodegas**: Obtiene todas las bodegas ordenadas alfabéticamente.

### Historial de Operaciones
- Registra automáticamente todas las operaciones de creación, actualización y transferencia de inventario para auditoría y seguimiento.

## API Endpoints

### Endpoints Disponibles

#### Bodegas
- **GET /api/bodegas**
  - Lista todas las bodegas ordenadas por nombre.
  - Respuesta: Array de objetos bodega con id, nombre, estado, etc.

- **POST /api/bodegas**
  - Crea una nueva bodega.
  - Parámetros requeridos: `nombre` (string)
  - Parámetros opcionales: `id_responsable` (integer), `estado` (string), `created_by` (integer), `updated_by` (integer)
  - Ejemplo:
    ```json
    {
      "nombre": "Bodega Norte",
      "id_responsable": 1,
      "estado": "activo"
    }
    ```

#### Productos
- **GET /api/productos/total-desc**
  - Lista productos activos con el total de inventario acumulado, ordenado descendentemente.
  - Respuesta: Array de productos con id, nombre, descripcion, estado, total.

- **POST /api/productos**
  - Crea un nuevo producto y asigna cantidad inicial a "Bodega General".
  - Parámetros requeridos: `nombre` (string, máx. 50), `descripcion` (string, máx. 300), `cantidad_inicial` (integer, mínimo 0)
  - Ejemplo:
    ```json
    {
      "nombre": "Producto A",
      "descripcion": "Descripción del producto A",
      "cantidad_inicial": 100
    }
    ```

#### Inventarios
- **POST /api/inventarios**
  - Agrega cantidad a un inventario existente o crea uno nuevo si no existe.
  - Parámetros requeridos: `id_producto` (integer), `id_bodega` (integer), `cantidad` (integer, mínimo 1)
  - Ejemplo:
    ```json
    {
      "id_producto": 1,
      "id_bodega": 2,
      "cantidad": 50
    }
    ```

- **POST /api/inventarios/transfer**
  - Transfiere cantidad de un producto entre bodegas.
  - Parámetros requeridos: `id_producto` (integer), `id_bodega_origen` (integer), `id_bodega_destino` (integer), `cantidad` (integer, mínimo 1)
  - Validaciones: Origen y destino deben ser diferentes, cantidad suficiente en origen.
  - Ejemplo:
    ```json
    {
      "id_producto": 1,
      "id_bodega_origen": 2,
      "id_bodega_destino": 3,
      "cantidad": 25
    }
    ```

## Ejecución y Pruebas

### 1. Ejecutar el servidor

```bash
php artisan serve
```

El servidor estará disponible en `http://localhost:8000` por defecto.

### 2. Probar la API

Puedes usar herramientas como Postman, Insomnia o curl para probar los endpoints.

#### Ejemplo con curl - Crear un producto:
```bash
curl -X POST http://localhost:8000/api/productos \
  -H "Content-Type: application/json" \
  -d '{
    "nombre": "Producto de Prueba",
    "descripcion": "Descripción de prueba",
    "cantidad_inicial": 10
  }'
```

#### Ejemplo con curl - Listar productos:
```bash
curl -X GET http://localhost:8000/api/productos/total-desc
```

### 3. Base de datos de prueba

Para poblar la base de datos con datos de prueba:

```bash
php artisan db:seed
```

Esto ejecutará todos los seeders disponibles en `database/seeders/` incluyendo BodegaSeeder, ProductoSeeder, InventarioSeeder y HistorialeSeeder.

## Estructura de la Base de Datos

- **bodegas**: Almacena información de las bodegas (id, nombre, id_responsable, estado)
- **productos**: Contiene los productos (id, nombre, descripcion, estado)
- **inventarios**: Registra las cantidades por producto y bodega (id, id_bodega, id_producto, cantidad)
- **historiales**: Audita todas las operaciones (id, cantidad, id_bodega_origen, id_bodega_destino, id_inventario, created_by, updated_by)
- **users**: Usuarios del sistema (proporcionado por Laravel)

Todas las tablas incluyen campos de auditoría (created_by, updated_by, timestamps) y soft deletes.



