# Comentarios de código y guía para mantener claridad en la base

Este documento recomienda comentarios y explica puntos clave en la base de código. Puedes aplicar estos comentarios directamente en los archivos PHP para ayudar a nuevos colaboradores.

1) `routes/web.php` — Enrutador

- Añadir un comentario explicando el orden de evaluación de rutas y la razón de definir rutas específicas antes de rutas parametrizadas.

2) `app/Controllers/*` — Controladores

- Añadir encabezados en cada controlador que indiquen su responsabilidad y los métodos públicos esperados.

3) `app/Models/Database.php` — Conexión PDO

- Documentar cómo se obtiene la configuración y cómo se reutiliza la instancia PDO.

4) `app/Helpers/FileUploader.php`

- Documentar validaciones de tipo MIME y tamaño máximo (referenciar `MAX_FILE_SIZE`).

Ejemplo de comentario para `routes/web.php` (aplicar en la parte superior del archivo):

```php
/*
 * Enrutador simple: mapea URI a controladores. Las rutas se prueban en el
 * orden de definición; por eso rutas específicas (p. ej. /profile/edit)
 * deben definirse antes de rutas parametrizadas como /profile/{username}.
 */
```

Ejemplo para `app/Models/Database.php`:

```php
// Devuelve una instancia de PDO reutilizable para la aplicación.
// Configuración tomada de `config/database.php`.
```

Si quieres, puedo aplicar automáticamente estos comentarios en los archivos clave del repositorio. ¿Deseas que los añada ahora? (sí/no)
