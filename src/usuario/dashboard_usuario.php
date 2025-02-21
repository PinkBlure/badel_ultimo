<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (!isset($_COOKIE['user_type']) || $_COOKIE['user_type'] !== 'usuario') {
  header('Location: ../../index.php');
  exit();
}

require_once "../../database/conection.php";

if (!isset($_COOKIE['user_id'])) {
  echo "<p>Error: No se encontró el ID del usuario en las cookies.</p>";
  exit();
}

$usuario_id = $_COOKIE['user_id'];

try {
  $conn = createConnection();

  if (!$conn) {
    error_log("No se pudo establecer la conexión a la base de datos.");
    exit();
  }

  // Obtener la familia profesional del usuario
  $query = "SELECT familia_profesional_id FROM usuario WHERE id = :usuario_id";
  $stmt = $conn->prepare($query);
  $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
  $stmt->execute();
  $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$usuario) {
    echo "<p>Error: No se encontró la información del usuario.</p>";
    exit();
  }

  $familia_id = $usuario['familia_profesional_id'];

  // Obtener ofertas activas de la misma familia profesional
  $query = "SELECT o.*, e.nombre AS empresa_nombre
              FROM oferta_empleo o
              JOIN empresa e ON o.empresa_id = e.id
              WHERE o.familia_id = :familia_id AND o.estado = 'Activo'
              ORDER BY o.fecha_publicacion DESC";
  $stmt = $conn->prepare($query);
  $stmt->bindParam(':familia_id', $familia_id, PDO::PARAM_INT);
  $stmt->execute();
  $ofertas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $ex) {
  error_log("Error en la base de datos: " . $ex->getMessage());
  exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SagasetaConecta - Ofertas de Empleo</title>
  <link rel="icon" type="image/png" href="../assets/img/logo_size.jpg">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    html {
      overflow-y: scroll;
    }

    body {
      padding-right: 0;
    }

    .estado-badge {
      background-color: #5bc0de;
      color: white;
      padding: 5px 10px;
      border-radius: 5px;
      font-size: 0.9rem;
      font-weight: bold;
    }
  </style>
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
    <h1>Ofertas de empleo</h1>
    <section id="ofertas-empleo" class="my-4">
      <div class="row">
        <?php if (empty($ofertas)): ?>
          <p class="alert alert-warning">No hay ofertas activas en tu área en este momento.</p>
        <?php else: ?>
          <?php foreach ($ofertas as $oferta):
            $fechaFormateada = (new DateTime($oferta['fecha_publicacion']))->format('d/m/Y');

            // Obtener número de inscripciones a la oferta
            $query = "SELECT COUNT(*) AS total_inscripciones FROM inscripcion WHERE oferta_id = :oferta_id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':oferta_id', $oferta['id'], PDO::PARAM_INT);
            $stmt->execute();
            $inscripciones = $stmt->fetch(PDO::FETCH_ASSOC);
            $totalInscripciones = $inscripciones['total_inscripciones'];

            // Verificar si el usuario ya está inscrito en esta oferta
            $queryInscripcion = "SELECT COUNT(*) AS inscripto FROM inscripcion WHERE usuario_id = :usuario_id AND oferta_id = :oferta_id";
            $stmtInscripcion = $conn->prepare($queryInscripcion);
            $stmtInscripcion->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
            $stmtInscripcion->bindParam(':oferta_id', $oferta['id'], PDO::PARAM_INT);
            $stmtInscripcion->execute();
            $inscripto = $stmtInscripcion->fetch(PDO::FETCH_ASSOC);

            // Si el usuario ya está inscrito, no mostrar el botón de postulación
            $yaInscrito = $inscripto['inscripto'] > 0;
          ?>
            <div class="col-12 mb-4">
              <div class="card h-100" style="border: 2px solid #5bc0de; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 123, 255, 0.1);">
                <a href="./oferta_detalle.php?slug=<?= urlencode($oferta['slug']) ?>" class="text-decoration-none">
                  <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #ddd; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                    <div class="d-flex flex-row justify-content-between align-items-center">
                      <h2 class="card-title text-dark" style="font-weight: 500;"><?= htmlspecialchars($oferta['titulo']) ?></h2>
                      <span class="estado-badge">Activo</span>
                    </div>
                    <div class="d-flex flex-row justify-content-between align-items-center">
                      <small class="text-muted" style="font-size: 0.9rem">Inscritos: <?= $totalInscripciones ?> - <?= $fechaFormateada ?></small>
                    </div>
                    <div class="d-flex flex-row justify-content-start align-items-center">
                      <h3 class="card-title me-2" style="color: #5bc0de;"><?= htmlspecialchars($oferta['empresa_nombre']) ?></h3>
                      <small class="text-muted">( <?= htmlspecialchars($oferta['ubicacion']) ?> )</small>
                    </div>
                  </div>
                  <div class="card-body" style="background-color: #f1f3f5;">
                    <p class="card-text text-dark" style="font-size: 1rem; line-height: 1.5;">
                      <?= htmlspecialchars(substr($oferta['descripcion'], 0, 100)) ?>...
                    </p>
                  </div>
                  <div class="card-footer" style="background-color: #e9ecef; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                    <small class="text-muted" style="font-size: 0.9rem;">
                      <?= htmlspecialchars($oferta['presencialidad']) ?> | <?= htmlspecialchars($oferta['jornada']) ?> | <?= htmlspecialchars($oferta['tipo_contrato']) ?>
                    </small>
                    <!-- Mostrar el botón solo si el usuario NO está inscrito -->
                    <?php if (!$yaInscrito): ?>
                      <a href="postular.php?oferta_id=<?= $oferta['id'] ?>" class="btn btn-primary float-end">Postularse</a>
                    <?php else: ?>
                      <span class="btn btn-secondary float-end" disabled>Ya te has postulado</span>
                    <?php endif; ?>
                  </div>
                </a>
              </div>
            </div>
          <?php endforeach; ?>

        <?php endif; ?>
      </div>
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

<?php
$conn = null;
?>