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

// Obtenemos todas las mascotas para poder elegir cuál modificar
$stmt = $pdo->query("SELECT * FROM mascotas ORDER BY id DESC");
$mascotas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Mascota - Sistema de Gestión</title>
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
                    <li class="nav-item"><a class="nav-link" href="crear.php">Crear</a></li>
                    <li class="nav-item"><a class="nav-link" href="consultar.php">Consultar</a></li>
                    <li class="nav-item"><a class="nav-link active text-white fw-bold" href="modificar.php">Modificar</a></li>
                    <li class="nav-item"><a class="nav-link" href="eliminar.php">Eliminar</a></li>
                    <li class="nav-item"><a class="nav-link text-warning" href="logout.php"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <a href="gestion.php" class="btn btn-link link-dark p-0 mb-3 text-decoration-none fw-semibold">
            <i class="bi bi-arrow-left"></i> Volver al Menú Principal
        </a>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-warning text-dark py-3">
                <h4 class="mb-0 fw-bold"><i class="bi bi-pencil-square"></i> Seleccionar Mascota para Modificar</h4>
            </div>
            <div class="card-body p-4">
                
                <p class="text-muted mb-4">Busca la mascota que deseas actualizar y haz clic en el botón <strong>Editar</strong> ubicado a la derecha de la fila.</p>

                <?php if (count($mascotas) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Especie</th>
                                    <th>Raza</th>
                                    <th>Edad</th>
                                    <th>Estado</th>
                                    <th class="text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($mascotas as $mascota): ?>
                                    <tr>
                                        <td class="fw-bold"><?php echo $mascota['id']; ?></td>
                                        <td><?php echo htmlspecialchars($mascota['nombre']); ?></td>
                                        <td><span class="badge bg-secondary text-capitalize"><?php echo htmlspecialchars($mascota['especie']); ?></span></td>
                                        <td><?php echo htmlspecialchars($mascota['raza'] ?: '---'); ?></td>
                                        <td><?php echo $mascota['edad']; ?> años</td>
                                        <td>
                                            <?php 
                                            $badge_color = 'bg-info';
                                            if ($mascota['estado'] === 'disponible') $badge_color = 'bg-success';
                                            if ($mascota['estado'] === 'en_proceso') $badge_color = 'bg-warning text-dark';
                                            if ($mascota['estado'] === 'adoptado') $badge_color = 'bg-danger';
                                            ?>
                                            <span class="badge <?php echo $badge_color; ?> text-capitalize">
                                                <?php echo str_replace('_', ' ', $mascota['estado']); ?>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="editar.php?id=<?php echo $mascota['id']; ?>" class="btn btn-sm btn-warning fw-semibold px-3">
                                                <i class="bi bi-pencil"></i> Editar
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning mb-0 text-center" role="alert">
                        <i class="bi bi-exclamation-triangle-fill fs-4 d-block mb-2"></i>
                        No hay registros disponibles para modificar en este momento.
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>