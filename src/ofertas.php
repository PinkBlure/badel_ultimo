<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../database/conection.php";

$conn = createConnection();
if (!$conn) {
  error_log("No se pudo establecer la conexión a la base de datos.");
  exit();
}

$ofertas_por_pagina = 5;
$pagina_actual = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$inicio = ($pagina_actual - 1) * $ofertas_por_pagina;

// Obtener total de ofertas activas y verificadas
$query_total = "SELECT COUNT(*) AS total FROM oferta_empleo WHERE verificado=1 AND estado='activo'";
$stmt = $conn->prepare($query_total);
$stmt->execute();
$total_ofertas = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
$total_paginas = ceil($total_ofertas / $ofertas_por_pagina);

// Obtener las ofertas de la página actual
$query = "SELECT * FROM oferta_empleo WHERE verificado=1 AND estado='activo' 
          ORDER BY fecha_publicacion DESC LIMIT :inicio, :limite";
$stmt = $conn->prepare($query);
$stmt->bindParam(':inicio', $inicio, PDO::PARAM_INT);
$stmt->bindParam(':limite', $ofertas_por_pagina, PDO::PARAM_INT);
$stmt->execute();
$ofertas = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    .card {
      overflow: hidden;
    }
  </style>
</head>

<body class="d-flex flex-column min-vh-100">

  <header class="container text-center py-3">
    <img src="./assets/img/logo_size_long.jpg" alt="Logo" class="img-fluid w-70 w-md-50 w-lg-25 mx-auto d-block">
  </header>

  <nav class="navbar navbar-expand-md navbar-dark bg-dark" aria-label="Header">
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
          <?php
          if (isset($_COOKIE['user_type'])) {
            if (isset($_COOKIE['user_type']) === 'usuario') {
              echo '
                  <li class="nav-item">
                    <a class="nav-link" href="../src/usuario/dashboard_usuario.php">
                      Dashboard
                    </a>
                  </li>
                ';
            } elseif (isset($_COOKIE['user_type']) === 'empresa') {
              echo '
                  <li class="nav-item">
                    <a class="nav-link" href="../src/empresa/dashboard_empresa.php">
                      Dashboard
                    </a>
                  </li>
                ';
            } elseif (isset($_COOKIE['user_type']) === 'centro') {
              echo '
                  <li class="nav-item">
                    <a class="nav-link" href="../src/centro/dashboard_centro.php">
                      Dashboard
                    </a>
                  </li>
                ';
            }
            echo '
                <li class="nav-item">
                  <a class="nav-link" href="../src/auth/logout.php">
                    Cerrar sesión
                  </a>
                </li>
              ';
          } else {
            echo '
                <li class="nav-item">
                  <a class="nav-link" href="../src/login.php">Iniciar sesión</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="../src/register.php">Registrarme</a>
                </li>
              ';
          }
          ?>
        </ul>
      </div>
    </div>
  </nav>

  <main class="container my-5">
    <section id="ofertas">
      <h1 class="mb-4">Ofertas de trabajo</h1>
      <div class="row">
        <?php
        if (empty($ofertas)) {
          echo "<p>Todavía no hay ofertas, vuelve más tarde.</p>";
        } else {
          foreach ($ofertas as $oferta) {
            $fechaFormateada = (new DateTime($oferta['fecha_publicacion']))->format('d/m/Y');

            // Obtener el nombre de la empresa
            $stmt = $conn->prepare("SELECT nombre FROM empresa WHERE id = :empresa_id");
            $stmt->bindParam(':empresa_id', $oferta['empresa_id']);
            $stmt->execute();
            $empresa = $stmt->fetch(PDO::FETCH_ASSOC);

            // Contar inscripciones
            $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM inscripcion WHERE oferta_id = :oferta_id");
            $stmt->bindParam(':oferta_id', $oferta['id']);
            $stmt->execute();
            $totalInscripciones = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

            echo '
              <div class="col-12 mb-4">
                <div class="card h-100" style="border: 2px solid #5bc0de; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 123, 255, 0.1);">
                  <a href="./detalle.php?slug=' . urlencode($oferta['slug']) . '" class="text-decoration-none">
                    <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #ddd;">
                      <div class="d-flex justify-content-between align-items-center">
                        <h2 class="card-title text-dark" style="font-weight: 500;">' . htmlspecialchars($oferta['titulo']) . '</h2>
                        <small class="text-muted" style="font-size: 0.9rem">Inscritos: ' .  $totalInscripciones . ' - ' .  $fechaFormateada . '</small>
                      </div>
                      <div class="d-flex align-items-center">
                        <h3 class="card-title me-2" style="color: #5bc0de;">' . htmlspecialchars($empresa['nombre']) . '</h3>
                        <small class="text-muted">( ' . htmlspecialchars($oferta['ubicacion']) . ' )</small>
                      </div>
                    </div>
                    <div class="card-body" style="background-color: #f1f3f5;">
                      <p class="card-text text-dark" style="font-size: 1rem; line-height: 1.5;">' . htmlspecialchars($oferta['descripcion']) . '</p>
                    </div>
                    <div class="card-footer" style="background-color: #e9ecef;">
                      <small class="text-muted" style="font-size: 0.9rem;">' . htmlspecialchars($oferta['presencialidad']) . ' | ' . htmlspecialchars($oferta['jornada']) . ' | ' . htmlspecialchars($oferta['tipo_contrato']) . '</small>
                    </div>
                  </a>
                </div>
              </div>';
          }
        }
        ?>
      </div>

      <nav aria-label="Paginación">
        <ul class="pagination justify-content-center mt-4">
          <?php if ($pagina_actual > 1): ?>
            <li class="page-item">
              <a class="page-link" href="?page=<?php echo $pagina_actual - 1; ?>"
                style="color: #5bc0de; border-color: #5bc0de;">Anterior</a>
            </li>
          <?php endif; ?>

          <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
            <li class="page-item <?php echo ($i == $pagina_actual) ? 'active' : ''; ?>">
              <a class="page-link" href="?page=<?php echo $i; ?>"
                style="<?php echo ($i == $pagina_actual) ? 'background-color: #5bc0de; border-color: #5bc0de; color: white;' : 'color: #5bc0de; border-color: #5bc0de;'; ?>">
                <?php echo $i; ?>
              </a>
            </li>
          <?php endfor; ?>

          <?php if ($pagina_actual < $total_paginas): ?>
            <li class="page-item">
              <a class="page-link" href="?page=<?php echo $pagina_actual + 1; ?>"
                style="color: #5bc0de; border-color: #5bc0de;">Siguiente</a>
            </li>
          <?php endif; ?>
        </ul>
      </nav>

    </section>
  </main>

  <?php $conn = null; ?>

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
            <li><a href="../index.php" class="text-light">Inicio</a></li>
            <li><a href="../src/ofertas.php" class="text-light">Ofertas de trabajo</a></li>
            <li><a href="../src/about.php" class="text-light">Nosotros</a></li>
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
          <a href="../src/assets/pdf/Política de Privacidad.pdf" class="text-light" target="_blank">Política de privacidad</a> |
          <a href="../src/assets/pdf/Términos y Condiciones de Uso.pdf" class="text-light" target="_blank">Términos y condiciones</a>
        </p>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
