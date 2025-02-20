<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../database/conection.php";
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SagasetaConecta - Registro de usuario</title>
  <link rel="icon" type="image/png" href="../assets/img/logo_size.jpg">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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
            <a class="nav-link active" href="./index.php">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./src/ofertas.php">Ofertas de trabajo</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./src/about.php">Nosotros</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./src/login.php">Iniciar sesión</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./src/register.php">Registrarme</a>
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
            <h1 class="text-center">Registro de usuario</h1>
            <p class="text-center my-3">Completa los datos para registrarte</p>

            <?php
            if (isset($_GET['error'])) {
              echo "<div class='alert alert-danger' role='alert'>" . htmlspecialchars($_GET['error']) . "</div>";
            }
            ?>

            <form action="./function_registro_usuario.php" method="POST">
              <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" required>
              </div>

              <div class="mb-3">
                <label for="dni" class="form-label">DNI</label>
                <input type="text" name="dni" class="form-control" required>
              </div>

              <div class="mb-3">
                <label for="cial" class="form-label">CIAL</label>
                <input type="text" name="cial" class="form-control" required>
              </div>

              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
              </div>

              <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control" required>
              </div>

              <div class="mb-3">
                <label for="familia_profesional_id" class="form-label">Familia Profesional</label>
                <select name="familia_profesional_id" class="form-control" required>
                  <option value="">Selecciona una familia</option>
                  <option value="1">Imagen personal</option>
                  <option value="2">Informática y comunicaciones</option>
                  <option value="3">Madera, mueble y corcho</option>
                </select>
              </div>

              <button type="submit" class="btn btn-primary w-100">Registrar Usuario</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
