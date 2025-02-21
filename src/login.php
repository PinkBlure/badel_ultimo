<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../database/conection.php";

if (isset($_COOKIE['user_type'])) {
  header('Location: ../index.php');
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
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SagasetaConecta - Iniciar Sesión</title>
  <link rel="icon" type="image/png" href="./assets/img/logo_size.jpg">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

    .form-container {
      display: none;
    }

    .btn-custom {
      background-color: #5bc0de;
      color: white;
      border: none;
      padding: 12px 24px;
      font-size: 16px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      max-width: 70%;
      margin: 0 auto;
      transition: transform 0.3s ease;
    }

    .btn-custom:hover {
      background-color: #4ba6b3;
    }

    .active-circle {
      background-color: #5bc0de;
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
            <a class="nav-link" href="../src/about.php">Nosotros</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="../src/login.php">Iniciar sesión</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../src/register.php">Registrarme</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <main class="container my-5">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <h1 class="text-center">Inicio de sesión</h1>
            <p class="text-center my-4">Quiero iniciar sesión como...</p>

            <?php
            if (isset($_GET['error'])) {
              $error_message = htmlspecialchars($_GET['error']);
              echo "<div class='alert alert-danger' role='alert'>{$error_message}</div>";
            }
            ?>

            <?php
            if (isset($_GET['success'])) {
              echo "<div class='alert alert-success' role='alert'>" . htmlspecialchars($_GET['success']) . "</div>";
            }
            ?>

            <div class="d-grid gap-3 mb-5">
              <button class="btn w-100" style="background-color: #5bc0de; color: white; border: none; padding: 12px 24px; font-size: 16px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); max-width: 70%; margin: 0 auto; transition: transform 0.3s ease;" id="empresa-btn">
                Empresa
              </button>
              <button class="btn w-100" style="background-color: #5bc0de; color: white; border: none; padding: 12px 24px; font-size: 16px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); max-width: 70%; margin: 0 auto; transition: transform 0.3s ease;" id="usuario-btn">
                Usuario
              </button>
              <button class="btn w-100" style="background-color: #5bc0de; color: white; border: none; padding: 12px 24px; font-size: 16px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); max-width: 70%; margin: 0 auto; transition: transform 0.3s ease;" id="centro-btn">
                Centro
              </button>
            </div>
            <div class="form-container" id="empresa-form">
              <h3 class="text-center">Iniciar sesión como empresa</h3>
              <form action="./auth/authempresa.php" method="POST">
                <input type="cif" name="cif" class="form-control mb-3" placeholder="CIF de la empresa">
                <input type="password" name="pass" class="form-control mb-3" placeholder="Contraseña">
                <button type="submit" class="btn mx-auto d-block" style="background-color: #5bc0de; color: white; border: none; padding: 12px 24px; font-size: 16px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); max-width: 70%; margin: 0 auto; transition: transform 0.3s ease;">Iniciar sesión</button>
              </form>
            </div>
            <div class="form-container" id="usuario-form">
              <h3 class="text-center">Iniciar sesión como usuario</h3>
              <form action="./auth/authusuario.php" method="POST">
                <input type="dni" name="dni" class="form-control mb-3" placeholder="DNI">
                <input type="password" name="pass" class="form-control mb-3" placeholder="Contraseña">
                <button type="submit" class="btn mx-auto d-block" style="background-color: #5bc0de; color: white; border: none; padding: 12px 24px; font-size: 16px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); max-width: 70%; margin: 0 auto; transition: transform 0.3s ease;">Iniciar sesión</button>
              </form>
            </div>
            <div class="form-container" id="centro-form">
              <h3 class="text-center">Iniciar sesión como centro</h3>
              <form action="./auth/authcentro.php" method="POST">
                <input type="email" name="email" class="form-control mb-3" placeholder="Correo electrónico">
                <input type="password" name="pass" class="form-control mb-3" placeholder="Contraseña">
                <button type="submit" class="btn mx-auto d-block" style="background-color: #5bc0de; color: white; border: none; padding: 12px 24px; font-size: 16px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); max-width: 70%; margin: 0 auto; transition: transform 0.3s ease;">Iniciar sesión</button>
              </form>
            </div>
          </div>
          <div class="card-footer text-center">
            <div class="d-flex justify-content-center gap-3">
              <div class="rounded-circle border" style="width: 1rem; height: 1rem; background-color: #5bc0de;"></div>
              <div id="circle" class="rounded-circle border" style="width: 1rem; height: 1rem;"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script>
    $(document).ready(function() {
      $('#empresa-btn').click(function() {
        $('#empresa-form').slideToggle();
        $('#usuario-form').slideUp();
        $('#centro-form').slideUp();
        $('#circle').addClass('active-circle');
      });

      $('#usuario-btn').click(function() {
        $('#usuario-form').slideToggle();
        $('#empresa-form').slideUp();
        $('#centro-form').slideUp();
        $('#circle').addClass('active-circle');
      });

      $('#centro-btn').click(function() {
        $('#centro-form').slideToggle();
        $('#empresa-form').slideUp();
        $('#usuario-form').slideUp();
        $('#circle').addClass('active-circle');
      });
    });
  </script>

  <footer class="bg-dark text-light py-4 mt-auto">
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
