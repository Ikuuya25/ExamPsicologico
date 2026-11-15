# ExamPsicologico

Plataforma web para aplicar **exámenes psicológicos basados en puntuación**.
Su objetivo es **facilitar el trabajo de los psicólogos**; **no diagnostica**. Los resultados son un apoyo y deben ser interpretados por un profesional.

---

##  Qué problema resuelve

Aplicar, calificar y dar seguimiento a pruebas psicológicas en papel o de forma manual toma tiempo y es propenso a errores. Este proyecto permite al psicólogo:

- Asignar exámenes a sus pacientes desde un solo lugar.
- Obtener la puntuación de forma automática.
- Llevar el control de qué exámenes están pendientes, activos o finalizados.

El sistema solo calcula puntuaciones. La interpretación y cualquier diagnóstico quedan siempre a cargo del profesional.

##  Tecnologías utilizadas

- **PHP**: lógica del servidor y manejo de vistas.
- **MySQL / MariaDB**: almacenamiento de usuarios, exámenes, preguntas y resultados.
- **HTML5 y CSS3** (styles.css): interfaz de usuario.
- **Apache** (XAMPP / WAMP / LAMP): servidor local de desarrollo.
- **Visual Studio Code**: entorno de desarrollo.
- **Git y GitHub**: control de versiones.

##  Principales funciones

- **Registro e inicio de sesión** de usuarios.
- **Panel del psicólogo**.
- **Gestión de usuarios**.
- **Búsqueda de pacientes**.
- **Creación de exámenes**.
- **Asignación de exámenes**.
- **Aplicación del examen**.
- **Cambio de estado y reactivación** de exámenes.
- **Calificación automática por puntuación.**


##  Cómo ejecutarlo

### Requisitos
- PHP 7.4 o superior <!-- VERIFICAR -->
- MySQL o MariaDB
- Apache (por ejemplo, con [XAMPP](https://www.apachefriends.org/))

### Pasos

1. **Clona el repositorio** dentro de la carpeta pública de tu servidor (`htdocs` en XAMPP):
   ```bash
   git clone https://github.com/Ikuuya25/ExamPsicologico.git
   ```
2. **Crea la base de datos** en MySQL (por ejemplo, con phpMyAdmin) e importa el script SQL.
3. **Configura la conexión** editando el archivo dentro de `config/` con tus datos:
   ```php
   $host = "localhost";
   $user = "root";
   $pass = "";
   $db   = "nombre_de_tu_base_de_datos";
   ```
4. **Inicia Apache y MySQL** desde el panel de XAMPP.
5. **Abre el proyecto** en el navegador:
   ```
   http://localhost/ExamPsicologico/
   ```

##  Qué aprendí

- A estructurar una aplicación web en PHP con distintos roles (administrador, psicólogo, paciente).
- A diseñar una base de datos relacional para usuarios, exámenes, preguntas y asignaciones.
- A implementar un sistema de puntuación y a manejar estados de un examen (activo, finalizado, reactivado).
- A tomar en cuenta la responsabilidad ética de una herramienta de salud mental: asistir al profesional sin sustituir su criterio.
- A usar Git y GitHub para versionar y documentar un proyecto.

##  Aviso

Esta herramienta es solo un apoyo para profesionales de la psicología. **No sustituye una evaluación clínica ni emite diagnósticos.**

##  Autor

**Ikuuya25**: [github.com/Ikuuya25](https://github.com/Ikuuya25)
