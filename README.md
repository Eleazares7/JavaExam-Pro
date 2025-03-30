Aquí tienes un `README.md` actualizado sin credenciales, con íconos de Markdown (usando emojis para mantener compatibilidad), colores simulados mediante texto destacado y un diseño más llamativo. Este archivo está pensado para atraer visualmente y ser fácil de leer en plataformas como GitHub.

---

# 🌟 Examen de Programación - Java 🌟

![Banner](https://via.placeholder.com/800x200.png?text=Examen+de+Programación+-+Java) <!-- Reemplaza con un banner real si lo tienes -->

¡Bienvenido a **Examen de Programación - Java**! 🎉 Una aplicación web vibrante y funcional para gestionar exámenes de programación en Java. Los estudiantes resuelven ejercicios en un entorno dinámico, mientras los profesores revisan y califican con estilo. 🚀

**🔗 URL del Proyecto**: [http://javaexam.infinityfreeapp.com](http://javaexam.infinityfreeapp.com)

---

## ✨ Características

### 🎓 Para Estudiantes
- 🖥️ Editores de código con resaltado básico y números de línea.
- ⏳ **Temporizador flotante** de 400 segundos para mantener la emoción.
- 🚫 Restricciones anti-trampas (bloqueo de pegado, cambio de pestaña).

### 👨‍🏫 Para Profesores
- 📋 Tabla interactiva con respuestas, calificaciones y comentarios.
- 📥 Descarga de códigos en formato ZIP con un clic.
- ✅ Campos editables para calificar y dejar feedback.

### 💾 Almacenamiento
- Respuestas guardadas en **MySQL** y **Firebase Realtime Database** para máxima seguridad.

---

## 🛠️ Tecnologías

### 🌐 Frontend
- **HTML5**, **CSS3**, **JavaScript (ES6+)** 📝
- **Bootstrap 5.3.2** 🎨: `https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/`
- **Animate.css 4.1.1** 🌟: `https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/`
- **Font Awesome 6.5.1** 🖼️: `https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/`
- **Google Fonts (Poppins)** ✍️: `https://fonts.googleapis.com/css2?family=Poppins`
- **SweetAlert2 11** 🚨: `https://cdn.jsdelivr.net/npm/sweetalert2@11`
- **JSZip 3.10.1** 📦: `https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/`
- **FileSaver.js 2.0.5** 💾: `https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/`

### ⚙️ Backend
- **PHP 8.x** 🐘: Con extensiones `mysqli` y `PDO`.
- **MySQL** 🗄️: Base de datos relacional en InfinityFree.
- **Firebase Realtime Database 8.0.0** 🔥: `https://www.gstatic.com/firebasejs/8.0.0/`

---

## 🚀 Instalación

### 📋 Prerrequisitos
- 🌍 Navegador moderno (Chrome, Firefox, Edge).
- 🌐 Cuenta en [InfinityFree](https://infinityfree.net) para hosting.
- 🔥 Proyecto en [Firebase](https://firebase.google.com) con Realtime Database.

### 🛠️ Pasos
1. **Configurar MySQL** 🗄️
   - Crea una base de datos en InfinityFree.
   - Importa las tablas: `Usuarios`, `Alumnos`, `Profesores`, `Roles`.
   - Inserta roles iniciales:
     ```sql
     INSERT INTO Roles (ID, NombreRol) VALUES (1, 'Alumno'), (2, 'Profesor');
     ```

2. **Subir Archivos** 📤
   - Sube `index.html`, `exam.php`, `ver_respuestas.php`, `login.php`, `register.php`, `guardar_respuestas.php`, `guardar_calificacion.php`, y `script.js` al servidor.
   - Asegúrate de que las rutas a las APIs sean correctas (ej. `./login.php`).

3. **Configurar Firebase** 🔥
   - Crea un proyecto en Firebase.
   - Agrega las credenciales en `firebaseConfig` dentro de `exam.php`.

4. **Probar** ✅
   - Visita [http://javaexam.infinityfreeapp.com](http://javaexam.infinityfreeapp.com).
   - Regístrate o inicia sesión para empezar.

---

## 📖 Uso

### 🎓 Estudiantes
1. **Inicia sesión** o regístrate en `index.html`. 🔑
2. Accede a `exam.php`, elige un ejercicio (Fibonacci o Potencia). 📝
3. Escribe tu código y envíalo antes de que el temporizador se agote. ⏰

### 👨‍🏫 Profesores
1. **Inicia sesión** en `index.html` con credenciales de profesor. 🔒
2. Ve a `ver_respuestas.php`. 📋
3. Revisa, descarga códigos y califica con estilo. ⭐

---

## 📂 Estructura de Archivos
- `index.html` 🌐: Login y registro.
- `exam.php` ✍️: Examen para alumnos.
- `ver_respuestas.php` 📊: Revisión para profesores.
- `login.php` 🔑: Autenticación.
- `register.php` 📝: Registro.
- `guardar_respuestas.php` 💾: Guardado de respuestas.
- `guardar_calificacion.php` ✅: Guardado de calificaciones.
- `script.js` ⚙️: Lógica del examen.

---

## ⚠️ Notas
- **⏳ Temporizador**: Fijo en 400 segundos, ajustable en `exam.php` o `script.js`.
- **🎨 Resaltado**: Básico, sin sintaxis específica de Java (mejorable con Prism.js).
- **🔒 Seguridad**: Restricciones del lado del cliente; considera validaciones backend.

---

## 🤝 Contribuciones
¡Siéntete libre de abrir un *pull request* o reportar *issues*! Queremos hacer este proyecto aún más increíble. 🌈

---

## 📬 Contacto
¿Preguntas? ¿Sugerencias? Escribe a [tu-email@example.com](mailto:tu-email@example.com) o visita el proyecto en [http://javaexam.infinityfreeapp.com](http://javaexam.infinityfreeapp.com). 📧

---

*¡Explora, programa y diviértete con Examen de Programación - Java!* 🎉

---

### Cambios realizados:
- **Íconos**: Uso de emojis (🌟, 🚀, 🎓, etc.) para dar vida y color al texto.
- **Colores simulados**: Títulos en negritas (**) y palabras clave destacadas para simular énfasis visual.
- **Diseño atractivo**: Secciones separadas con líneas (`---`), listas con emojis y un tono amigable.
- **Sin credenciales**: Omití las credenciales de MySQL y Firebase como solicitaste.
- **Llamativo**: Añadí frases como "¡Explora, programa y diviértete!" y emojis festivos (🎉, 🌈) para captar atención.

