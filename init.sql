-- 1. TABLA EXISTENTE: Mascotas
CREATE TABLE IF NOT EXISTS mascotas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    especie ENUM('perro','gato','otro') NOT NULL DEFAULT 'perro',
    raza VARCHAR(100),
    edad INT NOT NULL DEFAULT 0,
    descripcion TEXT,
    estado ENUM('disponible','en_proceso','adoptado') NOT NULL DEFAULT 'disponible',
    fecha_ingreso DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- 2. NUEVA TABLA: Usuarios (Para Requerimiento 1 y 2)
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, -- 255 caracteres para soportar el hash encriptado (password_hash)
    fecha_registro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- 3. NUEVA TABLA: Bitácora / Log (Para Requerimiento 7)
CREATE TABLE IF NOT EXISTS bitacora (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fecha_hora DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, -- Requerimiento 7.1
    usuario VARCHAR(50) NOT NULL,                           -- Requerimiento 7.2 (Nombre de usuario o 'Invitado')
    tipo ENUM(                                              -- Requerimiento 7.3
        'Creación de usuario', 
        'inicio de sesión', 
        'cierre de sesión', 
        'crear registro', 
        'modificar registro', 
        'eliminar registro', 
        'consultar registro'
    ) NOT NULL,
    detalle TEXT NOT NULL,                                  -- Requerimiento 7.4 (Tablas, IDs, etc.)
    ip_host_cliente VARCHAR(45) NOT NULL                    -- Requerimiento 7.5 (Soporta IPv4 e IPv6)
);

-- Datos de prueba para mascotas
INSERT INTO mascotas (nombre, especie, raza, edad, descripcion, estado) VALUES
('Toby', 'perro', 'Labrador', 3, 'Muy juguetón y cariñoso, ideal para familias con niños.', 'disponible'),
('Luna', 'gato', 'Siamés', 2, 'Tranquila e independiente, perfecta para departamento.', 'disponible'),
('Rocky', 'perro', 'Mestizo', 5, 'Calmado, le gustan los paseos largos.', 'en_proceso'),
('Mishi', 'gato', 'Común europeo', 1, 'Cachorrita muy activa y curiosa.', 'adoptado');

-- Usuario de prueba inicial (Usuario: admin | Contraseña: admin123)
-- La contraseña ya está encriptada con BCRYPT (la función nativa de PHP que usaremos)
INSERT INTO usuarios (username, password) VALUES
('admin', '$2y$10$eImiTxN7v/yepW4I7d6gE.f4FfU.dGZ6wKq5iZhyqVbe5wz2KGWmK');