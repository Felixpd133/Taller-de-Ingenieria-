<?php
// Forzar a PHP a mostrar cualquier error en pantalla
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio - Refugio de Mascotas</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            max-width: 800px; 
            margin: 50px auto; 
            padding: 20px; 
            text-align: center; 
            background: #f9f9f9; 
        }
        .container { 
            background: white; 
            padding: 40px; 
            border-radius: 8px; 
            box-shadow: 0 4px 6px rgba(0,0,0,0.1); 
            margin-top: 30px;
        }
        h1 { color: #e67e22; font-size: 2.5em; margin-bottom: 10px; }
        p { color: #555; font-size: 1.2em; line-height: 1.6; max-width: 600px; margin: 20px auto; }
        .btn { 
            display: inline-block; 
            background: #e67e22; 
            color: white; 
            padding: 15px 30px; 
            text-decoration: none; 
            border-radius: 5px; 
            font-weight: bold; 
            font-size: 1.2em; 
            margin-top: 20px; 
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
            transition: background 0.2s;
        }
        .btn:hover { background: #d35400; }
        .icon { font-size: 4em; margin-bottom: 10px; }
    </style>
</head>
<body>

    <div class="container">
        <div class="icon">🐾</div>
        <h1>Refugio de Mascotas</h1>
        <p>Bienvenido al sistema de administración. Desde aquí podrás registrar los animales que ingresan al refugio, actualizar sus fichas médicas y controlar sus estados de adopción.</p>
        
        <a href="gestion.php" class="btn">🚀 Ingresar al Panel de Gestión</a>
    </div>

</body>
</html>