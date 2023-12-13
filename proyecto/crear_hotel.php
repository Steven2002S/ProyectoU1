<?php
// Incluir la conexión a la base de datos (debes ajustar esto según tu configuración)
include('conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];

    // Insertar el nuevo hotel en la base de datos
    $sql = "INSERT INTO hoteles (nombre, direccion, telefono) VALUES ('$nombre', '$direccion', '$telefono')";
    $resultado = mysqli_query($conn, $sql);

    // Verificar si la inserción fue exitosa
    if ($resultado) {
        header("Location: hoteles.php"); // Redirigir a la página de hoteles después de crear uno nuevo
        exit();
    } else {
        echo "Error al crear el hotel: " . mysqli_error($conn);
    }
}

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>
