# Documentación técnica

Arquitectura general

- Enrutador simple (`routes/web.php`) que mapea URI a `Controller@method` y permite middleware por ruta.
- Controladores en `app/Controllers/` manejan validación de entrada, llamadas a modelos y renderizado de vistas.
- Modelos y acceso a datos en `app/Models/` usan `app/Models/Database.php` (PDO).

Gestión de configuración

- `config/app.php` contiene constantes globales: `APP_NAME`, `APP_URL`, `APP_ENV`, `UPLOAD_PATH`, `MAX_FILE_SIZE`.
- `config/database.php` devuelve parámetros de conexión para PDO. Para producción, recomienda usar variables de entorno con `vlucas/phpdotenv`.

Conexión a la base de datos

- `app/Models/Database.php` debe instanciar un objeto PDO usando los valores de `config/database.php`.
- Recomendación: usar un pool de conexiones o reutilizar la instancia PDO en la aplicación para reducir overhead.

Estrategia de seguridad

- Hash de contraseñas: `password_hash()` y `password_verify()`.
- Validación y escape: escapar salidas en vistas y filtrar datos recibidos.
- CSRF: la aplicación actual no incluye un sistema CSRF explícito; recomendable añadir tokens en formularios y validarlos en las rutas `POST`.

Logs y monitorización

- `activity_logs` permite registrar acciones importantes. Recomendable añadir rotación de logs y nivel de auditoría.

Despliegue

- Para producción usar Nginx o Apache configurado para apuntar `document_root` a `public/`.
- Configurar `APP_ENV` a `production` y desactivar `display_errors`.
- Asegurar que `public/uploads/` no permita ejecución de scripts (configurar `AllowOverride` o reglas `nginx` para bloquear php en esa carpeta).

Tests

- No se incluyen pruebas automáticas. Se recomienda agregar `PHPUnit` y escribir pruebas unitarias para modelos y pruebas funcionales para controladores esenciales.

Integraciones futuras

- API JSON REST: añadir rutas que respondan `application/json` y autenticación por token (JWT o personal access tokens).
- Integración con proveedores de almacenamiento (S3) para subir imágenes.
