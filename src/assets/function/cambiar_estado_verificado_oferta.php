<?php
/**
 * Este script maneja la verificación y activación de una oferta de empleo.
 * 
 * Permite actualizar el estado de una oferta a "verificado" y "Activo" en la base de datos.
 * 
 * @category Empleo
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
  // Verificar si se ha recibido el ID de la oferta por POST
  if (isset($_POST['oferta_id'])) {
    
    // Obtener el ID de la oferta desde el formulario
    $id = $_POST['oferta_id'];

    // Crear una conexión a la base de datos
    $conn = createConnection();
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Depuración: Mostrar el estado actual (esto debería ser eliminado en producción)
    echo "Estado actual: " . htmlspecialchars($estadoActual);

    // Preparar la consulta SQL para actualizar el estado de la oferta
    $query = "UPDATE oferta_empleo SET verificado = 1, estado = 'Activo' WHERE id = :id";
    $stmt = $conn->prepare($query);

    // Vincular el parámetro de la consulta
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Ejecutar la consulta
    if ($stmt->execute()) {
      // Mostrar un mensaje de éxito
      echo "Estado actualizado a 'Activo'.";

      // Redirigir al listado de ofertas con un mensaje de éxito
      header('Location: ../../centro/listado_ofertas.php?success=1');
      exit();
    } else {
      // Mostrar un mensaje de error si la consulta no se ejecuta correctamente
      echo "Error al actualizar el estado de verificación.";
    }
  } else {
    // Mostrar un mensaje de error si no se recibió el ID de la oferta
    echo "Falta el ID de la oferta.";
  }
} catch (PDOException $ex) {
  // Mostrar un mensaje de error si ocurre una excepción
  echo "Error al procesar la solicitud: " . $ex->getMessage();
}
?>
