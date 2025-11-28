# Introducción

Visión general

Blog_Cms es un sistema de gestión de contenidos (CMS) para blogs implementado en PHP sin depender de un framework. Su objetivo es proporcionar una base ligera, extensible y fácil de entender para proyectos personales o prototipos profesionales.

Propósito

- Permitir a usuarios registrados crear, editar, publicar y gestionar artículos.
- Facilitar la interacción social: comentarios, likes, marcadores y seguidores.
- Proveer un panel administrativo para moderación, gestión de usuarios, posts y configuración del sitio.

Alcance

Este software cubre desde la gestión básica de contenido hasta funcionalidades sociales y administrativas. No incluye integraciones externas (APIs de terceros) por defecto, pero su arquitectura facilita añadirlas.

Principios de diseño

- Simplicidad: código claro y estructura sin dependencias pesadas.
- Seguridad básica: uso de PDO con consultas preparadas y validación de entradas.
- Extensibilidad: controladores y modelos organizados para añadir nuevas funcionalidades.
