# Gestor Financiero

Sistema web hecho con Laravel 12, Breeze (Blade) y MySQL para administrar
ingresos, gastos y el saldo de varias cuentas.

## Requisitos
PHP 8.2 o superior, Composer, Node.js y MySQL.

## Instalación
```bash
composer install
npm install
copy .env.example .env
php artisan key:generate
```

Crea en MySQL la base de datos `gestor_financiero`, revisa los datos de
conexión en `.env` y luego:

```bash
php artisan migrate:fresh --seed
npm run dev
php artisan serve
```

También puedes importar `database/gestor_financiero.sql` en una base vacía
llamada `gestor_financiero`, en lugar de usar migraciones y seeders.

## Acceso de prueba
- Correo: admin@gestor.test
- Contraseña: password

## Módulos
Categorías, Cuentas y Transacciones (solo para usuarios autenticados).