# Documentación del proyecto: Blog_Cms

Última actualización: 28/11/2025

## Resumen

Este proyecto es un CMS de blog ligero en PHP (sin framework) que implementa funciones comunes: registro/autenticación de usuarios, creación/edición/publicación de posts, comentarios, likes, marcadores, seguidores, notificaciones y un panel de administración para moderación y configuración.

La documentación a continuación describe la instalación, configuración, estructura del proyecto, rutas, controladores, modelos, vistas y tareas comunes.

## Requisitos

- PHP 7.4 o superior
- Extensiones PHP: PDO, pdo_mysql, mbstring, fileinfo, json
- Servidor web (Apache/Nginx) o servidor embebido de PHP para desarrollo
- MySQL o MariaDB

## Instalación (desarrollo)

1. Clona el repositorio:

   git clone <repositorio> && cd Blog_Cms

2. Asegúrate de tener PHP y las extensiones instaladas.

3. Configura la base de datos:

   - Edita `config/database.php` con los datos de tu servidor (host, dbname, username, password).

4. Crea la base de datos en MySQL:

   CREATE DATABASE blog_cms CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

   (Si no tienes un script de migraciones, puedes crear las tablas manualmente; ver sección "Esquema de ejemplo".)

5. Configura la aplicación:

   - Revisa `config/app.php` y ajusta `APP_URL`, `APP_ENV`, `UPLOAD_PATH`, `MAX_FILE_SIZE` y `date_default_timezone_set` si es necesario.

6. Asegura que la carpeta de subidas exista y tenga permisos de escritura:

   - `public/uploads/posts/` debe ser escribible por el servidor web.

7. Inicia el servidor de desarrollo (opcional):

   php -S localhost:8000 -t public

8. Abre `http://localhost:8000` en tu navegador.

## Estructura del proyecto

- `app/Controllers/` - Controladores MVC que manejan lógica de petición/respuesta.
- `app/Models/` - Modelos y acceso a datos (uso de PDO en `Database.php`).
- `app/Helpers/` - Utilidades (Cookie, FileUploader, Session, Validator).
- `app/Middleware/` - Middlewares (`AuthMiddleware`, `AdminMiddleware`, `GuestMiddleware`).
- `config/` - Configuraciones de la app y base de datos.
- `public/` - Punto de entrada (`index.php`), assets y uploads.
- `routes/` - Definición simple de rutas (`routes/web.php`).
- `views/` - Plantillas PHP para la salida HTML.

## Archivo de configuración principal

- `config/app.php` contiene constantes de la aplicación:
  - `APP_NAME`, `APP_URL`, `APP_ENV` (development/production)
  - Manejo de `error_reporting` según entorno
  - `UPLOAD_PATH` y `MAX_FILE_SIZE` para subir imágenes

- `config/database.php` devuelve un arreglo con los parámetros de conexión para PDO.

## Rutas (resumen)

Las rutas se definen en `routes/web.php` usando una clase `Router` simple. Se soportan métodos `GET` y `POST` y middleware opcional por ruta.

Rutas públicas relevantes:

- `/` - Página principal (HomeController@index)
- `/login`, `/register` - Autenticación (AuthController)
- `/blog/{slug}` - Mostrar post (PostController@show)
- `/category/{slug}` - Posts por categoría (CategoryController@show)
- `/tag/{slug}` - Posts por etiqueta (TagController@show)
- `/search` - Búsqueda (SearchController@index)

Rutas protegidas (requieren autenticación):

- `/post/create`, `/post/edit/{id}`, `/post/delete/{id}` - Gestión de posts (PostController)
- `/comment/{postId}` - Crear comentario (CommentController)
- `/like/{postId}` - Like/Unlike (LikeController)
- `/bookmark/{postId}`, `/bookmarks` - Marcadores (BookmarkController)
- `/profile/*` - Perfil y edición (ProfileController)

Rutas de administración (requieren `AdminMiddleware`):

- `/admin` y `/admin/*` - Panel de administración (AdminController) para gestionar usuarios, posts, comentarios, reportes, categorías y configuraciones.

## Controladores (lista y propósito)

- `HomeController` — Vista principal, listado de posts.
- `AuthController` — Login, register, logout.
- `PostController` — Crear, editar, mostrar, eliminar posts.
- `CategoryController` — Mostrar posts por categoría.
- `TagController` — Mostrar posts por etiqueta.
- `SearchController` — Buscar posts.
- `CommentController` — Añadir / eliminar comentarios.
- `LikeController` — Toggle like en posts.
- `BookmarkController` — Toggle bookmark y listado.
- `ProfileController` — Mostrar/editar perfil de usuario.
- `FollowerController` — Seguir / dejar de seguir usuarios y listar seguidores.
- `NotificationController` — Listar y marcar notificaciones como leídas.
- `ReportController` — Enviar reportes sobre contenido.
- `AdminController` — Funciones administrativas para gestionar la aplicación.

## Modelos (lista)

- `User`, `Post`, `Comment`, `Category`, `Tag`, `Like`, `Bookmark`, `Follower`, `Notification`, `Report`, `Setting`, `ActivityLog`, `Admin`.

Los modelos usan `app/Models/Database.php` para la conexión PDO; revisa ese archivo para ver la implementación de la conexión y consultas.

## Vistas

Las vistas están en `views/` organizadas por secciones (`auth`, `posts`, `admin`, `layouts`, etc.). Las plantillas son PHP puro y se incluyen desde los controladores.

## Middlewares

- `AuthMiddleware` — Verifica sesión/usuario autenticado.
- `GuestMiddleware` — Redirige a usuarios autenticados fuera de páginas de login/register.
- `AdminMiddleware` — Comprueba rol de administrador para acceder al panel.

## Subida de archivos

- Ruta de subida definida en `config/app.php` (`UPLOAD_PATH`).
- Tamaño máximo configurado en `MAX_FILE_SIZE` (5MB por defecto).
- `app/Helpers/FileUploader.php` gestiona la lógica de validación y almacenamiento.

## Ejecución local

1. Asegúrate de que `public/index.php` sea el entrypoint del servidor.
2. Desde la carpeta raíz del proyecto, ejecuta:

   php -S localhost:8000 -t public

3. Visita `http://localhost:8000`.

## Esquema  (SQL)

```sql
CREATE DATABASE IF NOT EXISTS blog_cms CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE blog_cms;

-- Tabla de usuarios con roles
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    avatar VARCHAR(255) DEFAULT NULL,
    bio TEXT DEFAULT NULL,
    role ENUM('user', 'moderator', 'admin') DEFAULT 'user',
    status ENUM('active', 'suspended', 'banned') DEFAULT 'active',
    email_verified TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL DEFAULT NULL,
    INDEX idx_email (email),
    INDEX idx_role (role),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de posts con estado
CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    slug VARCHAR(250) NOT NULL UNIQUE,
    content TEXT NOT NULL,
    excerpt TEXT,
    image VARCHAR(255) DEFAULT NULL,
    status ENUM('draft', 'published', 'archived') DEFAULT 'draft',
    featured TINYINT(1) DEFAULT 0,
    views INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    published_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_slug (slug),
    INDEX idx_user_id (user_id),
    INDEX idx_status (status),
    INDEX idx_featured (featured),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de comentarios con moderación
CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'approved',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_post_id (post_id),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de likes
CREATE TABLE likes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    user_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_like (post_id, user_id),
    INDEX idx_post_id (post_id),
    INDEX idx_user_id (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de categorías
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    slug VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    icon VARCHAR(50) DEFAULT NULL,
    color VARCHAR(7) DEFAULT '#6366f1',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla intermedia posts-categorías
CREATE TABLE post_categories (
    post_id INT NOT NULL,
    category_id INT NOT NULL,
    PRIMARY KEY (post_id, category_id),
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de seguidores
CREATE TABLE followers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    follower_id INT NOT NULL,
    following_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (follower_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (following_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_follow (follower_id, following_id),
    INDEX idx_follower (follower_id),
    INDEX idx_following (following_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de marcadores
CREATE TABLE bookmarks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    post_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    UNIQUE KEY unique_bookmark (user_id, post_id),
    INDEX idx_user_id (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de notificaciones
CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    type ENUM('comment', 'like', 'follow', 'mention', 'admin') NOT NULL,
    content TEXT NOT NULL,
    link VARCHAR(255),
    is_read TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_is_read (is_read),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de reportes
CREATE TABLE reports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reporter_id INT NOT NULL,
    reported_type ENUM('post', 'comment', 'user') NOT NULL,
    reported_id INT NOT NULL,
    reason TEXT NOT NULL,
    status ENUM('pending', 'reviewing', 'resolved', 'dismissed') DEFAULT 'pending',
    admin_notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    resolved_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (reporter_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_status (status),
    INDEX idx_reported_type (reported_type),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de logs de actividad
CREATE TABLE activity_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    action VARCHAR(100) NOT NULL,
    description TEXT,
    ip_address VARCHAR(45),
    user_agent VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_user_id (user_id),
    INDEX idx_action (action),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de configuración del sitio
CREATE TABLE site_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT,
    setting_type ENUM('text', 'number', 'boolean', 'json') DEFAULT 'text',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de tags
CREATE TABLE tags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    slug VARCHAR(50) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla intermedia posts-tags
CREATE TABLE post_tags (
    post_id INT NOT NULL,
    tag_id INT NOT NULL,
    PRIMARY KEY (post_id, tag_id),
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar categorías por defecto
INSERT INTO categories (name, slug, description, icon, color) VALUES
('Tecnología', 'tecnologia', 'Artículos sobre tecnología y programación', '💻', '#6366f1'),
('Diseño', 'diseno', 'Diseño web, UI/UX y creatividad', '🎨', '#8b5cf6'),
('Tutorial', 'tutorial', 'Guías y tutoriales paso a paso', '📚', '#10b981'),
('Noticias', 'noticias', 'Últimas noticias y actualidad', '📰', '#f59e0b'),
('Personal', 'personal', 'Reflexiones y experiencias personales', '✍️', '#ec4899'),
('Negocios', 'negocios', 'Emprendimiento y estrategia de negocios', '💼', '#06b6d4'),
('Salud', 'salud', 'Bienestar y vida saludable', '🏃', '#14b8a6'),
('Viajes', 'viajes', 'Aventuras y destinos increíbles', '✈️', '#f43f5e');

-- Insertar configuraciones por defecto
INSERT INTO site_settings (setting_key, setting_value, setting_type) VALUES
('site_name', 'Mi Blog CMS', 'text'),
('site_description', 'Un blog profesional con PHP', 'text'),
('posts_per_page', '12', 'number'),
('comments_enabled', '1', 'boolean'),
('registration_enabled', '1', 'boolean'),
('maintenance_mode', '0', 'boolean'),
('allow_comments_guests', '0', 'boolean'),
('moderate_comments', '0', 'boolean');




-- Aqui manualmente tienes que cambiar el rol de una cuenta o mediante comandos a un usuario admin
-- UPDATE users 
-- SET role = 'admin', status = 'active' 
-- WHERE email = 'usuario@gmail.com';




-- Fin del archivo de esquema

```

## Buenas prácticas y seguridad

- Mantén `APP_ENV` en `production` en servidores en vivo para evitar mostrar errores.
- Usa contraseñas seguras (password_hash/password_verify) para almacenar contraseñas.
- Valida y escapa contenido mostrado en vistas para prevenir XSS.
- Protege la carpeta `uploads` y valida tipos MIME y extensiones.
- Usa consultas preparadas (PDO) — la configuración de `config/database.php` ya habilita `ERRMODE_EXCEPTION` y desactiva emulación de prepares.

## Troubleshooting (problemas comunes)

- Error de conexión a BD: revisa `config/database.php` y que el servidor MySQL esté corriendo.
- Permisos en `public/uploads/posts/`: asegúrate de que el servidor web pueda escribir ahí.
- Rutas 404: el enrutador hace match por orden; coloca rutas específicas antes de rutas parametrizadas.

## Contribuciones

- Sigue el estilo actual de código: PHP procedural/OO ligero, controladores en `app/Controllers` y vistas en `views/`.
- Abre pull requests con descripciones claras y cambios pequeños por PR.

## Próximos pasos recomendados

- Añadir migraciones o una herramienta de migración (Phinx, Laravel migrations, etc.).
- Implementar pruebas automatizadas (PHPUnit) para controladores y modelos.
- Añadir un archivo `.env` y cargar variables de entorno (por ejemplo, con `vlucas/phpdotenv`).

---

Si quieres que genere también:

- Un archivo de migraciones SQL completo acorde al modelo existente.
- Un `README.md` más breve en la raíz que enlace a esta documentación.
- Guías de despliegue para Apache y Nginx.

Dime cuál de estas tareas quieres que avance y lo hago.

## Migraciones / Esquema SQL

He añadido tu archivo de migración SQL en `database/schema.sql`. Puedes importarlo directamente en MySQL o usarlo como referencia para crear migraciones.

Importar desde la línea de comandos:

```sql
mysql -u tu_usuario -p < database/schema.sql
```

Nota: revisa `config/database.php` para asegurarte de que `dbname` coincide con el nombre usado en la migración (`blog_cms`) o ajusta el archivo antes de importarlo.

## Documentación extendida

He añadido documentación extendida separada para que sea más fácil navegar y mantener:

- `docs/INTRODUCTION.md` — Introducción y alcance del proyecto.
- `docs/USER_GUIDE.md` — Guía paso a paso para usuarios y administradores.
- `docs/API.md` — Listado de endpoints/ rutas, parámetros y ejemplos.
- `docs/TECHNICAL.md` — Detalles técnicos, despliegue y recomendaciones.
- `docs/CODE_COMMENTS.md` — Guía y ejemplos para comentarios en el código.
- `docs/diagrams/system.puml` — Diagrama de flujo y componentes.

## Diagramas de Clases (Arquitectura)

Se proporcionan dos diagramas de clases PlantUML que muestran la evolución de la arquitectura:

### Diagrama Inicial (Estado Actual)
- **Archivo:** `docs/diagrams/class_diagram_initial.puml`
- **Descripción:** Arquitectura actual con Controllers → Models
- **Componentes:** 8 controladores, 8 modelos, 3 middlewares, 4 helpers
- **Enfoque:** Claridad y simplicidad

### Diagrama Final (Arquitectura Mejorada)
- **Archivo:** `docs/diagrams/class_diagram_final.puml`
- **Descripción:** Arquitectura propuesta con patrón Repository, Services e inyección de dependencias
- **Componentes:** Controllers → Services → Repositories → Models
- **Mejoras:** Testabilidad, bajo acoplamiento, patrón Repository, inyección de dependencias
- **Patrones:** MVC, Repository, Service Layer, Dependency Injection, Factory

### Comparación y Análisis
- **Archivo:** `docs/CLASS_DIAGRAM_COMPARISON.md`
- **Contenido:** Análisis detallado de cambios, mejoras propuestas, patrones de diseño aplicados
- **Secciones:** Fortalezas/debilidades, beneficios, guía de migración, referencias

Estos diagramas están pensados para:
1. Entender la arquitectura actual
2. Visualizar posibles mejoras
3. Planificar refactorización
4. Implementar patrones de diseño profesionales

Abre cualquiera de esos archivos para ver la documentación específica o pídeme que genere diagramas PNG/SVG desde el PlantUML.
