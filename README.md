Aquí tienes un archivo `README.md` bien estructurado para documentar tu proyecto. Incluye una descripción general, instrucciones de instalación, uso, y detalles técnicos basados en todo lo que hemos trabajado. Está escrito en Markdown, ideal para repositorios como GitHub.

---

# Examen de Programación - Java

## Descripción
Este proyecto es una aplicación web para realizar un examen de programación en Java. Los estudiantes pueden ingresar su nombre, matrícula y escribir dos códigos (Fibonacci y Potencia) en un editor con resaltado de sintaxis. Las respuestas se guardan en una base de datos MySQL y pueden visualizarse en una tabla con opción de descarga en formato `.java`. Incluye medidas de seguridad como prevención de pegado y detección de cambio de pestaña.

## Características
- **Formulario de Examen**: Captura nombre, matrícula y códigos con un temporizador de 400 segundos.
- **Editor de Código**: Resaltado de sintaxis con colores aleatorios pero consistentes por palabra/símbolo.
- **Base de Datos**: Almacena respuestas en MySQL con una tabla `respuestas`.
- **Visualización**: Tabla de respuestas con códigos resaltados y botones para descargar como `.java`.
- **Seguridad**: Bloqueo de pegado y advertencias al cambiar de pestaña o salir.
- **Tabla de Administradores**: Estructura para futuros sistemas de autenticación.

## Tecnologías
- **Frontend**: HTML, CSS (Bootstrap 5.3.2), JavaScript, SweetAlert2.
- **Backend**: PHP con MySQL (InnoDB).
- **Hosting**: InfinityFree.

## Requisitos
- Serv ENVIRONMENTidor web con soporte para PHP (InfinityFree en este caso).
- MySQL para la base de datos.
- Navegador moderno (Chrome, Firefox, etc.).

## Instalación

### 1. Configurar la Base de Datos
1. Accede a phpMyAdmin en tu servidor (InfinityFree).
2. Crea una base de datos llamada `if0_38626442_javaexam` (o usa la existente).
3. Ejecuta las siguientes sentencias SQL para crear las tablas:

   ```sql
   CREATE TABLE respuestas (
       id INT AUTO_INCREMENT PRIMARY KEY,
       nombre VARCHAR(100) NOT NULL,
       matricula VARCHAR(50) NOT NULL,
       codigo1 TEXT NOT NULL,
       codigo2 TEXT NOT NULL
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

   CREATE TABLE administradores (
       id INT AUTO_INCREMENT PRIMARY KEY,
       correo VARCHAR(100) NOT NULL UNIQUE,
       contraseña VARCHAR(255) NOT NULL
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
   ```

### 2. Subir Archivos al Servidor
1. Descarga o crea los siguientes archivos:
   - `index.html`: Formulario principal del examen.
   - `script.js`: Lógica del frontend (editor, temporizador, envío).
   - `guardar_respuestas.php`: Guarda las respuestas en la base de datos.
   - `obtener_respuestas.php`: Obtiene las respuestas para mostrarlas.
   - `ver_respuestas.html`: Muestra la tabla de respuestas.
2. Súbelos al directorio raíz de tu dominio en InfinityFree (por ejemplo, `httpdocs`).

### 3. Configurar Conexión a la Base de Datos
Edita los archivos PHP (`guardar_respuestas.php` y `obtener_respuestas.php`) con las credenciales de tu base de datos:
```php
$host = 'sql311.infinityfree.com';
$username = 'if0_38626442';
$password = 'fg5o0v6wB5';
$database = 'if0_38626442_javaexam';
```

### 4. Probar la Aplicación
1. Abre `http://javaexam.infinityfreeapp.com/index.html` en tu navegador.
2. Completa el formulario y envía respuestas de prueba.
3. Visita `http://javaexam.infinityfreeapp.com/ver_respuestas.html` para ver las respuestas.

## Uso
1. **Examen**:
   - Ingresa tu nombre y matrícula en `index.html`.
   - Selecciona un código (Fibonacci o Potencia) para ver las instrucciones.
   - Escribe tus códigos en los editores (no se permite pegar).
   - Envía las respuestas antes de que el temporizador llegue a 0.
2. **Visualización**:
   - Haz clic en "Ver Respuestas" o visita `ver_respuestas.html`.
   - Observa la tabla con nombres, matrículas y códigos resaltados.
   - Descarga los códigos como archivos `.java` con los botones correspondientes.

## Estructura de Archivos
```
├── index.html              # Formulario principal del examen
├── script.js               # Lógica del editor y envío
├── guardar_respuestas.php  # Backend para guardar respuestas
├── obtener_respuestas.php  # Backend para obtener respuestas
├── ver_respuestas.html     # Tabla de respuestas con descarga
└── README.md               # Este archivo
```

## Tablas de la Base de Datos
### `respuestas`
| Columna   | Tipo         | Descripción            |
|-----------|--------------|------------------------|
| id        | INT          | Clave primaria         |
| nombre    | VARCHAR(100) | Nombre del estudiante  |
| matricula | VARCHAR(50)  | Matrícula del estudiante |
| codigo1   | TEXT         | Primer código          |
| codigo2   | TEXT         | Segundo código         |

### `administradores`
| Columna    | Tipo         | Descripción            |
|------------|--------------|------------------------|
| id         | INT          | Clave primaria         |
| correo     | VARCHAR(100) | Correo del administrador |
| contraseña | VARCHAR(255) | Contraseña (hasheada)  |

## Notas
- **Seguridad**: Actualmente no hay autenticación para `ver_respuestas.html`. Agrega un sistema de login usando la tabla `administradores` si es necesario.
- **Limitaciones**: InfinityFree tiene restricciones (sin WebSockets, límites de CPU). Asegúrate de no excederlos.
- **Mejoras**: Considera agregar validación de código o un sistema de calificación automática.

## Contribuir
Si deseas mejorar este proyecto:
1. Haz un fork del repositorio.
2. Crea una rama con tu feature (`git checkout -b feature/nueva-funcionalidad`).
3. Commitea tus cambios (`git commit -m "Agrega nueva funcionalidad"`).
4. Sube tu rama (`git push origin feature/nueva-funcionalidad`).
5. Abre un Pull Request.

## Licencia
Este proyecto está bajo la licencia MIT (o la que prefieras). Consulta el archivo `LICENSE` para más detalles (si lo añades).

---

### Paso Final
1. Crea un archivo llamado `README.md` en tu directorio raíz.
2. Copia y pega el contenido de arriba.
3. Súbelo al servidor junto con los demás archivos o agrégalo a tu repositorio si usas control de versiones.

¡Con esto tienes un README completo y profesional para tu proyecto! Si necesitas ajustes o más secciones, avísame.