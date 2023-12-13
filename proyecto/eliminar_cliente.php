<?php
include 'conexion.php';

// Verificar si se proporcionó un ID de cliente
if (isset($_GET['id'])) {
    $idCliente = $_GET['id'];
    eliminarCliente($idCliente);
}

// Redireccionar a la página principal después de eliminar
header("Location: index.php");
exit();
?>
