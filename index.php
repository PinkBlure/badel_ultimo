<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "./database/conection.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SagasetaConecta - Inicio</title>
  <link rel="icon" type="image/png" href="./src/assets/img/logo_size.jpg">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
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

<body class="d-flex flex-column min-vh-100">

  <header class="container text-center py-3">
    <img src="./src/assets/img/logo_size_long.jpg" alt="Logo" class="img-fluid w-70 w-md-50 w-lg-25 mx-auto d-block">
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
            <a class="nav-link active" href="./index.php">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./src/ofertas.php">Ofertas de trabajo</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./src/about.php">Nosotros</a>
          </li>
          <?php
          if (isset($_COOKIE['user_type'])) {
            if (isset($_COOKIE['user_type']) === 'usuario') {
              echo '
                  <li class="nav-item">
                    <a class="nav-link" href="./src/usuario/dashboard_usuario.php">
                      Dashboard
                    </a>
                  </li>
                ';
            } elseif (isset($_COOKIE['user_type']) === 'empresa') {
              echo '
                  <li class="nav-item">
                    <a class="nav-link" href="./src/empresa/dashboard_empresa.php">
                      Dashboard
                    </a>
                  </li>
                ';
            } elseif (isset($_COOKIE['user_type']) === 'centro') {
              echo '
                  <li class="nav-item">
                    <a class="nav-link" href="./src/centro/dashboard_centro.php">
                      Dashboard
                    </a>
                  </li>
                ';
            }
            echo '
                <li class="nav-item">
                  <a class="nav-link" href="./src/auth/logout.php">
                    Cerrar sesión
                  </a>
                </li>
              ';
          } else {
            echo '
                <li class="nav-item">
                  <a class="nav-link" href="./src/login.php">Iniciar sesión</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="./src/register.php">Registrarme</a>
                </li>
              ';
          }
          ?>
        </ul>
      </div>
    </div>
  </nav>

  <main class="container my-5">

    <div class="d-flex justify-content-start align-items-center my-4">
      <a href="#informacion-bolsa" class="btn btn-link text-decoration-none text-dark fs-5 hover-effect" style="margin: 0; padding: 0;">
        <i class="bi bi-info-circle" style="color: #5bc0de;"></i> Información
      </a>
      <span class="mx-3 text-muted">•</span>
      <a href="#ofertas-empleo" class="btn btn-link text-decoration-none text-dark fs-5 hover-effect" style="margin: 0; padding: 0;">
        <i class="bi bi-briefcase" style="color: #5bc0de;"></i> Ofertas
      </a>
    </div>

    <section id="informacion-bolsa" class="my-4">
      <h1>Bolsa de Empleo del IES Fernando Sagaseta</h1>
      <p>La bolsa de empleo del IES Fernando Sagaseta está <strong style="color: #5bc0de;">destinada exclusivamente a los exalumnos de este centro educativo</strong>. Su propósito es facilitar el acceso a ofertas de trabajo para aquellos que han completado sus estudios en el instituto.</p>
      <p>El IES Fernando Sagaseta es un centro educativo de referencia, conocido por su compromiso con la formación académica y profesional de sus estudiantes. Ubicado en <strong style="color: #5bc0de;">Valle de Jinamar, Las Palmas, España</strong>, ofrece una amplia gama de programas formativos en diversas áreas.</p>
      <p>Es importante señalar que las ofertas de empleo que se publican en esta bolsa son accesibles únicamente para los exalumnos del IES Fernando Sagaseta. Los interesados en postular a las ofertas deben demostrar que han cursado sus estudios en el centro y <strong style="color: #5bc0de;">serán verificados</strong> según los datos proporcionados por el centro educativo.</p>
    </section>

    <section id="ofertas-empleo" class="my-4">
      <h1>Últimas ofertas de empleo</h1>
      <p>Aquí se mostrarán las últimas ofertas de empleo disponibles para los exalumnos del IES Fernando Sagaseta.</p>

      <div class="row">
        <?php

        try {
          $conn = createConnection();

          if (!$conn) {
            error_log("No se pudo establecer la conexión a la base de datos.");
            exit();
          }

          $query = "SELECT * FROM oferta_empleo WHERE verificado=1 ORDER BY fecha_publicacion DESC limit 3";
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
                      <a href="./src/detalle.php?slug=' . urlencode($oferta['slug']) . '" class="text-decoration-none">
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
                        <p class="card-text text-dark" style="font-size: 1rem; line-height: 1.5;">' . mb_strimwidth(htmlspecialchars($oferta['descripcion']), 0, 100, '...') . '</p>
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
            <li><a href="./index.php" class="text-light">Inicio</a></li>
            <li><a href="./src/ofertas.php" class="text-light">Ofertas de trabajo</a></li>
            <li><a href="./src/about.php" class="text-light">Nosotros</a></li>
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
          <a href="./src/assets/pdf/Política de Privacidad.pdf" class="text-light" target="_blank">Política de privacidad</a> |
          <a href="./src/assets/pdf/Términos y Condiciones de Uso.pdf" class="text-light" target="_blank">Términos y condiciones</a>
        </p>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
