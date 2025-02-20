<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  require_once "../../database/conection.php";

  try {
    $conn = createConnection();

    $nombre = trim($_POST["nombre"]);
    $dni = trim($_POST["dni"]);
    $cial = trim($_POST["cial"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $familia_profesional_id = $_POST["familia_profesional_id"];

    // Validar que los campos no estén vacíos
    if (empty($nombre) || empty($dni) || empty($cial) || empty($email) || empty($password) || empty($familia_profesional_id)) {
      header("Location: registro_usuario.php?error=Todos los campos son obligatorios");
      exit();
    }

    // Encriptar contraseña
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    // Verificar si el email ya está registrado
    $stmt = $conn->prepare("SELECT id FROM usuario WHERE email = :email");
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      header("Location: registro_usuario.php?error=El email ya está registrado");
      exit();
    }

    // Insertar en la base de datos
    $stmt = $conn->prepare("INSERT INTO usuario (nombre, dni, cial, email, password, familia_profesional_id) VALUES (:nombre, :dni, :cial, :email, :password, :familia_profesional_id)");

    $stmt->bindParam(":nombre", $nombre);
    $stmt->bindParam(":dni", $dni);
    $stmt->bindParam(":cial", $cial);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":password", $password_hash);
    $stmt->bindParam(":familia_profesional_id", $familia_profesional_id);

    if ($stmt->execute()) {
      header("Location: ../login.php?success=Registro exitoso, ahora puedes iniciar sesión");
    } else {
      header("Location: registro_usuario.php?error=Error en el registro, intenta de nuevo");
    }
  } catch (PDOException $e) {
    die("Error en la base de datos: " . $e->getMessage());
  }

  $conn = null;
} else {
  header("Location: registro_usuario.php");
  exit();
}
