¡Claro! A continuación te proporciono un archivo `README.md` bien estructurado y detallado para tu proyecto. Este archivo describe el propósito del proyecto, las tecnologías utilizadas, las instrucciones para configurarlo y ejecutarlo, y cómo subirlo a GitHub. El formato está diseñado para que se vea profesional y sea fácil de entender.

---

# Examen de Programación - Java

![Banner del Proyecto](https://via.placeholder.com/800x200.png?text=Examen+de+Programación+-+Java)  
*Un sistema de examen en línea para evaluar habilidades de programación en Java.*

## Descripción del Proyecto

Este proyecto es un sistema de examen en línea diseñado para evaluar las habilidades de programación en Java de los estudiantes. Los usuarios deben completar un formulario con su nombre, matrícula y dos códigos en Java (uno para calcular la sucesión de Fibonacci y otro para calcular una potencia). El sistema incluye varias funcionalidades para garantizar la integridad del examen, como la detección de cambio de pestaña, la prohibición de pegar texto, y un temporizador. Los datos del formulario se envían a un servidor y se almacenan en una base de datos MySQL alojada en InfinityFree.

### Características Principales
- **Formulario de Examen**: Los estudiantes ingresan su nombre, matrícula y dos códigos en Java.
- **Editores de Código**: Incluye dos editores de texto con resaltado de sintaxis y números de línea.
- **Temporizador**: Un temporizador de 400 segundos que alerta al usuario cuando el tiempo se agota.
- **Restricciones de Integridad**:
  - Detecta cambios de pestaña, pérdida de foco (como `Alt + Tab`), o intentos de cerrar la ventana, borrando el código y mostrando una advertencia.
  - Prohíbe pegar texto en los editores y muestra una alerta si se intenta.
- **Almacenamiento de Datos**: Los datos del formulario se envían a un script PHP y se almacenan en una base de datos MySQL en InfinityFree.
- **Notificaciones**: Usa SweetAlert2 para mostrar alertas de éxito, error o advertencia.

## Tecnologías Utilizadas

- **Frontend**:
  - HTML5 y CSS3 (con Bootstrap 5 para el diseño).
  - JavaScript (para la lógica del cliente).
  - SweetAlert2 (para notificaciones emergentes).
- **Backend**:
  - PHP (para manejar la conexión a la base de datos y guardar los datos).
- **Base de Datos**:
  - MySQL con motor InnoDB (alojada en InfinityFree).
- **Hosting**:
  - InfinityFree (para alojar el frontend y el script PHP).

## Estructura del Proyecto

```
examen-programacion/
├── index.html          # Página principal del examen
├── script.js           # Lógica del frontend (JavaScript)
├── guardar_respuestas.php  # Script PHP para guardar los datos en la base de datos
└── README.md           # Documentación del proyecto
```

### Estructura de la Base de Datos
La base de datos `if0_38626442_javaexam` contiene una tabla llamada `respuestas` con la siguiente estructura:

```sql
CREATE TABLE respuestas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    matricula VARCHAR(20) NOT NULL,
    codigo1 TEXT NOT NULL,
    codigo2 TEXT NOT NULL,
    fecha_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

- `id`: Identificador único de cada registro.
- `nombre`: Nombre del estudiante.
- `matricula`: Matrícula del estudiante.
- `codigo1`: Código del primer editor (Fibonacci).
- `codigo2`: Código del segundo editor (Potencia).
- `fecha_envio`: Fecha y hora en que se envió el formulario.

## Requisitos Previos

- Una cuenta en [InfinityFree](https://www.infinityfree.com/) para alojar el proyecto.
- Acceso a phpMyAdmin en InfinityFree para gestionar la base de datos.
- Un navegador web moderno (Chrome, Firefox, Edge, etc.).
- Un cliente FTP (como FileZilla) o el administrador de archivos de InfinityFree para subir los archivos.

## Instalación y Configuración

### 1. Clonar el Repositorio
Clona este repositorio en tu máquina local:

```bash
git clone https://github.com/tu-usuario/examen-programacion.git
cd examen-programacion
```

(Sustituye `tu-usuario` por tu nombre de usuario de GitHub).

### 2. Configurar la Base de Datos
1. Inicia sesión en tu cuenta de InfinityFree.
2. Accede a phpMyAdmin desde el panel de control.
3. Selecciona la base de datos `if0_38626442_javaexam` (o créala si no existe).
4. Crea la tabla `respuestas` ejecutando el siguiente comando SQL:

   ```sql
   CREATE TABLE respuestas (
       id INT AUTO_INCREMENT PRIMARY KEY,
       nombre VARCHAR(100) NOT NULL,
       matricula VARCHAR(20) NOT NULL,
       codigo1 TEXT NOT NULL,
       codigo2 TEXT NOT NULL,
       fecha_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
   ```

### 3. Configurar el Script PHP
1. Abre el archivo `guardar_respuestas.php` y verifica que las credenciales de la base de datos sean correctas:

   ```php
   $host = 'sql311.infinityfree.com';
   $username = 'if0_38626442';
   $password = 'fg5o0v6wB5';
   $database = 'if0_38626442_javaexam';
   ```

   Estas credenciales ya están configuradas según lo que proporcionaste, pero asegúrate de que sean correctas.

2. (Opcional) Si deseas mayor seguridad, usa consultas preparadas en `guardar_respuestas.php` (como se mostró en la sección de notas del código anterior).

### 4. Configurar el Frontend
1. Abre el archivo `script.js` y actualiza la URL de la solicitud `fetch` para que apunte a tu script PHP en InfinityFree:

   ```javascript
   const response = await fetch('http://tu-dominio.infinityfreeapp.com/guardar_respuestas.php', {
   ```

   Sustituye `tu-dominio.infinityfreeapp.com` por el dominio real de tu sitio en InfinityFree (por ejemplo, `mi-examen.infinityfreeapp.com`).

### 5. Subir los Archivos a InfinityFree
1. Inicia sesión en tu cuenta de InfinityFree.
2. Ve al administrador de archivos o usa un cliente FTP (como FileZilla).
3. Sube los archivos `index.html`, `script.js`, y `guardar_respuestas.php` al directorio raíz de tu dominio (generalmente `htdocs`).

### 6. Probar el Proyecto
1. Abre tu navegador y accede a tu sitio, por ejemplo: `http://tu-dominio.infinityfreeapp.com/index.html`.
2. Completa el formulario con tu nombre, matrícula y dos códigos en Java.
3. Haz clic en "Enviar Respuestas".
4. Verifica que recibas una notificación de éxito y que los datos se hayan guardado en la base de datos (puedes verlo en phpMyAdmin).

## Uso

1. **Acceder al Examen**:
   - Abre el enlace de tu sitio en un navegador: `http://tu-dominio.infinityfreeapp.com/index.html`.
   - Verás un formulario con campos para el nombre, matrícula, y dos editores de código.

2. **Completar el Examen**:
   - Ingresa tu nombre y matrícula.
   - Selecciona el código a realizar (Fibonacci o Potencia) para ver las instrucciones.
   - Escribe tus códigos en los editores.
   - Ten en cuenta las restricciones:
     - No puedes cambiar de pestaña ni usar `Alt + Tab` (el código se borrará).
     - No puedes pegar texto en los editores.
     - Tienes 400 segundos para completar el examen.

3. **Enviar las Respuestas**:
   - Haz clic en "Enviar Respuestas".
   - Si todo está correcto, verás una notificación de éxito y los datos se guardarán en la base de datos.

4. **Verificar los Datos**:
   - Accede a phpMyAdmin en InfinityFree.
   - Consulta la tabla `respuestas` para ver las respuestas enviadas:

     ```sql
     SELECT * FROM respuestas;
     ```

## Subir el Proyecto a GitHub

### 1. Inicializar un Repositorio Git
En la carpeta de tu proyecto, ejecuta los siguientes comandos:

```bash
git init
git add .
git commit -m "Initial commit: Sistema de examen de programación en Java"
```

### 2. Crear un Repositorio en GitHub
1. Ve a [GitHub](https://github.com) e inicia sesión.
2. Haz clic en el botón "+" en la esquina superior derecha y selecciona "New repository".
3. Dale un nombre al repositorio (por ejemplo, `examen-programacion`), selecciona si será público o privado, y crea el repositorio.

### 3. Conectar tu Repositorio Local con GitHub
Sigue las instrucciones que GitHub te proporciona después de crear el repositorio. Por ejemplo:

```bash
git remote add origin https://github.com/tu-usuario/examen-programacion.git
git branch -M main
git push -u origin main
```

Sustituye `tu-usuario` por tu nombre de usuario de GitHub.

### 4. Verificar en GitHub
- Ve a tu repositorio en GitHub (`https://github.com/tu-usuario/examen-programacion`).
- Asegúrate de que todos los archivos, incluido el `README.md`, estén presentes.

## Notas y Mejoras Futuras

- **Seguridad**:
  - Usa consultas preparadas en PHP para prevenir inyecciones SQL (ya se proporcionó una versión con consultas preparadas en el código).
  - Agrega autenticación para que solo usuarios autorizados puedan enviar respuestas.
  - Configura HTTPS en InfinityFree para proteger los datos en tránsito.
- **CORS**:
  - Restringe el acceso CORS a tu dominio específico en `guardar_respuestas.php`:
    ```php
    header('Access-Control-Allow-Origin: http://tu-dominio.infinityfreeapp.com');
    ```
- **Mejoras en la Interfaz**:
  - Agrega un diseño más atractivo para los editores de código.
  - Incluye un sistema de puntuación automática para evaluar los códigos.
- **Escalabilidad**:
  - Si el proyecto crece, considera migrar a un hosting más robusto que InfinityFree, ya que tiene limitaciones en recursos y velocidad.

## Contribuciones

¡Las contribuciones son bienvenidas! Si deseas contribuir:
1. Haz un fork del repositorio.
2. Crea una nueva rama (`git checkout -b feature/nueva-funcionalidad`).
3. Realiza tus cambios y haz commit (`git commit -m "Agrega nueva funcionalidad"`).
4. Sube tus cambios (`git push origin feature/nueva-funcionalidad`).
5. Crea un Pull Request en GitHub.

## Licencia

Este proyecto está licenciado bajo la [Licencia MIT](LICENSE). Siéntete libre de usarlo y modificarlo según tus necesidades.

## Contacto

Si tienes preguntas o necesitas ayuda, puedes contactarme en:
- **Correo**: tu-correo@example.com
- **GitHub**: [tu-usuario](https://github.com/tu-usuario)

---

*Desarrollado con ❤️ por [José Eleazar Hernández Hernández].*

---

### Notas para personalizar el README
- **Banner del Proyecto**: El enlace `https://via.placeholder.com/800x200.png?text=Examen+de+Programación+-+Java` es un placeholder. Puedes crear un banner personalizado para tu proyecto (por ejemplo, usando Canva) y subirlo a GitHub o a otro servicio de alojamiento de imágenes, luego actualiza el enlace.
- **Sustituye datos personales**:
  - Cambia `tu-usuario` por tu nombre de usuario de GitHub.
  - Cambia `tu-correo@example.com` por tu correo real.
  - Cambia `tu-nombre` por tu nombre real.
