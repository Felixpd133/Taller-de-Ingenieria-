<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'conexion.php';

// --- CONTROL DE ACCESO ---
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

// --- PROCESAR EL FORMULARIO (OPERACIÓN: CREATE) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'crear') {
    $nombre = trim($_POST['nombre']);
    $especie = $_POST['especie'];
    $raza = trim($_POST['raza']);
    $edad = intval($_POST['edad']);
    $descripcion = trim($_POST['descripcion']);

    $sql = "INSERT INTO mascotas (nombre, especie, raza, edad, descripcion) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nombre, $especie, $raza, $edad, $descripcion]);
    
    // Requerimiento 7: Guardar en bitácora con el ID generado en la tabla 'mascotas'
    $id_nuevo = $pdo->lastInsertId();
    registrarBitacora($pdo, 'crear registro', "Se registró una nueva mascota en la tabla 'mascotas'. ID: $id_nuevo, Nombre: $nombre");

    // Redirigimos directo al módulo de consulta para ver el resultado
    header("Location: consultar.php"); 
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Mascota - Sistema de Gestión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="gestion.php"><i class="bi bi-heart-pulse-fill text-danger"></i> Refugio Mascota</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active text-white fw-bold" href="crear.php">Crear</a></li>
                    <li class="nav-item"><a class="nav-link" href="consultar.php">Consultar</a></li>
                    <li class="nav-item"><a class="nav-link" href="modificar.php">Modificar</a></li>
                    <li class="nav-item"><a class="nav-link" href="eliminar.php">Eliminar</a></li>
                    <li class="nav-item"><a class="nav-link text-warning" href="logout.php"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                
                <a href="gestion.php" class="btn btn-link link-dark p-0 mb-3 text-decoration-none fw-semibold">
                    <i class="bi bi-arrow-left"></i> Volver al Menú Principal
                </a>

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white py-3">
                        <h4 class="mb-0 fw-bold"><i class="bi bi-plus-circle"></i> Registrar Nueva Mascota</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="crear.php" method="POST">
                            <input type="hidden" name="action" value="crear">
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nombre:</label>
                                <input type="text" name="nombre" class="form-content form-control" required autocomplete="off" placeholder="Ej: Sparky">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Especie:</label>
                                <select name="especie" class="form-select">
                                    <option value="perro">Perro</option>
                                    <option value="gato">Gato</option>
                                    <option value="otro">Otro</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Raza:</label>
                                <input type="text" name="raza" class="form-control" placeholder="Ej: Quiltro, Pastor Alemán (Opcional)">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Edad (Años):</label>
                                <input type="number" name="edad" class="form-control" min="0" required placeholder="0">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Descripción:</label>
                                <textarea name="descripcion" class="form-control" rows="3" placeholder="Información sobre su temperamento, rescate, etc."></textarea>
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-success fw-bold btn-lg">💾 Guardar Registro</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>