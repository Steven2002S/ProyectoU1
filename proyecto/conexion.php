<?php
$servername = "localhost";
$username = "root";
$password = "2002";
$dbname = "hoteles";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

echo "Conectado exitosamente";


// Función para obtener clientes
function obtenerClientes() {
    global $conn;
    $sql = "SELECT * FROM clientes";
    $result = $conn->query($sql);

    $clientes = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $clientes[] = $row;
        }
    }

    return $clientes;
}
?>

?>
