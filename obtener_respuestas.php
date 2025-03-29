<?php
// Configuración de la conexión a MySQL (igual que en guardar_respuestas.php)
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

// Configurar el encabezado para permitir CORS
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

// Consultar todos los registros de la tabla respuestas
$query = "SELECT * FROM respuestas";
$result = $conn->query($query);

if ($result) {
    $respuestas = [];
    while ($row = $result->fetch_assoc()) {
        $respuestas[] = $row;
    }
    echo json_encode($respuestas);
    http_response_code(200);
} else {
    echo json_encode(['error' => 'Error al obtener las respuestas: ' . $conn->error]);
    http_response_code(500);
}

// Cerrar la conexión
$conn->close();
