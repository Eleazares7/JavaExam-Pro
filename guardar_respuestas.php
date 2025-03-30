<?php
header('Content-Type: application/json');

// Iniciar la sesión para acceder a los datos del usuario
session_start();

// Verificar si hay una sesión activa y si el usuario es un alumno
if (!isset($_SESSION['user']) || !isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    echo json_encode(["status" => "error", "message" => "No hay una sesión activa o el usuario no es un alumno"]);
    exit();
}

// Conexión a la base de datos
$host = 'sql311.infinityfree.com';
$username = 'if0_38626442';
$password = 'fg5o0v6wB5';
$database = 'if0_38626442_javaexam';

$conn = new mysqli($host, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Error de conexión: " . $conn->connect_error]);
    exit();
}

// Establecer el charset para evitar problemas con caracteres especiales
$conn->set_charset("utf8");

// Validar método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Método no permitido"]);
    exit();
}

// Leer datos del request
$data = json_decode(file_get_contents('php://input'), true);

// Validar que los datos existen
if (!isset($data['code1'], $data['code2'])) {
    echo json_encode(["status" => "error", "message" => "Datos incompletos"]);
    exit();
}

// Escapar los datos para evitar inyecciones SQL
$codigo1 = $conn->real_escape_string($data['code1']);
$codigo2 = $conn->real_escape_string($data['code2']);
$fecha_envio = date('Y-m-d H:i:s'); // Agregar la fecha actual

// Obtener el correo del usuario desde la sesión
$correo = $_SESSION['user']['correo'];

// Buscar el ID del usuario en la tabla Usuarios usando el correo
$sql = "SELECT ID FROM Usuarios WHERE correo = '$correo'";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    echo json_encode(["status" => "error", "message" => "Usuario no encontrado en la tabla Usuarios"]);
    $conn->close();
    exit();
}

$row = $result->fetch_assoc();
$userId = $row['ID'];

// Buscar el registro del alumno en la tabla Alumnos usando el ID del usuario
$sql = "SELECT * FROM Alumnos WHERE IdUsuario = '$userId'";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    echo json_encode(["status" => "error", "message" => "Alumno no encontrado en la tabla Alumnos"]);
    $conn->close();
    exit();
}

// Actualizar los campos codigo1 y codigo2 en la tabla Alumnos
$sql = "UPDATE Alumnos 
        SET codigo1 = '$codigo1', codigo2 = '$codigo2', Fecha_registro = '$fecha_envio' 
        WHERE IdUsuario = '$userId'";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["status" => "success", "message" => "Códigos guardados correctamente en la tabla Alumnos"]);
} else {
    echo json_encode(["status" => "error", "message" => "Error al guardar en Alumnos: " . $conn->error]);
}

$conn->close();
?>