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
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SagasetaConecta - <?php echo htmlspecialchars($oferta['titulo']); ?></title>
  <meta name="description" content="<?php echo htmlspecialchars($oferta['descripcion']); ?>">
  <link rel="icon" type="image/png" href="./assets/img/logo_size.jpg">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    html { overflow-y: scroll; }
    body { padding-right: 0; }
    .hover-effect:hover { color: #0056b3; text-decoration: underline; }
    .btn-link { font-weight: 500; }
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
          <li class="nav-item"><a class="nav-link" href="../index.php">Inicio</a></li>
          <li class="nav-item"><a class="nav-link" href="../src/ofertas.php">Ofertas de trabajo</a></li>
          <li class="nav-item"><a class="nav-link" href="../src/about.php">Nosotros</a></li>
          <li class="nav-item"><a class="nav-link" href="../src/login.php">Iniciar sesión</a></li>
          <li class="nav-item"><a class="nav-link" href="../src/register.php">Registrarme</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <main class="container my-5">
    <h1>Proceso de verificación</h1>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
