<?php
/**
 * Este script maneja la conexión a una base de datos MySQL utilizando PDO.
 * 
 * @category Database
 * @package  SAGA
 * @author   Tu Nombre <tu@email.com>
 * @license  MIT License
 * @link     https://ejemplo.com
 */

// Habilitar reporte de errores para desarrollo
error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * Crea una conexión a la base de datos MySQL.
 *
 * Esta función intenta establecer una conexión a una base de datos MySQL utilizando PDO.
 * Si la conexión es exitosa, devuelve un objeto PDO. En caso de error, registra el error
 * en el log y devuelve `null`.
 *
 * @return PDO|null Objeto PDO si la conexión es exitosa, `null` en caso de error.
 * @throws PDOException Si ocurre un error durante la conexión.
 */
function createConnection()
{
  try {
    // Configuración de la conexión a la base de datos
    $host = "localhost";  // Host de la base de datos
    $db = "sagasetaconecta";  // Nombre de la base de datos
    $user = "admin";  // Usuario de la base de datos
    $pass = "admin";  // Contraseña de la base de datos
    $dns = "mysql:host=$host;dbname=$db";  // Cadena de conexión DSN

    // Crear una nueva instancia de PDO
    $conn = new PDO($dns, $user, $pass);

    // Configurar el modo de error para lanzar excepciones
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Devolver la conexión establecida
    return $conn;
  } catch (PDOException $ex) {
    // Registrar el error en el log
    error_log("Error en la conexión a la base de datos: " . $ex->getMessage());

    // Devolver `null` en caso de error
    return null;
  }
}
