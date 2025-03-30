<?php
// Iniciar la sesión para acceder a los datos del usuario
session_start();

// Verificar si hay una sesión activa y si el usuario es un profesor
if (!isset($_SESSION['user']) || !isset($_SESSION['rol']) || $_SESSION['rol'] != 2) {
    header("Location: index.html");
    exit();
}

// Obtener el nombre del profesor desde la sesión
$nombre = isset($_SESSION['user']['nombre']) ? htmlspecialchars($_SESSION['user']['nombre']) : 'Profesor';

// Configuración de la conexión a MySQL
$host = 'sql311.infinityfree.com';
$username = 'if0_38626442';
$password = 'fg5o0v6wB5';
$database = 'if0_38626442_javaexam';

$conn = new mysqli($host, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    $error = "Error al conectar a la base de datos: " . $conn->connect_error;
} else {
    // Consultar los datos
    $query = "SELECT Alumnos.ID, Alumnos.nombre, Alumnos.apellido, Usuarios.correo, Alumnos.codigo1, Alumnos.codigo2, Alumnos.calificacion, Alumnos.comentario 
              FROM Alumnos 
              JOIN Usuarios ON Alumnos.IdUsuario = Usuarios.ID";
    $result = $conn->query($query);
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Ver Respuestas - Examen de Programación</title>
  <!-- Bootstrap 5 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
  <!-- Animate.css para animaciones -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <!-- Font Awesome para íconos -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <!-- Estilos personalizados -->
  <style>
    body {
      background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
      color: #fff;
      font-family: 'Poppins', sans-serif;
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
    .table {
      border-radius: 15px;
      overflow: hidden;
      background: #fff;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    .table thead th {
      background: #2a5298;
      color: #fff;
      border: none;
      padding: 15px;
    }
    .table tbody tr {
      transition: all 0.3s ease;
    }
    .table tbody tr:hover {
      background: #f8f9fa;
      transform: scale(1.02);
    }
    .calificacion-input {
      width: 80px;
      border-radius: 8px;
      padding: 5px;
      box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.05);
    }
    .comentario-textarea {
      width: 100%;
      min-height: 100px;
      border-radius: 8px;
      padding: 10px;
      box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.05);
      transition: all 0.3s ease;
    }
    .comentario-textarea:focus {
      border-color: #2a5298;
      box-shadow: 0 0 10px rgba(42, 82, 152, 0.3);
    }
    .btn {
      border-radius: 25px;
      padding: 8px 20px;
      font-weight: 600;
      transition: all 0.3s ease;
    }
    .btn-success {
      background: #28a745;
      border: none;
    }
    .btn-success:hover {
      background: #218838;
      transform: translateY(-2px);
    }
    .btn-primary {
      background: #2a5298;
      border: none;
    }
    .btn-primary:hover {
      background: #1e3c72;
      transform: translateY(-2px);
    }
    .btn i {
      margin-right: 5px;
    }
    td {
      vertical-align: middle;
    }
    .action-buttons {
      display: flex;
      gap: 10px;
    }
  </style>
</head>
<body>
  <div class="container animate__animated animate__fadeIn">
    <h1 class="animate__animated animate__bounceInDown">Respuestas de los Estudiantes</h1>
    <div class="alert alert-info animate__animated animate__fadeInUp" role="alert">
      <i class="fas fa-chalkboard-teacher"></i> Bienvenido profesor <?php echo $nombre; ?>. Por favor, revise las respuestas de los alumnos.
    </div>

    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Correo</th>
            <th>Código 1</th>
            <th>Código 2</th>
            <th>Calificación</th>
            <th>Comentario</th>
            <th>Acción</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if (isset($error)) {
              echo "<tr><td colspan='9' class='text-center text-danger'>$error</td></tr>";
          } elseif ($result && $result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  $nombreArchivo = htmlspecialchars($row['nombre'] . '_' . $row['apellido']);
                  $codigo1 = $row['codigo1'] ?? 'Sin código';
                  $codigo2 = $row['codigo2'] ?? 'Sin código';
                  $calificacion = $row['calificacion'] ?? '';
                  $comentario = $row['comentario'] ?? '';
                  echo "<tr class='animate__animated animate__fadeInUp'>";
                  echo "<td>" . htmlspecialchars($row['ID']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['nombre']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['apellido']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['correo']) . "</td>";
                  echo "<td>" . htmlspecialchars($codigo1) . "</td>";
                  echo "<td>" . htmlspecialchars($codigo2) . "</td>";
                  echo "<td><input type='text' class='form-control calificacion calificacion-input' value='" . htmlspecialchars($calificacion) . "' data-id='" . $row['ID'] . "'></td>";
                  echo "<td><textarea class='form-control comentario comentario-textarea' data-id='" . $row['ID'] . "'>" . htmlspecialchars($comentario) . "</textarea></td>";
                  echo "<td class='action-buttons'>";
                  echo "<button class='btn btn-success btn-sm download-btn' 
                        data-nombre='$nombreArchivo' 
                        data-codigo1='" . addslashes($codigo1) . "' 
                        data-codigo2='" . addslashes($codigo2) . "'><i class='fas fa-download'></i> Descargar</button>";
                  echo "<button class='btn btn-primary btn-sm save-btn' data-id='" . $row['ID'] . "'><i class='fas fa-save'></i> Guardar</button>";
                  echo "</td>";
                  echo "</tr>";
              }
          } else {
              echo "<tr><td colspan='9' class='text-center text-muted'>No hay respuestas registradas.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
    <a href="index.html" class="btn btn-primary mt-3 animate__animated animate__pulse"><i class="fas fa-arrow-left"></i> Volver al Examen</a>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
  <script>
    // Descarga de códigos
    document.querySelectorAll('.download-btn').forEach(button => {
      button.addEventListener('click', function() {
        const nombre = this.getAttribute('data-nombre');
        const codigo1 = this.getAttribute('data-codigo1');
        const codigo2 = this.getAttribute('data-codigo2');

        if (!codigo1 && !codigo2) {
          Swal.fire({
            icon: 'warning',
            title: 'Sin códigos',
            text: 'Este alumno no tiene códigos para descargar.',
            confirmButtonText: 'Entendido',
            customClass: { confirmButton: 'btn btn-primary' }
          });
          return;
        }

        const zip = new JSZip();
        if (codigo1 !== 'Sin código') {
          zip.file(`${nombre}_Codigo1.java`, codigo1);
        }
        if (codigo2 !== 'Sin código') {
          zip.file(`${nombre}_Codigo2.java`, codigo2);
        }

        zip.generateAsync({ type: 'blob' }).then(function(content) {
          saveAs(content, `${nombre}_Codigos.zip`);
        });
      });
    });

    // Guardar calificación y comentario
    document.querySelectorAll('.save-btn').forEach(button => {
      button.addEventListener('click', function() {
        const id = this.getAttribute('data-id');
        const calificacion = document.querySelector(`input.calificacion[data-id="${id}"]`).value;
        const comentario = document.querySelector(`textarea.comentario[data-id="${id}"]`).value;

        fetch('guardar_calificacion.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ id: id, calificacion: calificacion, comentario: comentario })
        })
        .then(response => response.json())
        .then(data => {
          if (data.status === 'success') {
            Swal.fire({
              icon: 'success',
              title: 'Guardado',
              text: 'Calificación y comentario guardados correctamente',
              confirmButtonText: 'Entendido',
              customClass: { confirmButton: 'btn btn-primary' }
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: data.message || 'Error al guardar los datos',
              confirmButtonText: 'Entendido',
              customClass: { confirmButton: 'btn btn-primary' }
            });
          }
        })
        .catch(error => {
          console.error('Error al guardar:', error);
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error al conectar con el servidor',
            confirmButtonText: 'Entendido',
            customClass: { confirmButton: 'btn btn-primary' }
          });
        });
      });
    });
  </script>
</body>
</html>