<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../database/conection.php";

if (!isset($_COOKIE['user_type']) && $_COOKIE['user_type'] !== 'empresa') {
  header('Location: ../../index.php');
  exit();
}

if (isset($_GET['slug'])) {
  $slug = $_GET['slug'];

  try {
    $conn = createConnection();

    if (!$conn) {
      error_log("No se pudo establecer la conexión a la base de datos.");
      exit();
    }

    $query = "SELECT * FROM oferta_empleo WHERE slug = :slug";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':slug', $slug);
    $stmt->execute();
    $oferta = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$oferta) {
      echo "Oferta no encontrada.";
      exit();
    }

    $query = "SELECT nombre FROM empresa WHERE id = :empresa_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':empresa_id', $oferta['empresa_id']);
    $stmt->execute();
    $empresa = $stmt->fetch(PDO::FETCH_ASSOC);

    $query = "SELECT COUNT(1) AS total_inscripciones FROM inscripcion WHERE oferta_id = :oferta_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':oferta_id', $oferta['id']);
    $stmt->execute();
    $inscripciones = $stmt->fetch(PDO::FETCH_ASSOC);
    $totalInscripciones = $inscripciones['total_inscripciones'];
  } catch (PDOException $ex) {
    error_log("Error al conectar con la base de datos: " . $ex->getMessage());
    exit();
  } finally {
    $conn = null;
  }
} else {
  echo "Slug de oferta no proporcionado.";
  exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SagasetaConecta - <?php echo htmlspecialchars($oferta['titulo']); ?></title>
  <meta name="description" content="<?php echo htmlspecialchars($oferta['descripcion']); ?>">
  <link rel="icon" type="image/png" href="./assets/img/logo_size.jpg">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    html {
      overflow-y: scroll;
    }

    body {
      padding-right: 0;
    }

    .hover-effect:hover {
      color: #0056b3;
      text-decoration: underline;
    }

    .btn-link {
      font-weight: 500;
    }
  </style>
</head>

<body>

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
            <a class="nav-link" href="./dashboard_empresa.php">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./crear_oferta.php">Crear una oferta</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../auth/logout.php">Cerrar sesión</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <main class="container my-5">
    <h1 class="text-center"><?php echo htmlspecialchars($oferta['titulo']); ?></h1>
    <p class="text-muted text-center">Publicado el: <?php echo (new DateTime($oferta['fecha_publicacion']))->format('d/m/Y'); ?></p>

    <div class="container my-5">
      <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
          <div class="p-4 bg-white rounded-3 shadow-sm border border-1 border-secondary">
            <div class="d-flex justify-content-between align-items-center mb-4">
              <h1 class="fw-bold text-dark mb-0" style="font-size: 1.8rem;"><?php echo htmlspecialchars($empresa['nombre']); ?></h1>
              <span class="badge text-dark rounded-pill bg-light"><?php echo htmlspecialchars($oferta['ubicacion']); ?></span>
            </div>
            <div class="mb-4">
              <h3 class="mb-3" style="font-size: 1.4rem; color: #5bc0de;">Descripción del puesto</h3>
              <p class="fs-5 text-muted"><?php echo htmlspecialchars($oferta['descripcion']); ?></p>
            </div>
            <div class="mb-4">
              <h5 class="mb-3" style="font-size: 1.3rem; color: #5bc0de;">Requisitos</h5>
              <ul class="list-unstyled text-muted fs-6">
                <li><i class="bi bi-check-circle"></i> <?php echo htmlspecialchars($oferta['presencialidad']); ?></li>
                <li><i class="bi bi-check-circle"></i> <?php echo htmlspecialchars($oferta['jornada']); ?></li>
                <li><i class="bi bi-check-circle"></i> <?php echo htmlspecialchars($oferta['tipo_contrato']); ?></li>
              </ul>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-4">
              <p class="text-muted mb-0">Inscritos: <strong><?php echo $totalInscripciones; ?></strong></p>
            </div>
          </div>
        </div>
      </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
