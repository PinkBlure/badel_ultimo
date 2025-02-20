<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (!isset($_COOKIE['user_type']) || $_COOKIE['user_type'] !== 'centro') {
  header('Location: ../../index.php');
  exit();
}

require_once "../../database/conection.php";
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SagasetaConecta - Dashboard</title>
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
            <a class="nav-link" href="./dashboard_centro.php">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./listado_empresas.php">Lista de empresas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./listado_ofertas.php">Lista de empresas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./listado_usuarios.php">Lista de empresas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../auth/logout.php">Cerrar sesión</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <main class="container my-5">
    <h1>Listado de usuarios no verificados</h1>
    <?php
    try {
      $conn = createConnection();
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $query = "SELECT id, nombre, dni, cial, email FROM usuario WHERE verificado = 0";
      $stmt = $conn->prepare($query);
      $stmt->execute();

      $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $ex) {
      echo "Error al obtener los usuarios: " . $ex->getMessage();
    }
    ?>

    <?php if ($usuarios): ?>
      <div class="row">
        <?php foreach ($usuarios as $usuario): ?>
          <div class="col-12 mb-4">
            <div class="card h-100" style="border: 2px solid #5bc0de; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 123, 255, 0.1);">
              <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($usuario['nombre']); ?></h5>
                <p class="card-text"><strong>DNI:</strong> <?php echo htmlspecialchars($usuario['dni']); ?></p>
                <p class="card-text"><strong>CIAL:</strong> <?php echo htmlspecialchars($usuario['cial']); ?></p>
                <p class="card-text"><strong>Email:</strong> <?php echo htmlspecialchars($usuario['email']); ?></p>
                <form action="../assets/function/cambiar_estado_verificado_usuario.php" method="POST">
                  <input type="hidden" name="usuario_id" value="<?php echo $usuario['id']; ?>">
                  <button type="submit" class="btn" style="background-color: #5bc0de;">Verificar</button>
                </form>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <p class="mt-3">No hay usuarios no verificados.</p>
    <?php endif; ?>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
