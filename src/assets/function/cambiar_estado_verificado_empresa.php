<?php
/**
 * Este script maneja la verificación de una empresa en el sistema.
 * 
 * Permite actualizar el estado de verificación de una empresa a "verificada" (1) en la base de datos.
 * 
 * @category Empresa
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
  // Verificar si se ha recibido el ID de la empresa por POST
  if (isset($_POST['empresa_id'])) {
    
    // Obtener el ID de la empresa desde el formulario
    $empresaId = $_POST['empresa_id'];

    // Crear una conexión a la base de datos
    $conn = createConnection();
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Preparar la consulta SQL para actualizar el estado de verificación de la empresa
    $query = "UPDATE empresa SET verificado = 1 WHERE id = :empresa_id";
    $stmt = $conn->prepare($query);

    // Vincular el parámetro de la consulta
    $stmt->bindParam(':empresa_id', $empresaId, PDO::PARAM_INT);

    // Ejecutar la consulta
    if ($stmt->execute()) {
      // Redirigir al listado de empresas con un mensaje de éxito
      header('Location: ../../centro/listado_empresas.php?success=1');
      exit();
    } else {
      // Mostrar un mensaje de error si la consulta no se ejecuta correctamente
      echo "Error al actualizar el estado de verificación.";
    }
  } else {
    // Mostrar un mensaje de error si no se recibió el ID de la empresa
    echo "Falta el ID de la empresa.";
  }
} catch (PDOException $ex) {
  // Mostrar un mensaje de error si ocurre una excepción
  echo "Error al procesar la solicitud: " . $ex->getMessage();
}
?>
