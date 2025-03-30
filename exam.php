<?php
// Iniciar la sesión para acceder a los datos del usuario
session_start();

// Verificar si hay una sesión activa y si el usuario es un alumno
if (!isset($_SESSION['user']) || !isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: index.html");
    exit();
}

// Obtener el nombre del alumno desde la sesión
$nombre = isset($_SESSION['user']['nombre']) ? htmlspecialchars($_SESSION['user']['nombre']) : 'Estudiante';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Examen de Programación - Java</title>
  <!-- Bootstrap 5 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
  <!-- Animate.css para animaciones -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <!-- Font Awesome para íconos -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
      color: #fff;
      font-family: 'Poppins', sans-serif;
      min-height: 100vh;
    }
    .container {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      padding: 30px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
      margin-top: 50px;
      margin-bottom: 50px;
    }
    h1 {
      color: #2a5298;
      font-weight: 700;
      text-align: center;
      margin-bottom: 30px;
      text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
    }
    .alert-info {
      background: #e6f3ff;
      color: #2a5298;
      border: none;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
    .form-label {
      color: #2a5298;
      font-weight: 600;
    }
    .form-select, .form-control {
      border-radius: 10px;
      box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.05);
      transition: all 0.3s ease;
    }
    .form-select:focus, .form-control:focus {
      border-color: #2a5298;
      box-shadow: 0 0 10px rgba(42, 82, 152, 0.3);
    }
    .instructions-box {
      background: #f8f9fa;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      color: #333;
    }
    .editor-container {
      display: flex;
      border: none;
      border-radius: 15px;
      overflow: hidden;
      position: relative;
      height: 350px;
      background: #1e1e1e;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
      transition: all 0.3s ease;
    }
    .editor-container:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    }
    .line-numbers {
      background: #252526;
      color: #858585;
      padding: 15px 10px;
      font-family: 'Consolas', monospace;
      text-align: right;
      user-select: none;
      overflow-y: auto;
      height: 100%;
      width: 50px;
      white-space: pre-wrap;
      scrollbar-width: thin;
      scrollbar-color: #858585 #252526;
    }
    .editor {
      background: transparent;
      color: transparent;
      font-family: 'Consolas', monospace;
      height: 100%;
      overflow-y: auto;
      padding: 15px;
      border: none;
      flex: 1;
      outline: none;
      white-space: pre-wrap;
      overflow-wrap: break-word;
      position: relative;
      z-index: 2;
      caret-color: #ffffff;
      resize: none;
      font-size: 14px;
    }
    .highlight {
      position: absolute;
      top: 0;
      left: 50px;
      padding: 15px;
      width: calc(100% - 50px);
      height: 100%;
      background: #1e1e1e;
      color: #d4d4d4;
      pointer-events: none;
      white-space: pre-wrap;
      overflow-wrap: break-word;
      overflow-y: auto;
      z-index: 1;
      font-family: 'Consolas', monospace;
      font-size: 14px;
      scrollbar-width: thin;
      scrollbar-color: #d4d4d4 #1e1e1e;
    }
    .btn-primary {
      background: #2a5298;
      border: none;
      border-radius: 25px;
      padding: 12px 25px;
      font-weight: 600;
      transition: all 0.3s ease;
    }
    .btn-primary:hover {
      background: #1e3c72;
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(30, 60, 114, 0.4);
    }
    .timer {
      color: #2a5298;
      font-weight: 600;
      background: #e6f3ff;
      padding: 10px 20px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
    h5 {
      color: #2a5298;
      font-weight: 600;
      margin-bottom: 15px;
    }
  </style>
</head>
<body>
  <div class="container animate__animated animate__fadeIn">
    <h1 class="animate__animated animate__bounceInDown"><i class="fas fa-laptop-code"></i> Examen de Programación</h1>
    
    <!-- Mensaje de bienvenida -->
    <div class="alert alert-info animate__animated animate__fadeInUp" role="alert">
      <i class="fas fa-user-graduate"></i> Bienvenido alumno <?php echo $nombre; ?>. Por favor, realiza los exámenes conforme a las instrucciones.
    </div>

    <form id="studentForm">
      <div class="mb-4 animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
        <label for="codeSelection" class="form-label"><i class="fas fa-code"></i> Selecciona el Código a Realizar</label>
        <select class="form-select" id="codeSelection">
          <option value="1">Código 1 - Fibonacci</option>
          <option value="2">Código 2 - Potencia</option>
        </select>
      </div>

      <div class="mb-4 animate__animated animate__fadeInUp" style="animation-delay: 0.4s;">
        <h5><i class="fas fa-info-circle"></i> Instrucciones</h5>
        <div class="instructions-box" id="instructions"></div>
      </div>

      <div class="mb-4 animate__animated animate__fadeInUp" style="animation-delay: 0.6s;">
        <h5><i class="fas fa-file-code"></i> Escribe tu Código 1</h5>
        <div class="editor-container">
          <div class="line-numbers" id="lines1"></div>
          <textarea class="editor" id="editor1" spellcheck="false" placeholder="Escribe tu código aquí..."></textarea>
          <div class="highlight" id="highlight1"></div>
        </div>
      </div>

      <div class="mb-4 animate__animated animate__fadeInUp" style="animation-delay: 0.8s;">
        <h5><i class="fas fa-file-code"></i> Escribe tu Código 2</h5>
        <div class="editor-container">
          <div class="line-numbers" id="lines2"></div>
          <textarea class="editor" id="editor2" spellcheck="false" placeholder="Escribe tu código aquí..."></textarea>
          <div class="highlight" id="highlight2"></div>
        </div>
      </div>

      <div class="mb-4 animate__animated animate__fadeInUp timer" style="animation-delay: 1s;">
        <h5><i class="fas fa-clock"></i> Tiempo Restante: <span id="timer">400</span> segundos</h5>
      </div>

      <button type="submit" class="btn btn-primary animate__animated animate__pulse" style="animation-delay: 1.2s;">
        <i class="fas fa-paper-plane"></i> Enviar Respuestas
      </button>
    </form>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Firebase SDK -->
  <script src="https://www.gstatic.com/firebasejs/8.0.0/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/8.0.0/firebase-database.js"></script>
  <script>
    // Configuración de Firebase
    const firebaseConfig = {
      apiKey: "AIzaSyCwXOuTi2iUhyrfBJJ-iiNxg5AI0lr1ECQ",
      authDomain: "dmintel1001.firebaseapp.com",
      databaseURL: "https://dmintel1001-default-rtdb.firebaseio.com",
      projectId: "dmintel1001",
      storageBucket: "dmintel1001.firebasestorage.app",
      messagingSenderId: "846230180021",
      appId: "1:846230180021:web:b1ed5b3bc9275444906efc"
    };

    // Inicializar Firebase
    firebase.initializeApp(firebaseConfig);
    const database = firebase.database();

    // Manejo del formulario
    document.getElementById('studentForm').addEventListener('submit', async (e) => {
      e.preventDefault();

      const code1 = document.getElementById('editor1').value;
      const code2 = document.getElementById('editor2').value;

      if (!code1 || !code2) {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Por favor, completa ambos códigos',
          confirmButtonText: 'Entendido',
          customClass: { confirmButton: 'btn btn-primary' }
        });
        return;
      }

      try {
        const response = await fetch('guardar_respuestas.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ code1, code2 })
        });

        const data = await response.json();

        if (data.status === 'success') {
          Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: 'El examen ha sido enviado correctamente',
            confirmButtonText: 'Entendido',
            customClass: { confirmButton: 'btn btn-primary' }
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = 'index.html';
            }
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: data.message || 'Error al enviar las respuestas',
            confirmButtonText: 'Entendido',
            customClass: { confirmButton: 'btn btn-primary' }
          });
        }
      } catch (error) {
        console.error('Error al enviar las respuestas:', error);
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Error al conectar con el servidor. Por favor, intenta de nuevo.',
          confirmButtonText: 'Entendido',
          customClass: { confirmButton: 'btn btn-primary' }
        });
      }
    });

    // Actualizar números de línea (ejemplo básico, ajusta según script.js)
    const editors = ['editor1', 'editor2'];
    editors.forEach(id => {
      const editor = document.getElementById(id);
      const lines = document.getElementById(`lines${id.slice(-1)}`);
      const highlight = document.getElementById(`highlight${id.slice(-1)}`);
      
      editor.addEventListener('input', () => {
        const lineCount = editor.value.split('\n').length;
        lines.innerHTML = Array.from({ length: lineCount }, (_, i) => i + 1).join('\n');
        highlight.textContent = editor.value;
      });
    });
  </script>

  <script src="script.js"></script>
</body>
</html>