<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (!isset($_COOKIE['user_type']) || $_COOKIE['user_type'] !== 'empresa') {
  header('Location: ../../index.php');
  exit();
}

require_once "../../database/conection.php";

if (!isset($_COOKIE['user_id'])) {
  echo "<p>Error: No se encontró el ID de la empresa en las cookies.</p>";
  exit();
}

$empresa_id = $_COOKIE['user_id'];

// Obtener familias profesionales para el dropdown
$conn = createConnection();
$query = "SELECT id, nombre FROM familia_profesional";
$stmt = $conn->prepare($query);
$stmt->execute();
$familias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crear Oferta</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
            <a class="nav-link" href="./dashboard_empresa.php">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./crear_oferta.php">Crear una oferta</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../auth/logout.php">Cerrar sesión</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container my-5">
    <h1>Crear nueva oferta de empleo</h1>
    <form action="./procesar_crear_oferta.php" method="POST">
      <input type="hidden" name="empresa_id" value="<?= htmlspecialchars($empresa_id) ?>">

      <div class="mb-3">
        <label for="titulo" class="form-label">Título del Puesto</label>
        <input type="text" class="form-control" id="titulo" name="titulo" required>
      </div>

      <div class="mb-3">
        <label for="descripcion" class="form-label">Descripción</label>
        <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required></textarea>
      </div>

      <div class="mb-3">
        <label for="ubicacion" class="form-label">Ubicación</label>
        <input type="text" class="form-control" id="ubicacion" name="ubicacion" required>
      </div>

      <div class="mb-3">
        <label for="familia_id" class="form-label">Familia Profesional</label>
        <select class="form-control" id="familia_id" name="familia_id" required>
          <?php foreach ($familias as $familia): ?>
            <option value="<?= htmlspecialchars($familia['id']) ?>"><?= htmlspecialchars($familia['nombre']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Presencialidad</label>
        <select class="form-control" name="presencialidad" required>
          <option value="Presencial">Presencial</option>
          <option value="Hibrido">Híbrido</option>
          <option value="Remoto">Remoto</option>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Jornada</label>
        <select class="form-control" name="jornada" required>
          <option value="Por horas">Por horas</option>
          <option value="Jornada completa">Jornada completa</option>
          <option value="Jornada parcial">Jornada parcial</option>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Tipo de Contrato</label>
        <select class="form-control" name="tipo_contrato" required>
          <option value="Indefinido">Indefinido</option>
          <option value="Temporal">Temporal</option>
          <option value="Por obra">Por obra</option>
        </select>
      </div>

      <button type="submit" class="btn btn-primary">Publicar Oferta</button>
    </form>
  </div>

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