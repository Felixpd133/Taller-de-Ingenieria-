<?php
// 1. Proteger la página: Si no hay sesión, rebota al login
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refugio de Mascotas - Menú Principal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8f9fa; }
        .navbar-brand { font-weight: bold; }
        .card-menu { transition: transform 0.2s; cursor: pointer; }
        .card-menu:hover { transform: translateY(-5px); box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="gestion.php"><i class="bi bi-heart-pulse-fill text-danger"></i> Refugio Mascota</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link text-white fw-semibold" href="crear.php">Crear</a></li>
                    <li class="nav-item"><a class="nav-link" href="consultar.php">Consultar</a></li>
                    <li class="nav-item"><a class="nav-link" href="modificar.php">Modificar</a></li>
                    <li class="nav-item"><a class="nav-link" href="eliminar.php">Eliminar</a></li>
                    <li class="nav-item"><a class="nav-link text-warning" href="logout.php"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="row mb-4">
            <div class="col text-center">
                <h1 class="display-5 fw-bold">Bienvenido al Sistema de Gestión</h1>
                <p class="lead text-muted">Hola, <strong><?php echo htmlspecialchars($_SESSION['usuario']); ?></strong>. Selecciona una operación desde el menú superior o los accesos directos de abajo.</p>
            </div>
        </div>

        <div class="row g-4 justify-content-center">
            <div class="col-md-5 col-lg-3">
                <div class="card h-100 text-center card-menu border-primary" onclick="location.href='crear.php'">
                    <div class="card-body py-4">
                        <i class="bi bi-plus-circle-fill text-primary display-4"></i>
                        <h5 class="card-title mt-3 fw-bold">Crear</h5>
                        <p class="card-text text-muted small">Registrar una nueva mascota en el refugio.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-5 col-lg-3">
                <div class="card h-100 text-center card-menu border-success" onclick="location.href='consultar.php'">
                    <div class="card-body py-4">
                        <i class="bi bi-search text-success display-4"></i>
                        <h5 class="card-title mt-3 fw-bold">Consultar</h5>
                        <p class="card-text text-muted small">Ver el listado completo de mascotas alojadas.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-5 col-lg-3">
                <div class="card h-100 text-center card-menu border-warning" onclick="location.href='modificar.php'">
                    <div class="card-body py-4">
                        <i class="bi bi-pencil-square text-warning display-4"></i>
                        <h5 class="card-title mt-3 fw-bold">Modificar</h5>
                        <p class="card-text text-muted small">Actualizar la información de una mascota existente.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-5 col-lg-3">
                <div class="card h-100 text-center card-menu border-danger" onclick="location.href='eliminar.php'">
                    <div class="card-body py-4">
                        <i class="bi bi-trash-fill text-danger display-4"></i>
                        <h5 class="card-title mt-3 fw-bold">Eliminar</h5>
                        <p class="card-text text-muted small">Dar de baja o quitar registros del sistema.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
