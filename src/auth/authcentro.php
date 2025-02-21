<?php
/**
 * Este script maneja el proceso de inicio de sesión para usuarios de tipo "centro".
 * 
 * Verifica las credenciales del usuario (email y contraseña) y, si son correctas,
 * establece cookies de sesión y redirige al dashboard del centro.
 * 
 * @category Autenticación
 * @package  SAGA
 * @author   Tu Nombre <tu@email.com>
 * @license  MIT License
 * @link     https://ejemplo.com
 */

// Habilitar reporte de errores para desarrollo
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Iniciar la sesión
session_start();

// Incluir el archivo de conexión a la base de datos
require_once "../../database/conection.php";

try {
  // Crear una conexión a la base de datos
  $conn = createConnection();

  // Verificar si la solicitud es de tipo POST
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener el email y la contraseña del formulario
    $email = $_POST['email'];
    $password = $_POST['pass'];

    // Preparar la consulta SQL para buscar el usuario por email
    $query = "SELECT * FROM centro WHERE email = :email";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    // Obtener el resultado de la consulta
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar si el usuario existe y si la contraseña es correcta
    if ($user && password_verify($password, $user['password'])) {
      // Establecer cookies de sesión
      setcookie('user_id', $user['id'], time() + 43200, "/"); // Cookie para el ID del usuario
      setcookie('user_email', $user['email'], time() + 43200, "/"); // Cookie para el email del usuario
      setcookie('user_type', 'centro', time() + 43200, "/"); // Cookie para el tipo de usuario

      // Redirigir al dashboard del centro
      header('Location: ../centro/dashboard_centro.php');
      exit();
    } else {
      // Mostrar un mensaje de error si las credenciales son incorrectas
      $error = "Correo o contraseña incorrectos.";
      header('Location: ../login.php?error=' . urlencode($error));
      exit();
    }
  }
} catch (PDOException $ex) {
  // Mostrar un mensaje de error si ocurre una excepción
  $error = "Error en la conexión a la base de datos: " . $ex->getMessage();
  header('Location: ../login.php?error=' . urlencode($error));
  exit();
}
?>
