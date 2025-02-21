<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Verificar si el archivo fue cargado correctamente
  if (isset($_FILES['curriculum']) && $_FILES['curriculum']['error'] === UPLOAD_ERR_OK) {
    // Validar tipo de archivo (solo PDF)
    $fileType = $_FILES['curriculum']['type'];
    $allowedTypes = ['application/pdf'];

    if (!in_array($fileType, $allowedTypes)) {
      echo "<p>Error: Solo se permiten archivos PDF.</p>";
      exit();
    }

    // Conectar a la base de datos
    require_once "../../database/conection.php";

    try {
      $conn = createConnection();

      if (!$conn) {
        error_log("No se pudo establecer la conexión a la base de datos.");
        exit();
      }

      // Verificar que la oferta existe
      $query = "SELECT * FROM oferta_empleo WHERE id = :oferta_id AND estado = 'Activo'";
      $stmt = $conn->prepare($query);
      $stmt->bindParam(':oferta_id', $_GET['oferta_id'], PDO::PARAM_INT);
      $stmt->execute();
      $oferta = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$oferta) {
        echo "<p>Error: La oferta de empleo no existe o ya no está activa.</p>";
        exit();
      }

      // Insertar la inscripción en la base de datos
      $usuario_id = $_COOKIE['user_id'];
      $oferta_id = $_GET['oferta_id'];

      $insertQuery = "INSERT INTO inscripcion (usuario_id, oferta_id) VALUES (:usuario_id, :oferta_id)";
      $insertStmt = $conn->prepare($insertQuery);
      $insertStmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
      $insertStmt->bindParam(':oferta_id', $oferta_id, PDO::PARAM_INT);

      if ($insertStmt->execute()) {
        // Mostrar mensaje de éxito
        echo "<p>¡Te has postulado con éxito! Tu currículum ha sido enviado.</p>";
      } else {
        echo "<p>Error al registrar la inscripción.</p>";
      }
    } catch (PDOException $ex) {
      error_log("Error en la base de datos: " . $ex->getMessage());
      echo "<p>Error al procesar la inscripción.</p>";
      exit();
    }
  } else {
    echo "<p>Error: No se ha seleccionado ningún archivo o ha ocurrido un error al subirlo.</p>";
  }
}

session_start();

if (!isset($_COOKIE['user_type']) || $_COOKIE['user_type'] !== 'usuario') {
  header('Location: ../../index.php');
  exit();
}

if (isset($_GET['oferta_id'])) {
  $oferta_id = $_GET['oferta_id'];

  // Verificar que la oferta existe
  require_once "../../database/conection.php";
  try {
    $conn = createConnection();
    $query = "SELECT * FROM oferta_empleo WHERE id = :oferta_id AND estado = 'Activo'";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':oferta_id', $oferta_id, PDO::PARAM_INT);
    $stmt->execute();
    $oferta = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$oferta) {
      echo "<p>Error: La oferta de empleo no existe o ya no está activa.</p>";
      exit();
    }
  } catch (PDOException $ex) {
    error_log("Error en la base de datos: " . $ex->getMessage());
    echo "<p>Error al obtener la oferta de empleo.</p>";
    exit();
  }
} else {
  echo "<p>Error: ID de oferta no proporcionado.</p>";
  exit();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Postularse a Oferta de Empleo</title>
  <link rel="icon" type="image/png" href="../assets/img/logo_size.jpg">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="d-flex flex-column min-vh-100">
  <header class="container text-center py-3">
    <img src="../assets/img/logo_size_long.jpg" alt="Logo" class="img-fluid w-70 w-md-50 w-lg-25 mx-auto d-block">
  </header>

  <nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container">
      <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="../auth/logout.php">Cerrar sesión</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <main class="container my-5">
    <h1>Postúlate para la oferta de empleo: <?= htmlspecialchars($oferta['titulo']) ?></h1>
    <section id="formulario-postulacion" class="my-4">
      <form action="postular.php?oferta_id=<?= $oferta_id ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
          <label for="curriculum" class="form-label">Sube tu currículum (PDF, máximo 2MB)</label>
          <input type="file" class="form-control" id="curriculum" name="curriculum" accept=".pdf" required>
        </div>
        <button type="submit" class="btn btn-primary">Postularse</button>
      </form>
    </section>
  </main>

  <footer class="bg-dark text-light py-4 mt-5">
    <div class="container">
      <div class="row">
        <div class="col-md-4 mb-3">
          <h5>Sobre nosotros</h5>
          <p>IES Fernando Sagaseta, ubicado en Valle de Jinamar, Las Palmas, España, es un instituto de formación profesional con un compromiso con la educación y el futuro laboral de sus estudiantes.</p>
        </div>
        <div class="col-md-4 mb-3">
          <h5>Enlaces rápidos</h5>
          <ul class="list-unstyled">
            <li><a href="../../index.php" class="text-light">Inicio</a></li>
            <li><a href="../../src/ofertas.php" class="text-light">Ofertas de trabajo</a></li>
            <li><a href="../../src/about.php" class="text-light">Nosotros</a></li>
          </ul>
        </div>
        <div class="col-md-4 mb-3">
          <h5>Contacto</h5>
          <p>Teléfono: +34 928 59 92 69</p>
          <p>Email: contacto@sagasetaconecta.com</p>
          <p>Dirección: Valle de Jinamar, Las Palmas, España</p>
        </div>
      </div>

      <div class="text-center mt-4">
        <p>&copy; 2025 SagasetaConecta. Todos los derechos reservados.</p>
        <p>
          <a href="../../src/assets/pdf/Política de Privacidad.pdf" class="text-light" target="_blank">Política de privacidad</a> |
          <a href="../../src/assets/pdf/Términos y Condiciones de Uso.pdf" class="text-light" target="_blank">Términos y condiciones</a>
        </p>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
