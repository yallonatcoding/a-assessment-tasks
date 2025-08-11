# Proyecto Laravel + React con Docker

## Descripción
Este proyecto es una aplicación Laravel con frontend en React (usando Inertia.js), que permite gestionar tareas con funcionalidades como paginado, creación, actualización y eliminación.  
Está dockerizado para facilitar su instalación y ejecución.

---

## Requisitos

- Docker instalado en tu máquina.
- (Opcional) Node.js y PHP si quieres ejecutar fuera de Docker.

---

## Ejecución con Docker

1. Construir la imagen del contenedor PHP + Composer:

```bash
- docker compose build php_composer
- docker compose up -d db php_composer
- docker compose exec php_composer composer install
- docker compose exec php_composer php artisan passport:keys
- docker compose exec php_composer php artisan migrate
- docker compose exec php_composer php artisan key:generate
- docker compose exec php_composer php artisan serve --host=0.0.0.0 --port=8000
- docker compose up -d node
- docker compose exec node npm install
- docker compose exec node npm run dev -- --host
```

## Credenciales de prueba
No hay credenciales de prueba, puede crear nuevo registro

## Funcionamiento
Laravel actúa como backend y servidor web.
React renderiza la interfaz, comunicándose con Laravel via Inertia.js o Axios.
La base de datos es PostgreSQL, dockerizada para facilitar su despliegue.
Incluye control de tareas con paginado, filtrado, creación y actualización.
Se usa arquitectura limpia para separar dominio, infraestructura y presentación.

Docker Compose orquesta los servicios de PHP, Node y la base de datos.

## Dependencias principales
- Laravel 12
- React 18
- Inertia.js / Axios
- PostgreSQL 16
- Docker Compose
- TailwindCSS 4

## Notas
Ajusta las variables de entorno en .env para tu entorno local.
Usa docker compose logs para debuggear los contenedores.
