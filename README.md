# Gestión de Tareas

Aplicación fullstack para gestionar tareas, desarrollada como desafío técnico con Laravel, Vue 3, MySQL y Docker.

## Stack

- Backend: Laravel 13
- Frontend: Vue 3 + Pinia + Axios + Bootstrap 5
- Base de datos: MySQL 8
- Entorno: Docker Compose

## Funcionalidades

- Listado de tareas
- Creación de tareas
- Edición de tareas
- Eliminación de tareas con confirmación
- Cambio de estado
- Asignación de prioridad
- Asignación de una o varias etiquetas
- Filtros por título, estado y fecha de vencimiento
- Datos de prueba con seeders

## Estructura del proyecto

```text
crud-laravel/
├── backend/     # API REST en Laravel
├── frontend/    # SPA en Vue 3
├── docker-compose.yml
└── Dockerfile
```

## Requisitos

- Docker

No es necesario tener PHP, Composer o Node instalados en la máquina local.

## Puertos

- Backend Laravel: `http://localhost:8080`
- Frontend Vue: `http://localhost:5173`
- MySQL: `localhost:3306`

## Instalación inicial

### 1. Clonar el repositorio

```bash
git clone <URL_DEL_REPOSITORIO>
cd crud-laravel
```

### 2. Crear los archivos de entorno

```bash
cp backend/.env.example backend/.env
cp frontend/.env.example frontend/.env
```

Editar `backend/.env` con estos valores:

```env
APP_NAME="Gestión de Tareas"
APP_URL=http://localhost:8080

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=task_manager
DB_USERNAME=task_user
DB_PASSWORD=task_password
```

Editar `frontend/.env` con este valor:

```env
VITE_API_URL=http://localhost:8080/api
```

### 3. Levantar los contenedores

```bash
docker compose up -d --build
```

### 4. Instalar dependencias del backend

```bash
docker exec -it crud_laravel_app composer install
```

### 5. Generar la key de Laravel

Solo hace falta la primera vez, o si `APP_KEY` está vacía en `backend/.env`.

```bash
docker exec -it crud_laravel_app php artisan key:generate
```

### 6. Ejecutar migraciones y seeders

```bash
docker exec -it crud_laravel_app php artisan migrate --seed
```

### 7. Instalar dependencias del frontend

```bash
docker compose run --rm frontend npm install --legacy-peer-deps
```

## Cómo levantar el proyecto

Una vez instalado todo:

```bash
docker compose up -d
```

Luego abrir:

- `http://localhost:5173` para usar la app
- `http://localhost:8080/api/tasks` para probar la API

## Comandos útiles

### Backend

```bash
docker exec -it crud_laravel_app php artisan migrate
docker exec -it crud_laravel_app php artisan db:seed
docker exec -it crud_laravel_app php artisan route:list
docker exec -it crud_laravel_app php artisan config:clear
```

## Endpoints principales

- `GET /api/tasks`
- `GET /api/tasks/{id}`
- `POST /api/tasks`
- `PUT /api/tasks/{id}`
- `DELETE /api/tasks/{id}`
- `GET /api/priorities`
- `GET /api/tags`

## Seeders incluidos

- `PrioritySeeder`
- `TagSeeder`
- `TaskSeeder`

El seeder de tareas carga registros de ejemplo con distintos estados, prioridades, fechas y etiquetas para facilitar la demo.

## Decisiones de implementación

- Se incorporó Bootstrap 5 para acelerar la maquetación y mantener una interfaz clara y consistente.
- Se usó `apiResource` para el CRUD de tareas.
- Se trabajó con Resource Controllers para mantener una estructura clásica y ordenada de métodos REST.
- Se separó frontend y backend en carpetas distintas.
- Se manejó estado global del frontend con Pinia.
- Se agregaron componentes reutilizables para toast y modal de confirmación.
- Se cargan catálogos de prioridades y etiquetas desde el backend.

## Posibles mejoras

- Manejo global de errores en backend y frontend
- Pruebas automatizadas
- Paginación en listado
- Autenticación básica
