
<?php
require_once 'conexion.php';
// Colocar los siguientes comandos para arrancar la paguina: 
// sudo service mysql start
// usr/bin/php -S 127.0.0.1:8080
// Si ya tiene una sesión activa, lo mandamos directo al panel de gestión
if (isset($_SESSION['usuario'])) {
    header("Location: gestion.php");
    exit();
}

$error = "";

// Procesar el formulario de inicio de sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        // Buscar al usuario en la base de datos
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch();

        // Verificar si existe y si la contraseña coincide con el hash encriptado
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['usuario'] = $user['username'];
            
            // Requerimiento 7: Registrar inicio de sesión exitoso
            registrarBitacora($pdo, 'inicio de sesión', "Inicio de sesión exitoso.");
            
            header("Location: gestion.php");
            exit();
        } else {
            // Requerimiento 7: Registrar intento fallido (nombre de usuario intentado)
            registrarBitacora($pdo, 'inicio de sesión', "Intento fallido de inicio de sesión para el usuario: $username");
            $error = "Usuario o contraseña incorrectos.";
        }
    } else {
        $error = "Por favor, llena todos los campos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Refugio de Mascotas</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 450px; margin: 80px auto; padding: 20px; background: #f9f9f9; text-align: center; }
        .container { background: white; padding: 40px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        h1 { color: #e67e22; margin-bottom: 25px; font-size: 2em; }
        .icon { font-size: 3.5em; margin-bottom: 10px; }
        .form-group { margin-bottom: 20px; text-align: left; }
        label { display: block; font-weight: bold; color: #555; margin-bottom: 5px; }
        input[type="text"], input[type="password"] { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; font-size: 1em; }
        .btn { width: 100%; background: #e67e22; color: white; padding: 12px; border: none; border-radius: 5px; font-weight: bold; font-size: 1.1em; cursor: pointer; transition: background 0.2s; margin-top: 10px; }
        .btn:hover { background: #d35400; }
        .error { color: #e74c3c; background: #fde8e7; padding: 10px; border-radius: 5px; margin-bottom: 20px; font-weight: bold; text-align: left; }
        .msg { color: #2ecc71; background: #e8f8f0; padding: 10px; border-radius: 5px; margin-bottom: 20px; font-weight: bold; }
        .link { display: block; margin-top: 20px; color: #3498db; text-decoration: none; font-weight: bold; }
        .link:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <div class="container">
        <div class="icon">🐾</div>
        <h1>Refugio de Mascotas</h1>

        <?php if (!empty($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if (isset($_GET['registro']) && $_GET['registro'] === 'ok'): ?>
            <div class="msg">¡Usuario registrado con éxito! Ya puedes iniciar sesión.</div>
        <?php endif; ?>

        <form action="index.php" method="POST">
            <div class="form-group">
                <label for="username">Usuario:</label>
                <input type="text" id="username" name="username" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn">Ingresar 🚀</button>
        </form>

        <a href="registro.php" class="link">¿No tienes usuario? Regístrate aquí</a>
    </div>

</body>
</html> 