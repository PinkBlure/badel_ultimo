<?php
/**
 * Este script maneja la actualización del estado de una oferta de empleo.
 * 
 * Permite cambiar el estado de una oferta entre "Activo" y "Oculto" en la base de datos.
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
  // Verificar si se han recibido los datos necesarios por POST
  if (isset($_POST['oferta_id']) && isset($_POST['estado_actual'])) {
    
    // Obtener el ID de la oferta y el estado actual desde el formulario
    $ofertaId = $_POST['oferta_id'];
    $estadoActual = $_POST['estado_actual'];

    // Determinar el nuevo estado de la oferta (alternar entre "Activo" y "Oculto")
    $nuevoEstado = ($estadoActual === 'Activo') ? 'Oculto' : 'Activo';

    // Convertir el ID de la oferta a un entero
    $ofertaId = (int)$ofertaId;

    // Crear una conexión a la base de datos
    $conn = createConnection();
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Depuración: Mostrar el nuevo estado y el ID de la oferta
    var_dump($nuevoEstado, $ofertaId);

    // Preparar la consulta SQL para actualizar el estado de la oferta
    $query = "UPDATE oferta_empleo SET estado = :nuevo_estado WHERE id = :oferta_id";
    $stmt = $conn->prepare($query);

    // Vincular los parámetros de la consulta
    $stmt->bindParam(':nuevo_estado', $nuevoEstado);
    $stmt->bindParam(':oferta_id', $ofertaId, PDO::PARAM_INT);

    // Ejecutar la consulta
    if ($stmt->execute()) {
      // Redirigir al dashboard con un mensaje de éxito
      header('Location: ../../centro/dashboard_centro.php?success=1&oferta_id=' . $ofertaId);
      exit();
    } else {
      // Redirigir al dashboard con un mensaje de error
      header('Location: ../../centro/dashboard_centro.php?error=1&oferta_id=' . $ofertaId);
      exit();
    }
  } else {
    // Redirigir al dashboard si no se recibieron los datos necesarios
    header('Location: ../../centro/dashboard_centro.php?error=2');
    exit();
  }
} catch (PDOException $ex) {
  // Registrar el error en el log
  error_log("Error al actualizar el estado de la oferta: " . $ex->getMessage());

  // Redirigir al dashboard con un mensaje de error
  header('Location: ../../centro/dashboard_centro.php?error=3&oferta_id=' . $ofertaId);
  exit();
}
