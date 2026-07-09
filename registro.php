<?php
require_once 'conexion.php';

// Si ya está logueado, no necesita registrarse
if (isset($_SESSION['usuario'])) {
    header("Location: gestion.php");
    exit();
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        try {
            // Encriptar la contraseña usando BCRYPT (Requerimiento 1: manera encriptada)
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);

            $stmt = $pdo->prepare("INSERT INTO usuarios (username, password) VALUES (:username, :password)");
            $stmt->execute([
                ':username' => $username,
                ':password' => $passwordHash
            ]);

            // Requerimiento 7: Registrar la creación del usuario
            registrarBitacora($pdo, 'Creación de usuario', "Se creó exitosamente el usuario: $username");

            header("Location: index.php?registro=ok");
            exit();
        } catch (\PDOException $e) {
            if ($e->getCode() == 23000) { // Error de llave duplicada (nombre de usuario ya existe)
                $error = "El nombre de usuario ya está en uso.";
            } else {
                $error = "Error al registrar el usuario: " . $e->getMessage();
            }
        }
    } else {
        $error = "Por favor, completa todos los campos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - Refugio de Mascotas</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 450px; margin: 80px auto; padding: 20px; background: #f9f9f9; text-align: center; }
        .container { background: white; padding: 40px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        h1 { color: #2c3e50; margin-bottom: 25px; font-size: 2em; }
        .form-group { margin-bottom: 20px; text-align: left; }
        label { display: block; font-weight: bold; color: #555; margin-bottom: 5px; }
        input[type="text"], input[type="password"] { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; font-size: 1em; }
        .btn { width: 100%; background: #2c3e50; color: white; padding: 12px; border: none; border-radius: 5px; font-weight: bold; font-size: 1.1em; cursor: pointer; transition: background 0.2s; margin-top: 10px; }
        .btn:hover { background: #1a252f; }
        .error { color: #e74c3c; background: #fde8e7; padding: 10px; border-radius: 5px; margin-bottom: 20px; font-weight: bold; text-align: left; }
        .link { display: block; margin-top: 20px; color: #3498db; text-decoration: none; font-weight: bold; }
        .link:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <div class="container">
        <h1>Registrar Usuario</h1>

        <?php if (!empty($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form action="registro.php" method="POST">
            <div class="form-group">
                <label for="username">Nuevo Usuario:</label>
                <input type="text" id="username" name="username" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn">Crear Cuenta 👤</button>
        </form>

        <a href="index.php" class="link">Volver al Inicio de Sesión</a>
    </div>

</body>
</html>