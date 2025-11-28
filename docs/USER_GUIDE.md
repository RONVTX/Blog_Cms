# Guía de usuario

Esta guía explica las acciones más comunes para usuarios finales y administradores.

1) Registro y autenticación

- Ir a `/register` para crear una cuenta. Completa `username`, `email` y `password`.
- Si `registration_enabled` está desactivado en `site_settings`, el registro puede estar bloqueado.
- Ir a `/login` para iniciar sesión. Después del login, serás redirigido a la página principal o a tu perfil.

2) Perfil de usuario

- Acceder a `/profile/{username}` para ver un perfil público.
- Editar tu perfil en `/profile/edit` (requiere autenticación): cambiar avatar, bio y datos personales.

3) Crear, editar y publicar posts

- Crear: visita `/post/create` (requiere autenticación). Rellena título, contenido, categoría/etiquetas y sube imagen opcional.
- Guardar: puedes guardar como `draft` o publicar (status `published`).
- Editar: visita `/post/edit/{id}` y actualiza el contenido.
- Borrar: enviar `POST` a `/post/delete/{id}` desde la interfaz de post o panel.

4) Interacción con posts

- Comentar: en la vista de un post, usar el formulario para enviar un comentario (requiere autenticación si está configurado).
- Like: el botón de like envía `POST` a `/like/{postId}` para alternar estado.
- Bookmark: usar `/bookmark/{postId}` para guardar posts y verlos en `/bookmarks`.

5) Seguir usuarios

- En el perfil de un usuario, usa el botón de seguir que realiza `POST` a `/follow/{userId}`.

6) Notificaciones

- Visita `/notifications` para ver eventos (comentarios en tus posts, likes, seguimientos).
- Marcar como leídas: `POST` a `/notifications/{id}/read` o `POST` a `/notifications/read-all`.

7) Panel de administración (roles)

- Accede a `/admin` si tu cuenta tiene rol `admin`.
- En el panel puedes gestionar usuarios (`/admin/users`), posts (`/admin/posts`), comentarios, reportes y configuraciones (`/admin/settings`).

8) Preferencias de cookies

- La política de cookies está en `/cookies`. Puedes actualizar preferencias con `POST` a la misma ruta.

9) Búsqueda y navegación

- Buscar posts por palabra clave en `/search`.
- Navegar por categoría `/category/{slug}` o por etiqueta `/tag/{slug}`.

Consejos rápidos

- Si no ves imágenes, revisa permisos en `public/uploads/posts/`.
- Si no puedes registrar usuarios: comprueba `site_settings` para `registration_enabled`.
