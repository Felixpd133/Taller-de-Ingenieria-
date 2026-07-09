<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'conexion.php';

// --- CONTROL DE ACCESO (Seguridad del Sistema) ---
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

$mascota = null;

// Obtener datos de la mascota por ID
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $pdo->prepare("SELECT * FROM mascotas WHERE id = ?");
    $stmt->execute([$id]);
    $mascota = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$mascota) {
        die("Mascota no encontrada en el sistema.");
    }
}

// --- OPERACIÓN: UPDATE (Actualizar datos) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $nombre = trim($_POST['nombre']);
    $especie = $_POST['especie'];
    $raza = trim($_POST['raza']);
    $edad = intval($_POST['edad']);
    $descripcion = trim($_POST['descripcion']);
    $estado = $_POST['estado'];

    $sql = "UPDATE mascotas SET nombre=?, especie=?, raza=?, edad=?, descripcion=?, estado=? WHERE id=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nombre, $especie, $raza, $edad, $descripcion, $estado, $id]);
    
    // Requerimiento 7: Guardar en bitácora la modificación detallada del registro
    registrarBitacora($pdo, 'modificar registro', "Se modificó el registro con ID: $id en la tabla 'mascotas'. Nombre: $nombre, Estado: $estado");

    header("Location: gestion.php");
    exit;
}

// Si no se pasó un ID por GET y tampoco es POST, regresar a gestión
if (!$mascota) {
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
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 80px auto 30px auto; padding: 20px; background:#f9f9f9; }
        
        /* ESTILOS DEL MENÚ PRINCIPAL (Mantiene consistencia) */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #2c3e50;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            z-index: 1000;
        }
        .navbar ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
        }
        .navbar a {
            display: block;
            color: white;
            text-align: center;
            padding: 15px 25px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.2s;
        }
        .navbar a:hover {
            background-color: #e67e22;
        }
        .navbar .logout-menu {
            background-color: #c0392b;
        }
        .navbar .logout-menu:hover {
            background-color: #962d22;
        }

        /* ESTILOS DEL FORMULARIO */
        .form-group { margin-bottom: 15px; text-align: left; }
        label { display: block; font-weight: bold; margin-bottom: 5px; color: #555; }
        input, select, textarea { width: 100%; padding: 10px; box-sizing: border-box; border: 1px solid #ddd; border-radius: 4px; font-size: 1em; }
        .btn { padding: 12px 15px; color: white; border-radius: 4px; border: none; cursor: pointer; background: #3498db; font-size: 16px; width: 100%; font-weight: bold; transition: background 0.2s; margin-top: 10px;}
        .btn:hover { background: #2980b9; }
        .welcome-user { float: right; color: #555; font-weight: bold; margin-top: 10px; }
    </style>
</head>
<body>

    <nav class="navbar">
        <ul>
            <li><a href="gestion.php#crear">Crear</a></li>
            <li><a href="gestion.php#consultar">Consultar</a></li>
            <li><a href="gestion.php#consultar">Modificar</a></li>
            <li><a href="gestion.php#consultar">Eliminar</a></li>
            <li><a href="logout.php" class="logout-menu">Cerrar sesión</a></li>
        </ul>
    </nav>

    <div class="welcome-user">👤 Usuario: <?= htmlspecialchars($_SESSION['usuario']) ?></div>
    <a href="gestion.php" style="color: #3498db; font-weight: bold; text-decoration: none;">← Volver al Panel</a>
    
    <h1>✏️ Editar Ficha de: <?php echo htmlspecialchars($mascota['nombre']); ?></h1>
    <hr>

    <div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <form action="editar.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $mascota['id']; ?>">

            <div class="form-group">
                <label>Nombre:</label>
                <input type="text" name="nombre" value="<?php echo htmlspecialchars($mascota['nombre']); ?>" required autocomplete="off">
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
                <label>Edad (Años):</label>
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

            <button type="submit" class="btn">Guardar Cambios 💾</button>
        </form>
    </div>

</body>
</html> 
