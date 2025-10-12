# PHP Notes App (sin base de datos)

Aplicación de notas en PHP **sin dependencias** y **sin base de datos**.
Los datos se guardan en `data/notes.json`. Creada por IA.


### Contenido
- `index.php` — Vista principal y formulario para añadir notas.
- `edit.php` — Página para editar una nota.
- `actions.php` — Maneja añadir/editar/borrar/subir.
- `lib/functions.php` — Carga y guarda el fichero JSON con locking.
- `data/notes.json` — Fichero con los datos.
- `templates/*` y `assets/*` — HTML parcial y estilos.

La aplicación está diseñada para ejecutarse en el contenedor `php:8.1-apache` sin paquetes adicionales.
