<?php
$nombres = [
    "Vicente Salazar",
    "Benjamin Poblete",
    "Felipe Pino"
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refugio de Mascotas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 40px auto;
            padding: 0 20px;
            background-color: #f5f5f5;
            color: #333;
        }
        h1 {
            color: #e67e22;
            border-bottom: 3px solid #e67e22;
            padding-bottom: 10px;
        }
        h2 {
            color: #2c3e50;
            margin-top: 30px;
        }
        .descripcion, .crud, .integrantes, .mockup {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        .crud-item {
            margin: 10px 0;
            padding: 10px;
            border-left: 4px solid #e67e22;
            background-color: #fef9f5;
        }
        .crud-item span {
            font-weight: bold;
            color: #e67e22;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        ul li {
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        ul li:last-child {
            border-bottom: none;
        }
        ul li::before {
            content: "🐾 ";
        }
        .mockup img {
            max-width: 100%;
            border-radius: 6px;
            border: 1px solid #ddd;
            display: block;
            margin: 15px auto 0;
        }
        .mockup .caption {
            text-align: center;
            font-style: italic;
            color: #777;
            font-size: 0.9em;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1>🐶 Sistema de Gestión - Refugio de Mascotas</h1>

    <!-- DESCRIPCIÓN DE LA APLICACIÓN -->
    <div class="descripcion">
        <h2>📋 Descripción de la Aplicación</h2>
        <p>
            La aplicación es un sistema web de gestión para un refugio de mascotas.
            Permite administrar el registro de animales alojados en el refugio, incluyendo
            datos como <strong>nombre, especie, raza, edad, descripción</strong> y
            <strong>estado de adopción</strong>.
        </p>
        <p>
            Una de sus funcionalidades más importantes es la <strong>actualización del estado
            de adopción</strong> de cada mascota (disponible, en proceso o adoptada), facilitando
            así el seguimiento y control de los animales dentro del refugio.
        </p>
    </div>

    <!-- OPERACIONES CRUD -->
    <div class="crud">
        <h2>⚙️ Operaciones CRUD</h2>
        <div class="crud-item">
            <span>CREATE —</span> Registrar una nueva mascota en el sistema, ingresando datos
            como nombre, especie, raza, edad, descripción y estado de adopción inicial.
        </div>
        <div class="crud-item">
            <span>READ —</span> Consultar y listar todas las mascotas registradas, con la
            posibilidad de filtrar por estado de adopción, especie o raza.
        </div>
        <div class="crud-item">
            <span>UPDATE —</span> Actualizar la información de una mascota, siendo la operación
            más relevante el cambio de estado de adopción
            (disponible → en proceso → adoptada).
        </div>
        <div class="crud-item">
            <span>DELETE —</span> Eliminar el registro de una mascota del sistema cuando ya
            no se encuentre en el refugio.
        </div>
    </div>

    <!-- MOCKUP DE LA INTERFAZ -->
    <div class="mockup">
        <h2>🎨 Mockup de la Interfaz Principal</h2>
        <p>
            A continuación se muestra la interfaz principal de la aplicación, donde el usuario
            puede visualizar todas las mascotas registradas y acceder a las operaciones CRUD
            desde el menú superior.
        </p>
        <img src="mockup.png" alt="Mockup de la interfaz principal del refugio de mascotas">
        <div class="caption">Vista principal del sistema con listado de mascotas y acciones disponibles.</div>
    </div>

    <!-- INTEGRANTES -->
    <div class="integrantes">
        <h2>👥 Integrantes del Equipo</h2>
        <ul>
            <?php foreach ($nombres as $nombre): ?>
                <li><?php echo htmlspecialchars($nombre); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
