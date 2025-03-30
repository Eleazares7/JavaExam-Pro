<?php
session_start();

header('Content-Type: application/json');

// Verificar si el usuario es profesor
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 2) {
    echo json_encode(['status' => 'error', 'message' => 'No autorizado']);
    exit();
}

// Configuración de la conexión a MySQL
$host = 'sql311.infinityfree.com';
$username = 'if0_38626442';
$password = 'fg5o0v6wB5';
$database = 'if0_38626442_javaexam';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Error al conectar a la base de datos']);
    exit();
}

// Obtener datos enviados desde el frontend
$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'] ?? '';
$calificacion = $data['calificacion'] ?? '';
$comentario = $data['comentario'] ?? '';

// Validar datos
if (empty($id)) {
    echo json_encode(['status' => 'error', 'message' => 'ID del alumno no proporcionado']);
    exit();
}

// Preparar y ejecutar la consulta
$query = "UPDATE Alumnos SET calificacion = ?, comentario = ? WHERE ID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('ssi', $calificacion, $comentario, $id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error al actualizar los datos']);
}

$stmt->close();
$conn->close();
?>