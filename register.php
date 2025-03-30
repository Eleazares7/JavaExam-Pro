<?php
header('Content-Type: application/json');

// Conexión a la base de datos
$host = 'sql311.infinityfree.com';
$username = 'if0_38626442';
$password = 'fg5o0v6wB5';
$database = 'if0_38626442_javaexam';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Error de conexión: " . $conn->connect_error]);
    exit();
}

$conn->set_charset("utf8");

// Validar método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Método no permitido"]);
    exit();
}

// Leer datos del request
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['matricula'], $data['nombre'], $data['apellido'], $data['email'], $data['password'])) {
    echo json_encode(["status" => "error", "message" => "Datos incompletos"]);
    exit();
}

$matricula = $conn->real_escape_string($data['matricula']);
$nombre = $conn->real_escape_string($data['nombre']);
$apellido = $conn->real_escape_string($data['apellido']);
$email = $conn->real_escape_string($data['email']);
$password = password_hash($data['password'], PASSWORD_DEFAULT); // Hashear la contraseña
$idRol = 1; // Rol 'alumno' (ID 1, según los datos insertados en Roles)

// Iniciar transacción
$conn->begin_transaction();

try {
    // Verificar si el correo ya está registrado
    $sql = "SELECT * FROM Usuarios WHERE correo = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        throw new Exception("El correo ya está registrado");
    }

    // Verificar si la matrícula ya está registrada en la tabla Alumnos
    $sql = "SELECT * FROM Alumnos WHERE matricula = '$matricula'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        throw new Exception("La matrícula ya está registrada");
    }

    // Insertar el nuevo usuario en la tabla Usuarios
    $sql = "INSERT INTO Usuarios (correo, contraseña, IdRol) 
            VALUES ('$email', '$password', $idRol)";
    
    if (!$conn->query($sql)) {
        throw new Exception("Fallo al registrar el usuario: " . $conn->error);
    }

    // Obtener el ID del usuario recién insertado
    $userId = $conn->insert_id;

    // Insertar los datos en la tabla Alumnos
    $sql2 = "INSERT INTO Alumnos (IdUsuario, matricula, nombre, apellido) 
             VALUES ($userId, '$matricula', '$nombre', '$apellido')";
    
    if (!$conn->query($sql2)) {
        throw new Exception("Fallo al registrar los datos del alumno: " . $conn->error);
    }

    // Confirmar transacción
    $conn->commit();
    echo json_encode(["status" => "success", "message" => "Registro exitoso"]);
} catch (Exception $e) {
    // Revertir transacción en caso de error
    $conn->rollback();
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}

$conn->close();
?>