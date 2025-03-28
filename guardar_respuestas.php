<?php
// Configuración de la conexión a MySQL
$host = 'sql311.infinityfree.com';
$username = 'if0_38626442';
$password = 'fg5o0v6wB5';
$database = 'if0_38626442_javaexam';

// Crear la conexión
$conn = new mysqli($host, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die(json_encode(['error' => 'Error al conectar a la base de datos: ' . $conn->connect_error]));
}

// Configurar el encabezado para permitir CORS (necesario para solicitudes desde el frontend)
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Permitir solicitudes desde cualquier origen
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Leer los datos enviados desde el frontend
$data = json_decode(file_get_contents('php://input'), true);

// Verificar que todos los campos estén presentes
if (!isset($data['nombre']) || !isset($data['matricula']) || !isset($data['code1']) || !isset($data['code2'])) {
    echo json_encode(['error' => 'Todos los campos son requeridos']);
    http_response_code(400);
    exit;
}

// Escapar los datos para prevenir inyecciones SQL
$nombre = $conn->real_escape_string($data['nombre']);
$matricula = $conn->real_escape_string($data['matricula']);
$code1 = $conn->real_escape_string($data['code1']);
$code2 = $conn->real_escape_string($data['code2']);

// Preparar la consulta SQL para insertar los datos
$query = "INSERT INTO respuestas (nombre, matricula, codigo1, codigo2) VALUES ('$nombre', '$matricula', '$code1', '$code2')";

// Ejecutar la consulta
if ($conn->query($query) === TRUE) {
    echo json_encode(['message' => 'Respuestas guardadas correctamente']);
    http_response_code(200);
} else {
    echo json_encode(['error' => 'Error al guardar las respuestas: ' . $conn->error]);
    http_response_code(500);
}

// Cerrar la conexión
$conn->close();
