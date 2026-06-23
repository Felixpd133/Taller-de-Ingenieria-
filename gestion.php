<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'conexion.php';

// --- OPERACIÓN: CREATE (Guardar nueva mascota) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'crear') {
    $nombre = $_POST['nombre'];
    $especie = $_POST['especie'];
    $raza = $_POST['raza'];
    $edad = $_POST['edad'];
    $descripcion = $_POST['descripcion'];

    $sql = "INSERT INTO mascotas (nombre, especie, raza, edad, descripcion) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nombre, $especie, $raza, $edad, $descripcion]);
    header("Location: gestion.php"); 
    exit;
}

// --- OPERACIÓN: DELETE (Eliminar mascota) ---
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $sql = "DELETE FROM mascotas WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    header("Location: gestion.php");
    exit;
}

// --- OPERACIÓN: READ (Consultar todas las mascotas) ---
$stmt = $pdo->query("SELECT * FROM mascotas ORDER BY fecha_ingreso DESC");
$mascotas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Mascotas</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 900px; margin: 30px auto; padding: 20px; background:#f9f9f9; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #e67e22; color: white; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        input, select, textarea { width: 100%; padding: 8px; box-sizing: border-box; }
        .btn { padding: 6px 12px; text-decoration: none; color: white; border-radius: 4px; border: none; cursor: pointer; display: inline-block; }
        .btn-add { background: #2ecc71; font-size: 16px; padding: 10px; width: 100%; }
        .btn-edit { background: #3498db; }
        .btn-delete { background: #e74c3c; }
    </style>
</head>
<body>

    <a href="index.php" style="color: #e67e22; font-weight: bold; text-decoration: none;">← Volver al Inicio</a>
    <h1>🐾 Panel de Gestión del Refugio</h1>

    <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <h2>➕ Registrar Nueva Mascota</h2>
        <form action="gestion.php" method="POST">
            <input type="hidden" name="action" value="crear">
            <div class="form-group">
                <label>Nombre:</label>
                <input type="text" name="nombre" required>
            </div>
            <div class="form-group">
                <label>Especie:</label>
                <select name="especie">
                    <option value="perro">Perro</option>
                    <option value="gato">Gato</option>
                    <option value="otro">Otro</option>
                </select>
            </div>
            <div class="form-group">
                <label>Raza:</label>
                <input type="text" name="raza">
            </div>
            <div class="form-group">
                <label>Edad (Años):</label>
                <input type="number" name="edad" min="0" required>
            </div>
            <div class="form-group">
                <label>Descripción:</label>
                <textarea name="descripcion" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-add">Registrar Mascota</button>
        </form>
    </div>

    <h2>📋 Mascotas Alojadas</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Especie</th>
                <th>Raza</th>
                <th>Edad</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($mascotas as $mascota): ?>
            <tr>
                <td><?php echo $mascota['id']; ?></td>
                <td><strong><?php echo htmlspecialchars($mascota['nombre']); ?></strong></td>
                <td><?php echo htmlspecialchars($mascota['especie']); ?></td>
                <td><?php echo htmlspecialchars($mascota['raza'] ?: 'Sin raza'); ?></td>
                <td><?php echo $mascota['edad']; ?> años</td>
                <td>
                    <span style="padding: 3px 8px; border-radius: 12px; font-size: 0.9em; color: white; background: <?php 
                        echo $mascota['estado'] === 'disponible' ? '#2ecc71;' : ($mascota['estado'] === 'en_proceso' ? '#f1c40f;' : '#95a5a6;'); 
                    ?>">
                        <?php echo $mascota['estado']; ?>
                    </span>
                </td>
                <td>
                    <a href="editar.php?id=<?php echo $mascota['id']; ?>" class="btn btn-edit">✏️ Editar</a>
                    <a href="gestion.php?eliminar=<?php echo $mascota['id']; ?>" class="btn btn-delete" onclick="return confirm('¿Seguro que quieres borrar esta mascota?')">🗑️ Borrar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>
