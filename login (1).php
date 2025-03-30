<?php
// Iniciar la sesión
session_start();

// Configuración de la conexión a la base de datos
$host = 'sql311.infinityfree.com'; // Host proporcionado
$dbname = 'if0_38626442_javaexam'; // Nombre de la base de datos
$username = 'if0_38626442'; // Usuario de la base de datos
$password = 'fg5o0v6wB5'; // Contraseña de la base de datos

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Error de conexión: ' . $e->getMessage()]);
    exit();
}

// Obtener los datos enviados desde el formulario
$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'] ?? '';
$password = $data['password'] ?? '';

// Validar que los campos no estén vacíos
if (empty($email) || empty($password)) {
    echo json_encode(['status' => 'error', 'message' => 'Correo y contraseña son obligatorios']);
    exit();
}

// Verificar si el usuario existe en la tabla Usuarios y obtener la contraseña hasheada y el ID
$query = "SELECT ID, IdRol, contraseña FROM Usuarios WHERE correo = :email";
$stmt = $pdo->prepare($query);
$stmt->execute(['email' => $email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || !password_verify($password, $user['contraseña'])) {
    echo json_encode(['status' => 'error', 'message' => 'Credenciales incorrectas']);
    exit();
}

// Obtener el ID y el rol del usuario
$userId = $user['ID'];
$rol = $user['IdRol'];

// Consultar la tabla correspondiente según el rol y guardar la información en la sesión
if ($rol == 1) {
    // Rol 1: Alumno - Hacer un JOIN entre Usuarios y Alumnos usando el ID
    $query = "SELECT Usuarios.correo, Alumnos.nombre, Alumnos.apellido, Alumnos.matricula 
              FROM Usuarios 
              JOIN Alumnos ON Usuarios.ID = Alumnos.IdUsuario 
              WHERE Usuarios.ID = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id' => $userId]);
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($userData) {
        // Guardar la información del alumno en la sesión
        $_SESSION['user'] = $userData;
        $_SESSION['rol'] = $rol;
        echo json_encode(['status' => 'success', 'rol' => 'alumno']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No se encontró información del alumno']);
    }
} elseif ($rol == 2) {
    // Rol 2: Profesor - Hacer un JOIN entre Usuarios y Profesores usando el ID
    $query = "SELECT Usuarios.correo, Profesores.nombre, Profesores.apellido 
              FROM Usuarios 
              JOIN Profesores ON Usuarios.ID = Profesores.IdUsuario 
              WHERE Usuarios.ID = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id' => $userId]);
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($userData) {
        // Guardar la información del profesor en la sesión
        $_SESSION['user'] = $userData;
        $_SESSION['rol'] = $rol;
        echo json_encode(['status' => 'success', 'rol' => 'profesor']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No se encontró información del profesor']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Rol no válido']);
}
?>