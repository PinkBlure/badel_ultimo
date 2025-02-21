<?php
/**
 * Este script maneja la verificación de un usuario en el sistema.
 * 
 * Permite actualizar el estado de verificación de un usuario a "verificado" (1) en la base de datos.
 * 
 * @category Usuario
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

// Verificar si el usuario tiene permisos de "centro" mediante una cookie
if (!isset($_COOKIE['user_type']) || $_COOKIE['user_type'] !== 'centro') {
  // Redirigir al usuario a la página de inicio si no tiene permisos
  header('Location: ../../index.php');
  exit();
}

// Incluir el archivo de conexión a la base de datos
require_once "../../../database/conection.php";

try {
  // Verificar si se ha recibido el ID del usuario por POST
  if (isset($_POST['usuario_id'])) {
    
    // Obtener el ID del usuario desde el formulario
    $id = $_POST['usuario_id'];

    // Crear una conexión a la base de datos
    $conn = createConnection();
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Preparar la consulta SQL para actualizar el estado de verificación del usuario
    $query = "UPDATE usuario SET verificado = 1 WHERE id = :id";
    $stmt = $conn->prepare($query);

    // Vincular el parámetro de la consulta
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Ejecutar la consulta
    if ($stmt->execute()) {
      // Redirigir al listado de usuarios con un mensaje de éxito
      header('Location: ../../centro/listado_usuarios.php?success=1');
      exit();
    } else {
      // Mostrar un mensaje de error si la consulta no se ejecuta correctamente
      echo "Error al actualizar el estado de verificación.";
    }
  } else {
    // Mostrar un mensaje de error si no se recibió el ID del usuario
    echo "Falta el ID del usuario.";
  }
} catch (PDOException $ex) {
  // Mostrar un mensaje de error si ocurre una excepción
  echo "Error al procesar la solicitud: " . $ex->getMessage();
}
?>
