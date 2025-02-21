<?php
/**
 * Este script maneja el proceso de registro de una empresa.
 * 
 * Recibe los datos del formulario de registro (nombre, CIF, email y contraseña),
 * valida los campos, verifica si el email ya está registrado, encripta la contraseña
 * y guarda la información en la base de datos.
 * 
 * @category Registro
 * @package  SAGA
 * @author   Tu Nombre <tu@email.com>
 * @license  MIT License
 * @link     https://ejemplo.com
 */

// Verificar si la solicitud es de tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluir el archivo de conexión a la base de datos
    require_once "../../database/conection.php";

    try {
        // Crear una conexión a la base de datos
        $conn = createConnection(); // Suponiendo que esta función devuelve una instancia de PDO

        // Obtener y limpiar los datos del formulario
        $nombre = trim($_POST["nombre"]);
        $cif = trim($_POST["cif"]);
        $email = trim($_POST["email"]);
        $password = $_POST["password"];

        // Validar que los campos no estén vacíos
        if (empty($nombre) || empty($cif) || empty($email) || empty($password)) {
            // Redirigir con un mensaje de error si algún campo está vacío
            header("Location: registro_empresa.php?error=Todos los campos son obligatorios");
            exit();
        }

        // Verificar si el email ya está registrado
        $stmt = $conn->prepare("SELECT id FROM empresa WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            // Redirigir con un mensaje de error si el email ya está registrado
            header("Location: registro_empresa.php?error=El email ya está registrado");
            exit();
        }

        // Encriptar la contraseña
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        // Insertar la nueva empresa en la base de datos
        $stmt = $conn->prepare("INSERT INTO empresa (nombre, CIF, email, password) VALUES (?, ?, ?, ?)");
        $success = $stmt->execute([$nombre, $cif, $email, $password_hash]);

        if ($success) {
            // Redirigir con un mensaje de éxito si el registro fue exitoso
            header("Location: ../login.php?success=Registro exitoso, ahora puedes iniciar sesión");
        } else {
            // Redirigir con un mensaje de error si hubo un problema en el registro
            header("Location: registro_empresa.php?error=Error en el registro, intenta de nuevo");
        }

    } catch (PDOException $e) {
        // Redirigir con un mensaje de error si ocurre una excepción en la base de datos
        header("Location: registro_empresa.php?error=Error en la base de datos: " . urlencode($e->getMessage()));
    }
} else {
    // Redirigir al formulario de registro si la solicitud no es de tipo POST
    header("Location: registro_empresa.php");
    exit();
}
?>
