<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (!isset($_COOKIE['user_type']) || $_COOKIE['user_type'] !== 'empresa') {
    header('Location: ../../index.php');
    exit();
}

require_once "../../database/conection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = createConnection();

    $empresa_id = $_POST['empresa_id'];
    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    $ubicacion = trim($_POST['ubicacion']);
    $familia_id = $_POST['familia_id'];
    $presencialidad = $_POST['presencialidad'];
    $jornada = $_POST['jornada'];
    $tipo_contrato = $_POST['tipo_contrato'];
    $estado = "Pendiente de verificar"; // Estado inicial
    $slug = strtolower(str_replace(" ", "-", $titulo));

    try {
        $query = "INSERT INTO oferta_empleo (empresa_id, familia_id, titulo, descripcion, fecha_publicacion, verificado, ubicacion, presencialidad, jornada, tipo_contrato, estado, slug)
                  VALUES (:empresa_id, :familia_id, :titulo, :descripcion, NOW(), 0, :ubicacion, :presencialidad, :jornada, :tipo_contrato, :estado, :slug)";
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':empresa_id', $empresa_id, PDO::PARAM_INT);
        $stmt->bindParam(':familia_id', $familia_id, PDO::PARAM_INT);
        $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':ubicacion', $ubicacion, PDO::PARAM_STR);
        $stmt->bindParam(':presencialidad', $presencialidad, PDO::PARAM_STR);
        $stmt->bindParam(':jornada', $jornada, PDO::PARAM_STR);
        $stmt->bindParam(':tipo_contrato', $tipo_contrato, PDO::PARAM_STR);
        $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
        $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);

        if ($stmt->execute()) {
            header("Location: dashboard_empresa.php?success=Oferta publicada");
            exit();
        } else {
            echo "Error al crear la oferta.";
        }
    } catch (PDOException $ex) {
        echo "Error en la base de datos: " . $ex->getMessage();
    } finally {
        $conn = null;
    }
} else {
    echo "Acceso no permitido.";
}
?>
