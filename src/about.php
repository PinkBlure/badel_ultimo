<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../database/conection.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SagasetaConecta - Nosotros</title>
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

<body class="d-flex flex-column min-vh-100">

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
            <a class="nav-link" href="../src/ofertas.php">Ofertas de trabajo</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="../src/about.php">Nosotros</a>
          </li>
          <?php
          if (isset($_COOKIE['user_type'])) {
            echo '
                <li class="nav-item">
                  <a class="nav-link" href="./auth/logout.php">
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

    <div class="d-flex justify-content-start align-items-center my-4">
      <a href="#sagaseta_video" class="btn btn-link text-decoration-none text-dark fs-5 hover-effect" style="margin: 0; padding: 0;">
        <i class="bi bi-film" style="color: #5bc0de;"></i> Video promocional
      </a>
      <span class="mx-3 text-muted">•</span>
      <a href="#informacion_centro" class="btn btn-link text-decoration-none text-dark fs-5 hover-effect" style="margin: 0; padding: 0;">
        <i class="bi bi-info-circle" style="color: #5bc0de;"></i> Información del centro
      </a>
    </div>

    <section id="sagaseta_video" class="container my-5">
      <h1 class="mb-3">IES Fernando Sagaseta</h1>
      <div class="position-relative">
        <iframe width="100%" height="500px"
          src="https://www.youtube.com/embed/_WMRlm0Ahc4"
          title="IES Fernando Sagaseta"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
          allowfullscreen>
        </iframe>
      </div>
      <p class="mt-3 text-muted text-center">
        Este es un video promocional para IESFS, que muestra sus características y ofertas.
      </p>
    </section>


    <section id="informacion_centro" class="my-4">
      <h1>Oferta Formativa del IES Fernando Sagaseta</h1>
      <p>El <strong style="color: #5bc0de;">IES Fernando Sagaseta</strong> es un centro educativo de referencia en la isla de Gran Canaria, comprometido con la formación académica y profesional de sus estudiantes. A través de una amplia y variada oferta educativa, el instituto prepara a los alumnos para enfrentar los retos del mundo laboral con un enfoque práctico, dinámico y actualizado.</p>
      <p>El centro ofrece ciclos formativos de <strong style="color: #5bc0de;">Formación Profesional (FP)</strong>, tanto de Grado Medio como de Grado Superior, que cubren diversas áreas del conocimiento. Los programas formativos del IES Fernando Sagaseta están diseñados para proporcionar a los estudiantes las competencias necesarias para su integración en el mercado laboral, de acuerdo con las demandas actuales de las empresas.</p>
      <p>Entre los ciclos más destacados del centro, se incluyen especialidades en sectores como <strong style="color: #5bc0de;">Imagen Personal, Informática y Comunicaciones, Madera, Mueble y Corcho</strong>, y muchos otros que se adaptan a las necesidades del entorno productivo y empresarial. Además, el IES Fernando Sagaseta es conocido por su enfoque innovador y por integrar a los estudiantes en actividades formativas que simulan escenarios profesionales reales, lo que les permite obtener una visión más completa y actualizada de su futura profesión.</p>
      <p>Una de las características más destacadas de este instituto es su entorno cercano y familiar, donde los estudiantes reciben una atención personalizada que facilita su desarrollo académico y personal. Los docentes son profesionales altamente capacitados que trabajan en conjunto con los alumnos, fomentando su crecimiento intelectual, técnico y humano.</p>
      <p>En cuanto a la <strong style="color: #5bc0de;">orientación laboral</strong>, el IES Fernando Sagaseta mantiene una estrecha colaboración con diversas empresas e instituciones para garantizar que sus programas educativos estén alineados con las necesidades del mercado laboral. Además, los exalumnos cuentan con la posibilidad de acceder a una bolsa de empleo exclusiva que les conecta directamente con oportunidades laborales en las áreas de su formación.</p>
      <p>El centro también se distingue por su <strong style="color: #5bc0de;">compromiso con la calidad educativa</strong>, respaldado por un ambiente moderno, instalaciones adecuadas para la enseñanza práctica y una infraestructura digital que permite a los estudiantes acceder a recursos actualizados para su aprendizaje.</p>
      <p>En resumen, el IES Fernando Sagaseta es un <strong style="color: #5bc0de;">referente educativo en Gran Canaria</strong>, ofreciendo una formación de calidad, orientada a la empleabilidad y al desarrollo integral de sus estudiantes. Gracias a su oferta formativa, el instituto se ha consolidado como un pilar fundamental en la preparación de jóvenes para su futuro profesional, contribuyendo así al crecimiento de la comunidad laboral en la isla.</p>
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
