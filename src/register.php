<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../database/conection.php";

if (isset($_COOKIE['user_type'])) {
  if ($_COOKIE['user_type'] === 'centro') {
    header('Location: ./centro/dashboard_centro.php');
    exit();
  } elseif ($_COOKIE['user_type'] === 'empresa') {
    header('Location: ./empresa/dashboard_empresa.php');
    exit();
  } elseif ($_COOKIE['user_type'] === 'usuario') {
    header('Location: ./usuario/dashboard_usuario.php');
    exit();
  }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SagasetaConecta - Registro</title>
  <link rel="icon" type="image/png" href="./assets/img/logo_size.jpg">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    html {
      overflow-y: scroll;
    }

    body {
      padding-right: 0;
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
            <a class="nav-link" href="../src/ofertas.php">Ofertas de trabajo</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../src/about.php">Nosotros</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../src/login.php">Iniciar sesión</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="../src/register.php">Registrarme</a>
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
            <h1 class="text-center">Registro</h1>
            <p class="text-center my-4">Quiero registrarme como...</p>

            <?php
            if (isset($_GET['error'])) {
              $error_message = htmlspecialchars($_GET['error']);
              echo "<div class='alert alert-danger' role='alert'>{$error_message}</div>";
            }
            ?>

            <div class="d-grid gap-3 mb-5">
              <a class="btn w-100" style="background-color: #5bc0de; color: white; border: none; padding: 12px 24px; font-size: 16px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); max-width: 70%; margin: 0 auto; transition: transform 0.3s ease;" id="empresa-btn" href="./auth/registerempresa.php">
                Empresa
              </a>
              <a class="btn w-100" style="background-color: #5bc0de; color: white; border: none; padding: 12px 24px; font-size: 16px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); max-width: 70%; margin: 0 auto; transition: transform 0.3s ease;" id="usuario-btn" href="./auth/registerusuario.php">
                Usuario
              </a>
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
</body>

</html>
