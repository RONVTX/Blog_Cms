# 🚀 Blog_Cms — CMS de Blog Profesional en PHP

Sistema de gestión de contenidos (CMS) para blogs desarrollado en **PHP POO**, **PDO**, **arquitectura MVC** personalizada y **panel de administración completo**, sin dependencias de frameworks pesados.

**Acceso rápido:**
- 📖 Documentación completa: [`docs/DOCUMENTATION.md`](docs/DOCUMENTATION.md)
- 👤 Guía de usuario: [`docs/USER_GUIDE.md`](docs/USER_GUIDE.md)
- 🔌 API endpoints: [`docs/API.md`](docs/API.md)
- 🛠️ Documentación técnica: [`docs/TECHNICAL.md`](docs/TECHNICAL.md)
- 📊 Diagrama de componentes: [`docs/diagrams/system.puml`](docs/diagrams/system.puml)

---

# Blog CMS - Sistema Completo con Panel de Administración

Blog personal profesional desarrollado con **PHP POO**, **PDO**, **arquitectura MVC** y **Panel Admin Completo**.

## ✨ Características Premium

### 🔐 Sistema de Autenticación Avanzado
- ✅ Registro y login con validación
- ✅ Roles: Usuario, Moderador, Admin
- ✅ Estados de cuenta: Activo, Suspendido, Baneado
- ✅ Perfiles personalizables con avatar
- ✅ Sistema de seguidores/siguiendo
- ✅ Estadísticas detalladas

### 📝 Gestión de Contenido Profesional
- ✅ CRUD completo de posts
- ✅ Estados: Borrador, Publicado, Archivado
- ✅ Posts destacados (featured)
- ✅ Categorías múltiples
- ✅ Sistema de tags
- ✅ Editor con preview de imágenes
- ✅ URLs amigables (slugs)
- ✅ Contador de vistas
- ✅ Extractos automáticos

### 💬 Interacción Social Completa
- ✅ Sistema de comentarios con moderación
- ✅ Likes en tiempo real (AJAX)
- ✅ Marcadores/Favoritos
- ✅ Sistema de seguidores
- ✅ Notificaciones en tiempo real
- ✅ Compartir publicaciones
- ✅ Sistema de reportes

### 👨‍💼 Panel de Administración Completo
- ✅ Dashboard con estadísticas en tiempo real
- ✅ Gestión de usuarios (roles y estados)
- ✅ Moderación de publicaciones
- ✅ Moderación de comentarios
- ✅ Sistema de reportes
- ✅ Gestión de categorías
- ✅ Configuración del sitio
- ✅ Registro de actividad (logs)
- ✅ Posts más populares
- ✅ Actividad reciente

### 📊 Características Avanzadas
- ✅ Sistema de notificaciones
- ✅ Búsqueda avanzada
- ✅ Filtrado por categorías y tags
- ✅ Posts trending (algoritmo inteligente)
- ✅ Perfiles públicos de usuarios
- ✅ Sistema de reportes de contenido
- ✅ Logs de actividad del sistema
- ✅ Configuración dinámica
- ✅ Estados de contenido (draft/published/archived)

### 🎨 Diseño Premium
- ✅ Diseño moderno con gradientes
- ✅ Panel admin profesional
- ✅ Sidebar sticky con widgets
- ✅ Cards con animaciones
- ✅ Totalmente responsive
- ✅ Dark mode compatible
- ✅ Iconos emoji integrados
- ✅ Loading states
- ✅ Modales y tooltips

### 🔒 Seguridad de Nivel Empresarial
- ✅ Bcrypt para passwords
- ✅ Prepared statements (PDO)
- ✅ Validación completa de datos
- ✅ Sanitización HTML
- ✅ Middlewares de autenticación
- ✅ Protección CSRF (implementable)
- ✅ Roles y permisos
- ✅ Logs de seguridad

## 📋 Requisitos del Sistema

| Requisito | Versión |
|-----------|---------|
| PHP | 7.4+ o 8.x |
| MySQL | 5.7+ o MariaDB 10.3+ |
| Servidor Web | Apache (mod_rewrite) o Nginx |
| Extensiones PHP | PDO, pdo_mysql, gd, fileinfo, mbstring |

## 🔧 Instalación Rápida

### 1. Clonar el repositorio
```bash
git clone https://github.com/RONVTX/Blog_Cms.git
cd Blog_Cms
```

### 2. Crear base de datos
```bash
mysql -u root -p < database/schema.sql
```

### 3. Configurar la conexión
Edita `config/database.php` con tus credenciales MySQL:
```php
'host' => 'localhost',
'dbname' => 'blog_cms',
'username' => 'tu_usuario',
'password' => 'tu_contraseña',
```

### 4. Crear carpetas necesarias
```bash
mkdir -p public/uploads/posts
chmod -R 755 public/uploads
```

### 5. Ejecutar servidor de desarrollo
```bash
php -S localhost:8000 -t public
```

Visita `http://localhost:8000` en tu navegador.

### 6. Acceso administrador

**Usuario por defecto:**
crea un usuario y luego haz lo siguiente
Para crear más admins, actualiza el rol en la base de datos:
```sql
UPDATE users SET role = 'admin' WHERE email = 'tu_email@ejemplo.com';
```


## 📁 Estructura del Proyecto

```
Blog_Cms/
├── app/
│   ├── Controllers/          # Controladores MVC
│   │   ├── AdminController.php
│   │   ├── PostController.php
│   │   ├── AuthController.php
│   │   ├── CommentController.php
│   │   ├── NotificationController.php
│   │   ├── FollowerController.php
│   │   └── ... (11+ controladores)
│   ├── Models/               # Modelos y acceso a datos
│   │   ├── User.php
│   │   ├── Post.php
│   │   ├── Database.php      # Conexión PDO
│   │   └── ... (13 modelos)
│   ├── Middleware/           # Control de acceso
│   │   ├── AuthMiddleware.php
│   │   ├── AdminMiddleware.php
│   │   └── GuestMiddleware.php
│   └── Helpers/              # Utilidades
│       ├── FileUploader.php
│       ├── Validator.php
│       ├── Session.php
│       └── Cookie.php
├── config/
│   ├── app.php               # Config de aplicación
│   └── database.php          # Config de BD
├── public/
│   ├── index.php             # Punto de entrada
│   ├── assets/
│   │   ├── css/              # Estilos
│   │   └── js/               # JavaScript
│   └── uploads/
├── routes/
│   └── web.php               # Definición de rutas (30+ rutas)
├── views/                    # Plantillas PHP
│   ├── layouts/              # Headers y footers
│   ├── admin/                # Vistas del panel admin
│   ├── auth/                 # Login y registro
│   ├── posts/                # Gestión de posts
│   ├── profile/              # Perfiles de usuario
│   └── ... (+ 10 secciones)
├── database/
│   └── schema.sql            # Esquema SQL (16 tablas)
├── docs/                     # Documentación
│   ├── DOCUMENTATION.md      # Documentación principal
│   ├── INTRODUCTION.md       # Introducción del proyecto
│   ├── USER_GUIDE.md         # Guía de usuario
│   ├── API.md                # Documentación de endpoints
│   ├── TECHNICAL.md          # Detalles técnicos
│   ├── CODE_COMMENTS.md      # Guía de comentarios
│   └── diagrams/
│       └── system.puml       # Diagrama de arquitectura
└── README.md                 # Este archivo
```

## 🎯 Funcionalidades Detalladas

### Panel de Administración
**Dashboard:**
- Estadísticas en tiempo real
- Gráficos de actividad
- Posts más populares
- Actividad reciente del sistema

**Gestión de Usuarios:**
- Cambiar roles (user/moderator/admin)
- Cambiar estados (active/suspended/banned)
- Ver estadísticas por usuario
- Eliminar usuarios

**Gestión de Publicaciones:**
- Cambiar estado (draft/published/archived)
- Marcar como destacado
- Filtrar por estado
- Ver estadísticas (vistas, likes, comentarios)

**Moderación de Comentarios:**
- Aprobar/rechazar comentarios
- Filtrar por estado
- Eliminar spam

**Sistema de Reportes:**
- Gestionar reportes de usuarios
- Estados: pending/reviewing/resolved/dismissed
- Notas de administrador

**Configuración:**
- Nombre y descripción del sitio
- Posts por página
- Habilitar/deshabilitar registro
- Habilitar/deshabilitar comentarios
- Modo mantenimiento
- Moderación de comentarios

### Sistema de Notificaciones
- Notificaciones de nuevos seguidores
- Notificaciones de likes
- Notificaciones de comentarios
- Notificaciones de menciones
- Notificaciones administrativas
- Contador de no leídas
- Marcar como leídas

### Sistema de Reportes
- Reportar posts
- Reportar comentarios
- Reportar usuarios
- Panel de administración de reportes

## 🛠️ Tecnologías

- **Backend**: PHP 7.4+ (POO pura)
- **Base de Datos**: MySQL con PDO
- **Frontend**: HTML5, CSS3, JavaScript Vanilla
- **Arquitectura**: MVC personalizada
- **Routing**: Router custom con parámetros
- **Autenticación**: Bcrypt + Sessions
- **AJAX**: Fetch API para interacciones

## 🎯 Funcionalidades Detalladas

### Panel de Administración
**Dashboard:**
- Estadísticas en tiempo real
- Gráficos de actividad
- Posts más populares
- Actividad reciente del sistema

**Gestión de Usuarios:**
- Cambiar roles (user/moderator/admin)
- Cambiar estados (active/suspended/banned)
- Ver estadísticas por usuario
- Eliminar usuarios

**Gestión de Publicaciones:**
- Cambiar estado (draft/published/archived)
- Marcar como destacado
- Filtrar por estado
- Ver estadísticas (vistas, likes, comentarios)

**Moderación de Comentarios:**
- Aprobar/rechazar comentarios
- Filtrar por estado
- Eliminar spam

**Sistema de Reportes:**
- Gestionar reportes de usuarios
- Estados: pending/reviewing/resolved/dismissed
- Notas de administrador

**Configuración:**
- Nombre y descripción del sitio
- Posts por página
- Habilitar/deshabilitar registro
- Habilitar/deshabilitar comentarios
- Modo mantenimiento
- Moderación de comentarios

### Sistema de Notificaciones
- Notificaciones de nuevos seguidores
- Notificaciones de likes
- Notificaciones de comentarios
- Notificaciones de menciones
- Notificaciones administrativas
- Contador de no leídas
- Marcar como leídas

### Sistema de Reportes
- Reportar posts
- Reportar comentarios
- Reportar usuarios
- Panel de administración de reportes

## 🛠️ Tecnologías

- **Backend**: PHP 7.4+ (POO pura)
- **Base de Datos**: MySQL con PDO
- **Frontend**: HTML5, CSS3, JavaScript Vanilla
- **Arquitectura**: MVC personalizada
- **Routing**: Router custom con parámetros
- **Autenticación**: Bcrypt + Sessions
- **AJAX**: Fetch API para interacciones

## 🎯 Rutas Principales

| Ruta | Método | Acceso |
|------|--------|--------|
| `/` | GET | Público |
| `/login` | GET/POST | Invitados |
| `/register` | GET/POST | Invitados |
| `/blog/{slug}` | GET | Público |
| `/post/create` | GET/POST | Autenticado |
| `/profile/{username}` | GET | Público |
| `/admin` | GET | Admin |
| `/admin/users` | GET/POST | Admin |
| `/admin/posts` | GET/POST | Admin |
| `/bookmarks` | GET | Autenticado |
| `/notifications` | GET | Autenticado |

Ver la lista completa en [`docs/API.md`](docs/API.md).

## 📖 Documentación Completa

- **[Introducción](docs/INTRODUCTION.md)** — Visión general y alcance
- **[Documentación Principal](docs/DOCUMENTATION.md)** — Guía de instalación y estructura
- **[Guía de Usuario](docs/USER_GUIDE.md)** — Instrucciones paso a paso
- **[API/Endpoints](docs/API.md)** — Listado completo de rutas y parámetros
- **[Documentación Técnica](docs/TECHNICAL.md)** — Detalles de arquitectura y seguridad
- **[Comentarios de Código](docs/CODE_COMMENTS.md)** — Recomendaciones para mantener claridad
- **[Diagrama del Sistema](docs/diagrams/system.puml)** — Arquitectura visual (PlantUML)

## 🚀 Casos de Uso

### Para Particulares
- Blog personal profesional
- Portafolio con artículos
- Diario online con privacidad

### Para Pequeños Equipos
- Blog corporativo
- Sitio de noticias
- Base de conocimiento

### Para Desarrolladores
- Proyecto educativo (aprender PHP/MVC)
- Base para plugins personalizados
- Prototipo de CMS

## 🔒 Configuración de Seguridad

### Para Producción

1. **Cambiar credenciales por defecto:**
```bash
mysql -u root -p blog_cms -e "UPDATE users SET password = PASSWORD('nueva_contraseña') WHERE email = 'admin@blog.com';"
```

2. **Configurar `config/app.php`:**
```php
define('APP_ENV', 'production');  // Ocultar errores
define('APP_URL', 'https://tu-dominio.com');
```

3. **Permisos de carpetas:**
```bash
chmod 755 public/
chmod 755 public/uploads/
chmod 755 config/
```

4. **Configurar servidor web** (Apache/Nginx) apuntando a `public/`.

## 🤝 Contribuir al Proyecto

¡Las contribuciones son bienvenidas! Sigue estos pasos:

1. Fork el repositorio
2. Crea una rama para tu feature: `git checkout -b feature/mi-feature`
3. Commit tus cambios: `git commit -m 'Agregar mi feature'`
4. Push a la rama: `git push origin feature/mi-feature`
5. Abre un Pull Request

### Líneas directrices
- Sigue el estilo PHP existente (PSR-12)
- Escribe commits claros y descriptivos
- Actualiza la documentación si necesario
- Prueba tus cambios localmente

## 🗺️ Hoja de Ruta (Roadmap)

- [ ] Sistema de mensajería privada
- [ ] Editor Markdown con preview
- [ ] Subida de múltiples imágenes
- [ ] Galería de medios
- [ ] Sistema de caché
- [ ] API REST completa (JSON)
- [ ] Autenticación por token (JWT)
- [ ] Webhooks
- [ ] Integración con redes sociales
- [ ] Estadísticas avanzadas
- [ ] Exportar/Importar contenido
- [ ] Temas personalizables
- [ ] Multi-idioma (i18n)
- [ ] PWA (Progressive Web App)

## 🐛 Reportar Problemas

Encontraste un bug? Abre un [issue](https://github.com/RONVTX/Blog_Cms/issues) con:
- Descripción del problema
- Pasos para reproducir
- PHP/MySQL/navegador usado
- Error logs si aplica

## 📞 Soporte

- 📚 Lee la documentación en [`docs/`](docs/)
- 🔍 Busca en los [issues](https://github.com/RONVTX/Blog_Cms/issues)
- 💬 Abre una [discusión](https://github.com/RONVTX/Blog_Cms/discussions)

## 📝 Licencia

Este proyecto está licenciado bajo la **Licencia MIT** — ver [`LICENSE`](LICENSE) para más detalles.

## 👨‍💻 Autor

**Ronnald Benítez** (RONVTX)

- GitHub: [@RONVTX](https://github.com/RONVTX)
- Proyecto: [Blog_Cms](https://github.com/RONVTX/Blog_Cms)

---

## ⭐️ Ayuda al Proyecto

Si te gusta Blog_Cms:
- ⭐ Dale una estrella en GitHub
- 🍴 Haz fork y contribuye
- 📢 Comparte con otros desarrolladores
- 💬 Da feedback sobre mejoras

---

**Última actualización**: 28/11/2025

> "Un buen CMS es simple, seguro y escalable." — RONVTX
 
 La base de datos esta en la carpeta de data base copia y pegalo en tu mysql