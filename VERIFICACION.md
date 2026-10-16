# Verificación de la entrega

Entorno: PHP 8.3.6, Laravel Framework 12.70.0, SQLite en memoria.

- `php artisan test`: **12 pruebas aprobadas, 100 comprobaciones**.
- `php artisan view:cache`: compilación de todas las vistas Blade correcta.
- `php artisan route:list --except-vendor`: rutas registradas correctamente.
- `composer validate --no-check-publish`: composer.json válido.
- Revisión de sintaxis PHP del código de aplicación y vistas compiladas: sin errores.

Los tests están en `tests/Feature/PasteleriaTest.php`. Se incluyen `composer.json` y `composer.lock` para instalar las versiones verificadas. No se incluyen vendor, credenciales locales, cachés, registros ni bases de datos de pruebas.

Pendiente de validar en tu computadora: conexión a MySQL/MariaDB en Laragon, importación de tu base real, enlaces de almacenamiento en Windows y concurrencia de dos empleados en MySQL. Las pruebas SQLite verifican transacciones y doble aceptación secuencial; no reproducen los bloqueos de filas de InnoDB.

El importador se entrega con validación de base destino vacía y transacción; no se ejecutó sobre una base anterior real porque no venía un volcado de datos en el ZIP recibido.
