# Documentación de la API / Endpoints

Este proyecto usa enrutamiento basado en `routes/web.php`. A continuación se listan las rutas públicas y protegidas con su método, controlador y parámetros.

Formato: `MÉTODO | RUTA | CONTROLADOR@MÉTODO | MIDDLEWARE | PARÁMETROS` 

Rutas públicas:
- GET | `/` | HomeController@index | - | -
- GET | `/login` | AuthController@showLogin | GuestMiddleware | -
- POST | `/login` | AuthController@login | GuestMiddleware | `email`, `password`
- GET | `/register` | AuthController@showRegister | GuestMiddleware | -
- POST | `/register` | AuthController@register | GuestMiddleware | `username`, `email`, `password`
- GET | `/blog/{slug}` | PostController@show | - | `slug`
- GET | `/category/{slug}` | CategoryController@show | - | `slug`
- GET | `/tag/{slug}` | TagController@show | - | `slug`
- GET | `/search` | SearchController@index | - | `q` (query)

Rutas protegidas (AuthMiddleware):
- GET | `/logout` | AuthController@logout | AuthMiddleware | -
- GET | `/post/create` | PostController@create | AuthMiddleware | -
- POST | `/post/create` | PostController@store | AuthMiddleware | `title`, `content`, `categories`, `tags`, `image`
- GET | `/post/edit/{id}` | PostController@edit | AuthMiddleware | `id`
- POST | `/post/edit/{id}` | PostController@update | AuthMiddleware | `id` + campos a actualizar
- POST | `/post/delete/{id}` | PostController@delete | AuthMiddleware | `id`
- POST | `/comment/{postId}` | CommentController@store | AuthMiddleware | `postId`, `content`
- POST | `/like/{postId}` | LikeController@toggle | AuthMiddleware | `postId`
- POST | `/bookmark/{postId}` | BookmarkController@toggle | AuthMiddleware | `postId`
- GET | `/bookmarks` | BookmarkController@index | AuthMiddleware | -
- GET | `/profile/edit` | ProfileController@edit | AuthMiddleware | -
- POST | `/profile/update` | ProfileController@update | AuthMiddleware | campos de perfil
- POST | `/follow/{userId}` | FollowerController@toggle | AuthMiddleware | `userId`

Rutas de notificaciones (AuthMiddleware):
- GET | `/notifications` | NotificationController@index | AuthMiddleware | -
- POST | `/notifications/{id}/read` | NotificationController@markAsRead | AuthMiddleware | `id`
- POST | `/notifications/read-all` | NotificationController@markAllAsRead | AuthMiddleware | -
- GET | `/notifications/unread-count` | NotificationController@getUnreadCount | AuthMiddleware | -

Panel de administración (AdminMiddleware):
- GET | `/admin` | AdminController@dashboard | AdminMiddleware | -
- GET | `/admin/users` | AdminController@users | AdminMiddleware | -
- POST | `/admin/users/role` | AdminController@updateUserRole | AdminMiddleware | `user_id`, `role`
- POST | `/admin/users/status` | AdminController@updateUserStatus | AdminMiddleware | `user_id`, `status`
- POST | `/admin/users/delete` | AdminController@deleteUser | AdminMiddleware | `user_id`

Notas y ejemplos de uso

- Muchas de las rutas están pensadas para formularios HTML (respuesta HTML). Para llamadas programáticas (AJAX), usar `fetch` o `curl` enviando las mismas claves de formulario.

Ejemplo con `curl` (login):

```bash
curl -X POST -d "email=usuario%40ejemplo.com&password=secreto" http://localhost:8000/login
```

Ejemplo con `fetch` (like toggle):

```js
fetch('/like/123', { method: 'POST', credentials: 'include' }).then(r => r.text()).then(console.log);
```

Formatos de respuesta

- Respuestas por defecto son HTML (renderizado desde `views/`). Algunas rutas (p. ej. contadores) pueden devolver fragmentos HTML o números simples; revisa implementación específica del controlador.

Seguridad

- Todas las rutas protegidas requieren sesión de usuario.
- El panel admin requiere validación de rol (`AdminMiddleware`).
