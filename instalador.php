<?php
// Conexión a la base de datos
$host = 'localhost'; // o el host de tu base de datos
$user = 'root'; // usuario de la base de datos
$pass = ''; // contraseña de la base de datos
$dbname = 'animeflv'; // nombre de la base de datos

// Crear la conexión
$conn = new mysqli($host, $user, $pass);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Crear la base de datos
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "Base de datos creada correctamente.<br>";
} else {
    echo "Error al crear la base de datos: " . $conn->error . "<br>";
}

// Seleccionar la base de datos
$conn->select_db($dbname);

// Crear tablas
$sql = "
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    contraseña VARCHAR(255) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS administradores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    contraseña VARCHAR(255) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS comentarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_video INT NOT NULL,
    comentario TEXT NOT NULL,
    fecha_comentario TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);
";

// Ejecutar la creación de las tablas
if ($conn->multi_query($sql)) {
    echo "Tablas creadas correctamente.<br>";
} else {
    echo "Error al crear tablas: " . $conn->error . "<br>";
}

// Insertar administrador predeterminado (solo para instalación inicial)
$admin_usuario = 'admin';
$admin_email = 'admin@animeflv.com';
$admin_contraseña = password_hash('admin123', PASSWORD_DEFAULT);

$sql_admin = "INSERT INTO administradores (nombre_usuario, email, contraseña) VALUES ('$admin_usuario', '$admin_email', '$admin_contraseña')";
if ($conn->query($sql_admin) === TRUE) {
    echo "Administrador creado correctamente.<br>";
} else {
    echo "Error al crear administrador: " . $conn->error . "<br>";
}

$conn->close();
?>
