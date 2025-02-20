<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../database/conection.php";

if (isset($_COOKIE['user_type']) && $_COOKIE['user_type'] === 'centro') {
  header('Location: ./centro/dashboard_centro.php');
  exit();
}

if (isset($_COOKIE['user_type']) && $_COOKIE['user_type'] === 'empresa') {
  header('Location: ./empresa/dashboard_empresa.php');
  exit();
}

if (isset($_COOKIE['user_type']) && $_COOKIE['user_type'] === 'usuario') {
  header('Location: ./usuario/dashboard_empresa.php');
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SagasetaConecta - Ofertas</title>
  <link rel="icon" type="image/png" href="./assets/img/logo_size.jpg">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

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
    <img src="./assets/img/logo_size_long.jpg" alt="Logo" class="img-fluid w-70 w-md-50 w-lg-25 mx-auto d-block">
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
            <a class="nav-link" href="../index.php">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="../src/ofertas.php">Ofertas de trabajo</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../src/about.php">Nosotros</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../src/login.php">Iniciar sesión</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../src/register.php">Registrarme</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <main class="container my-5">

    <section id="ofertas">
      <h1 class="mb-4">Ofertas de trabajo</h1>
      <div class="row">
        <?php
        try {
          $conn = createConnection();

          if (!$conn) {
            error_log("No se pudo establecer la conexión a la base de datos.");
            exit();
          }

          $query = "SELECT * FROM oferta_empleo WHERE verificado=1 AND estado='activo' ORDER BY fecha_publicacion DESC";
          $stmt = $conn->prepare($query);
          $stmt->execute();
          $ofertas = $stmt->fetchAll(PDO::FETCH_ASSOC);

          if (empty($ofertas)) {
            echo "<p>Todavía no hay ofertas, vuelve más tarde.<p>";
          } else {
            foreach ($ofertas as $oferta) {

              $fechaOriginal = new DateTime($oferta['fecha_publicacion']);
              $fechaFormateada = $fechaOriginal->format('d/m/Y');

              $query = "SELECT nombre FROM empresa WHERE id = :empresa_id";
              $stmt = $conn->prepare($query);
              $stmt->bindParam(':empresa_id', $oferta['empresa_id']);
              $stmt->execute();
              $empresa = $stmt->fetchAll(PDO::FETCH_ASSOC);

              $query = "SELECT count(1) AS total_inscripciones FROM inscripcion WHERE oferta_id = :oferta_id";
              $stmt = $conn->prepare($query);
              $stmt->bindParam(':oferta_id', $oferta['id']);
              $stmt->execute();
              $inscripciones = $stmt->fetch(PDO::FETCH_ASSOC);
              $totalInscripciones = $inscripciones['total_inscripciones'];

              if (empty($empresa)) {
                error_log("No se ha podido encontrar la empresa.");
                exit();
              } else {
                echo '
  <div class="col-12 mb-4">
    <div class="card h-100" style="border: 2px solid #5bc0de; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 123, 255, 0.1);">
      <a href="./detalle.php?slug=' . urlencode($oferta['slug']) . '" class="text-decoration-none">
        <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #ddd; border-top-left-radius: 10px; border-top-right-radius: 10px;">
          <div class="d-flex flex-row justify-content-between align-items-center">
            <h2 class="card-title text-dark" style="font-weight: 500;">' . htmlspecialchars($oferta['titulo']) . '</h2>
            <small class="text-muted" style="font-size: 0.9rem">' . 'Inscritos: ' .  $totalInscripciones . ' - ' .  $fechaFormateada . '</small>
          </div>
          <div class="d-flex flex-row justify-content-start align-items-center">
            <h3 class="card-title me-2" style="color: #5bc0de;">' . $empresa[0]['nombre'] . '</h3>
            <small class="text-muted">( ' . htmlspecialchars($oferta['ubicacion']) . ' )</small>
          </div>
        </div>
        <div class="card-body" style="background-color: #f1f3f5;">
          <p class="card-text text-dark" style="font-size: 1rem; line-height: 1.5;">' . htmlspecialchars($oferta['descripcion']) . '</p>
        </div>
        <div class="card-footer" style="background-color: #e9ecef; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
          <small class="text-muted" style="font-size: 0.9rem;">' . htmlspecialchars($oferta['presencialidad']) . ' | ' . htmlspecialchars($oferta['jornada']) . ' | ' . htmlspecialchars($oferta['tipo_contrato']) . '</small>
        </div>
      </a>
    </div>
  </div>
';
              }
            }
          }
        } catch (PDOException $ex) {
          error_log("Error al conectar con la base de datos: " . $ex->getMessage());
          exit();
        } finally {
          $conn = null;
        }
        ?>
    </section>

  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
