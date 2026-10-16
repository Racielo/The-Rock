# The Rock — Proyecto convertido a Laravel 12

Autor del proyecto: Zair Rodríguez García.

Esta entrega convierte el MVC PHP del ZIP recibido en una aplicación Laravel con rutas, controladores, modelos Eloquent, vistas Blade, middleware por roles y migraciones. Conserva las imágenes, CSS y pantallas principales del proyecto original. Requiere PHP 8.2 o superior y Composer 2. Usa MySQL/MariaDB con tablas InnoDB para la aplicación; las pruebas automatizadas utilizan SQLite.

## 1. Instalación en Laragon (base nueva)

1. Inicia MySQL en Laragon. Extrae `The-Rock-Laravel` en `D:\laragon\www\` (o `C:\laragon\www\`, según tu instalación).
2. Abre la terminal de Laragon en esa carpeta, donde están `artisan` y `composer.json`.
3. Comprueba `php -v` y `composer --version`. En PHP activa PDO MySQL, mbstring, openssl, fileinfo, tokenizer, XML/DOM y ctype; ZIP y cURL facilitan Composer. Para las pruebas activa PDO SQLite.
4. Ejecuta:

```bat
composer install
copy .env.example .env
php artisan key:generate
```

En PowerShell también puedes usar `Copy-Item .env.example .env`. No vuelvas a copiar `.env` ni a generar la clave cuando ya tengas la instalación funcionando.

5. Crea una base **nueva** desde HeidiSQL/phpMyAdmin:

```sql
CREATE DATABASE therock_laravel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

6. Revisa `.env`: `DB_DATABASE=therock_laravel`, `DB_USERNAME=root` y `DB_PASSWORD=` (escribe tu contraseña si tu MySQL la usa). El puerto predeterminado es 3306.
7. Ejecuta:

```bat
php artisan migrate
php artisan storage:link
php artisan rock:admin
php artisan serve
```

`rock:admin` solicita nombre, correo y contraseña. **El administrador entra con los datos que tú elijas; no hay una contraseña predeterminada.**

8. Abre http://127.0.0.1:8000. Inicia sesión como administrador, registra insumos y productos con su receta. Crea una cuenta de cliente desde “Crear cuenta”.

Para una demostración opcional, con catálogo e inventario vacíos:

```bat
php artisan db:seed --class=DemoSeeder
```

Incluye un pastel y dos ingredientes de ejemplo, no datos reales. No crea cuentas.

No necesitas Node, NPM ni Vite: se sirven los CSS y JavaScript originales directamente. Si utilizas un dominio `.test` de Laragon, el directorio raíz del sitio debe ser `The-Rock-Laravel/public`, y `APP_URL` debe coincidir con ese dominio. Nunca sirvas la raíz del proyecto como directorio público.

## 2. Si quieres conservar tu base anterior

El ZIP recibido incluye estructura SQL, pero **no contiene un volcado de tus registros de MySQL**. Tus productos, usuarios y pedidos reales siguen en tu computadora.

1. Respalda la base anterior y sus fotografías. Detén las escrituras en la aplicación PHP mientras copias los datos.
2. Crea `therock_laravel`, configura `.env` y ejecuta `php artisan migrate`. **No ejecutes aún `rock:admin` ni `DemoSeeder`**; las tablas de destino deben estar vacías.
3. Con ambas bases en el mismo servidor MySQL y accesibles al usuario de `.env`, ejecuta:

```bat
php artisan rock:importar therock
```

Cambia `therock` si tu base anterior tiene otro nombre. El comando lee el origen, copia registros conservando sus IDs y se niega a sobrescribir un destino con datos. Requiere las siete tablas del proyecto mejorado, incluidas `recetas` y `movimientos_inventario`. Si faltan, prepara primero una copia de la base antigua usando los SQL de tu entrega anterior. No apuntes las migraciones directamente a la base antigua.

4. Copia el contenido de `public/uploads/productos` del proyecto viejo a la misma carpeta relativa del proyecto Laravel. Las rutas antiguas `public/uploads/...` se adaptan en las vistas. Copia cualquier imagen personalizada adicional de `public/assets/img`.
5. Entra con tu cuenta anterior. Si era una contraseña en texto plano, el importador la convierte a hash. Para una contraseña desconocida o un hash de otro algoritmo usa:

```bat
php artisan rock:password correo@ejemplo.com
```

Si no había administrador, créalo después de importar con `php artisan rock:admin`. No se modifica la base original.

## 3. Funciones y permisos

| Función | Cliente | Empleado | Administrador |
|---|---|---|---|
| Consultar catálogo | Sí | Sí | Sí |
| Solicitar pedidos y ver los propios | Sí | No | No |
| Aceptar/rechazar y avanzar pedidos | No | Sí | Sí |
| Consultar inventario | No | Sí | Sí |
| Modificar insumos | No | No | Sí |
| Productos, fotografías y recetas | No | No | Sí |
| Crear/editar/desactivar clientes y empleados | No | No | Sí |
| Respaldar/restaurar datos | No | No | Sí |
| Editar perfil propio | Sí | Sí | Sí |

Las cuentas de administrador se crean en terminal. El registro público siempre crea clientes. Las cuentas inactivas no pueden iniciar sesión ni usar rutas protegidas. Los formularios usan protección CSRF de Laravel y los permisos se verifican en servidor.

## 4. Regla de inventario

Crear un pedido solo registra la solicitud y calcula el total desde el precio de la base. No descuenta materias primas.

Al aceptar, `PedidoService` abre una transacción, bloquea el pedido y los insumos, suma las cantidades de cada receta, valida caducidad y existencias y registra cada movimiento. Si falta un ingrediente, se revierte toda la operación. Un pedido aceptado no se puede aceptar otra vez. Se usan milésimas enteras en el cálculo para no acumular errores decimales.

Estados: Pendiente → Aceptado → En preparación → Listo → Entregado. Solo un pendiente puede rechazarse. Un aceptado no tiene cancelación automática ni devolución de ingredientes, igual que el flujo original.

La receta se consulta al aceptar. Las cantidades deben estar en la misma unidad del insumo (no convertir kg a g manualmente dentro de una misma receta). No se puede cambiar la unidad de un insumo que ya tiene recetas.

## 5. Qué mostrar al profesor: MVC de Laravel

| Elemento | Ubicación | Responsabilidad |
|---|---|---|
| Rutas | `routes/web.php` | URL, método HTTP, controlador y middleware |
| Controladores | `app/Http/Controllers` | Validar peticiones y devolver vistas/respuestas |
| Modelos Eloquent | `app/Models` | Tablas, claves primarias y relaciones |
| Vistas Blade | `resources/views` | Presentación con layout compartido, formularios y CSRF |
| Middleware | `app/Http/Middleware/VerificarRol.php` | Acceso por rol y cuenta activa |
| Servicio de negocio | `app/Services/PedidoService.php` | Transacciones y descuento de inventario |
| Migraciones | `database/migrations` | Crear y revertir esquema de base de datos |
| Seeders | `database/seeders` | Datos opcionales de demostración |
| Comandos Artisan | `routes/console.php`, `app/Console/Commands` | Administrador, contraseña e importación |
| Recursos públicos | `public/assets` | Fotografías, CSS y JavaScript originales |
| Configuración | `.env`, `config` | Conexión y ajustes del entorno |
| Pruebas | `tests/Feature/PasteleriaTest.php` | Flujos HTTP, permisos y reglas de negocio |

Se mantienen nombres de tablas y columnas para facilitar la importación. Eloquent configura explícitamente esas claves; no requiere renombrar todas las columnas a inglés. Las tablas originales no tenían `created_at` y `updated_at`, por lo que los modelos desactivan esos timestamps automáticos.

## 6. Respaldos y recuperación

El panel de administrador exporta un archivo `.rock` cifrado con `APP_KEY`. Incluye las siete tablas del negocio. Restaurarlo requiere contraseña actual y confirmación, sustituye los datos en una transacción y cierra la sesión actual. Hazlo sin otros usuarios conectados. Conserva la misma `APP_KEY`; sin ella no puedes descifrar esos respaldos.

Las fotos y `.env` se respaldan por separado: guarda `storage/app/public`, `public/uploads`, tus imágenes personalizadas y `.env`. La pantalla ya no ejecuta SQL arbitrario subido desde el navegador. Los SQL antiguos deben restaurarse con HeidiSQL/phpMyAdmin en una base separada y luego importarse por el comando anterior. El historial de restauraciones JSON del programa antiguo no se migra.

La recuperación automática por correo no estaba configurada en el original y sigue sin estarlo; utiliza `rock:password`. El administrador también puede asignar una contraseña temporal desde la edición de una cuenta.

## 7. Verificación

```bat
php artisan test
php artisan route:list
php artisan view:cache
```

Las pruebas crean una base SQLite en memoria, sin tocar tu MySQL. Comprueban renderizado, registro, autenticación, roles, privacidad de pedidos, carga de imagen, recetas, inventario, transiciones, doble aceptación, reversión por stock insuficiente, caducidad y respaldo/restauración. Consulta `VERIFICACION.md` para el resultado obtenido en esta entrega. La concurrencia real de MySQL debe comprobarse en tu servidor; SQLite no reproduce sus bloqueos de filas.

## 8. Errores frecuentes

- `vendor/autoload.php` no existe: ejecuta `composer install` en la raíz.
- “No application encryption key”: ejecuta `php artisan key:generate` solo en una instalación nueva.
- `could not find driver`: habilita PDO MySQL (o PDO SQLite para pruebas) en el PHP que usa la terminal.
- “Unknown database”: crea la base indicada en `.env` y verifica usuario, contraseña y puerto.
- “Table ... doesn't exist”: ejecuta `php artisan migrate` sobre la base nueva.
- Foto subida no visible: ejecuta `php artisan storage:link`; comprueba `APP_URL`. En Windows usa la terminal con los permisos necesarios para crear enlaces simbólicos.
- Error 419: recarga la página para renovar el token de sesión; no uses pestañas de otra instalación.
- Cambiaste `.env`: ejecuta `php artisan optimize:clear`.
- No sobrescribas el proyecto PHP original: esta entrega se ejecuta desde otra carpeta.

## Referencias oficiales

- https://laravel.com/docs/12.x/installation
- https://laravel.com/docs/12.x/routing
- https://laravel.com/docs/12.x/eloquent
- https://laravel.com/docs/12.x/blade
- https://laravel.com/docs/12.x/migrations
