<?php
// Conexión a la base de datos
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'animeflv';

// Crear la conexión
$conn = new mysqli($host, $user, $pass, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los últimos comentarios
$sql = "SELECT c.comentario, c.fecha_comentario, u.nombre_usuario FROM comentarios c JOIN usuarios u ON c.id_usuario = u.id ORDER BY c.fecha_comentario DESC LIMIT 10";
$result = $conn->query($sql);

echo "<h1>Bienvenidos a AnimeFLV</h1>";
echo "<h2>Últimos comentarios:</h2>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<p><strong>" . $row['nombre_usuario'] . "</strong> (" . $row['fecha_comentario'] . "): " . $row['comentario'] . "</p>";
    }
} else {
    echo "<p>No hay comentarios aún.</p>";
}

$conn->close();
?>
