# Proyecto Laravel + React con Docker para Task Management

## Descripción
Este proyecto es una aplicación Laravel con frontend en React (usando Inertia.js), que permite gestionar tareas con funcionalidades como paginado, creación, actualización y eliminación.  
Está dockerizado para facilitar su instalación y ejecución.

---

## Ejecución con Docker

Requisitos:
- Docker

Pasos:
1. Construir la imagen del contenedor PHP + Composer:
```bash
- cp .env.example .env
- docker compose build --target dev -t php_composer
- docker compose up -d db php_composer
- docker compose exec php_composer composer install
- docker compose exec php_composer php artisan passport:keys
- docker compose exec php_composer php artisan key:generate
- docker compose exec php_composer php artisan migrate
- docker compose exec php_composer php artisan serve --host=0.0.0.0 --port=8000
- docker compose up -d node
- docker compose exec node npm install
- docker compose exec node npm run dev -- --host
```
2. Abrir en el navegador: http://localhost:8000

## Ejecución sin Docker

Requisitos:
- PHP 8.4 o superior
- Composer
- Node.js (v20 recomendado) y npm
- PostgreSQL

Pasos:
```bash
- cp .env.example .env
- composer install
- npm install
- php artisan key:generate
- php artisan migrate
- php artisan serve
- npm run dev
```
9. Abrir en el navegador: http://localhost:8000


## Funcionamiento
Laravel actúa como backend y servidor web.

React renderiza la interfaz, comunicándose con Laravel via Inertia.js o Axios.

Incluye control de tareas con paginado, creación, actualización y eliminación.

Se usa arquitectura limpia para separar dominio, infraestructura y presentación en controllers.

La base de datos es PostgreSQL.

## Dependencias principales
- Laravel 12
- React 18
- Inertia.js
- PostgreSQL 16
- Vite 7
- TailwindCSS 4

Pruébalo aquí: https://a-assessment-tasks.onrender.com/register

## Credenciales de prueba
No hay credenciales de prueba, se puede crear nuevo registro.
