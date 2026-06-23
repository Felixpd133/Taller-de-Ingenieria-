<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM mascotas WHERE id = ?");
    $stmt->execute([$id]);
    $mascota = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$mascota) {
        die("Mascota no encontrada en el sistema.");
    }
}

// --- OPERACIÓN: UPDATE (Actualizar datos) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $especie = $_POST['especie'];
    $raza = $_POST['raza'];
    $edad = $_POST['edad'];
    $descripcion = $_POST['descripcion'];
    $estado = $_POST['estado'];

    $sql = "UPDATE mascotas SET nombre=?, especie=?, raza=?, edad=?, descripcion=?, estado=? WHERE id=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nombre, $especie, $raza, $edad, $descripcion, $estado, $id]);
    
    header("Location: gestion.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Mascota</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 30px auto; padding: 20px; background:#f9f9f9; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        input, select, textarea { width: 100%; padding: 8px; box-sizing: border-box; }
        .btn { padding: 10px 15px; color: white; border-radius: 4px; border: none; cursor: pointer; background: #3498db; font-size: 16px; width: 100%;}
    </style>
</head>
<body>

    <a href="gestion.php" style="color: #3498db; font-weight: bold; text-decoration: none;">← Volver al Panel</a>
    <h1>✏️ Editar Ficha de: <?php echo htmlspecialchars($mascota['nombre']); ?></h1>

    <form action="editar.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $mascota['id']; ?>">

        <div class="form-group">
            <label>Nombre:</label>
            <input type="text" name="nombre" value="<?php echo htmlspecialchars($mascota['nombre']); ?>" required>
        </div>

        <div class="form-group">
            <label>Especie:</label>
            <select name="especie">
                <option value="perro" <?php echo $mascota['especie'] === 'perro' ? 'selected' : ''; ?>>Perro</option>
                <option value="gato" <?php echo $mascota['especie'] === 'gato' ? 'selected' : ''; ?>>Gato</option>
                <option value="otro" <?php echo $mascota['especie'] === 'otro' ? 'selected' : ''; ?>>Otro</option>
            </select>
        </div>

        <div class="form-group">
            <label>Raza:</label>
            <input type="text" name="raza" value="<?php echo htmlspecialchars($mascota['raza']); ?>">
        </div>

        <div class="form-group">
            <label>Edad:</label>
            <input type="number" name="edad" value="<?php echo $mascota['edad']; ?>" min="0" required>
        </div>

        <div class="form-group">
            <label>Estado de Adopción:</label>
            <select name="estado" style="background-color: #fef9f5; font-weight: bold; color: #e67e22;">
                <option value="disponible" <?php echo $mascota['estado'] === 'disponible' ? 'selected' : ''; ?>>Disponible</option>
                <option value="en_proceso" <?php echo $mascota['estado'] === 'en_proceso' ? 'selected' : ''; ?>>En Proceso</option>
                <option value="adoptado" <?php echo $mascota['estado'] === 'adoptado' ? 'selected' : ''; ?>>Adoptado</option>
            </select>
        </div>

        <div class="form-group">
            <label>Descripción:</label>
            <textarea name="descripcion" rows="4"><?php echo htmlspecialchars($mascota['descripcion']); ?></textarea>
        </div>

        <button type="submit" class="btn">Guardar Cambios</button>
    </form>

</body>
</html>