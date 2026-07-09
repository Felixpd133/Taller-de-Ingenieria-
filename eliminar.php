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

// --- PROCESAR LA ELIMINACIÓN (OPERACIÓN: DELETE) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'eliminar') {
    $id_eliminar = intval($_POST['id']);

    // 1. Obtener el nombre antes de borrarlo para dejar un registro detallado en la bitácora
    $stmt_info = $pdo->prepare("SELECT nombre FROM mascotas WHERE id = ?");
    $stmt_info->execute([$id_eliminar]);
    $mascota = $stmt_info->fetch(PDO::FETCH_ASSOC);
    $nombre_mascota = $mascota ? $mascota['nombre'] : 'Desconocido';

    // 2. Eliminar el registro real
    $sql = "DELETE FROM mascotas WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_eliminar]);

    // Requerimiento 7: Guardar en bitácora el evento con el ID y el nombre de la mascota dada de baja
    registrarBitacora($pdo, 'eliminar registro', "Se eliminó permanentemente la mascota del sistema. ID: $id_eliminar, Nombre: $nombre_mascota");

    // Redireccionar a la misma página con un parámetro de éxito
    header("Location: eliminar.php?status=success");
    exit();
}

// Obtener la lista actualizada de mascotas
$stmt = $pdo->query("SELECT * FROM mascotas ORDER BY id DESC");
$mascotas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Mascota - Sistema de Gestión</title>
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
                    <li class="nav-item"><a class="nav-link" href="modificar.php">Modificar</a></li>
                    <li class="nav-item"><a class="nav-link active text-white fw-bold" href="eliminar.php">Eliminar</a></li>
                    <li class="nav-item"><a class="nav-link text-warning" href="logout.php"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <a href="gestion.php" class="btn btn-link link-dark p-0 mb-3 text-decoration-none fw-semibold">
            <i class="bi bi-arrow-left"></i> Volver al Menú Principal
        </a>

        <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> ¡Mascota eliminada correctamente y evento registrado en la bitácora!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-danger text-white py-3">
                <h4 class="mb-0 fw-bold"><i class="bi bi-trash"></i> Eliminar Registros de Mascotas</h4>
            </div>
            <div class="card-body p-4">
                
                <p class="text-danger fw-semibold mb-4"><i class="bi bi-exclamation-triangle"></i> Atención: Las eliminaciones son definitivas. Una vez presionado el botón, el registro se borrará permanentemente de la base de datos.</p>

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
                                            <form action="eliminar.php" method="POST" onsubmit="return confirm('¿Estás absolutamente seguro de que deseas eliminar a <?php echo htmlspecialchars($mascota['nombre']); ?>? Esta acción no se puede deshacer.');">
                                                <input type="hidden" name="id" value="<?php echo $mascota['id']; ?>">
                                                <input type="hidden" name="action" value="eliminar">
                                                <button type="submit" class="btn btn-sm btn-danger fw-semibold px-3">
                                                    <i class="bi bi-trash3-fill"></i> Eliminar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-secondary mb-0 text-center" role="alert">
                        <i class="bi bi-folder-x fs-4 d-block mb-2"></i>
                        No quedan registros de mascotas para eliminar en el sistema.
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
