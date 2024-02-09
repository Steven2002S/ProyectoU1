<?php
session_start();
ob_start();
require_once '../conexion/conexion.php';

$conn = ConexionManager::obtenerConexionDesdeSesion();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger valores del formulario

    $id_cliente = $_POST["id_cliente_editar"];
    $nombre = strtoupper(trim($_POST["nombre_editar"]));
    $apellido = strtoupper(trim($_POST["apellido_editar"]));
    $direccion = strtoupper(trim($_POST["direccion_editar"]));
    $ciudad = $_POST["ciudad_editar"];
    $telefono = $_POST["telefono_editar"];
    $email = $_POST["email_editar"];

    $id_hotel = $_POST['id_hotel'];

    $sqlCliente = "CALL sp_actualizar_cliente ('$id_cliente', '$nombre', '$apellido', '$direccion', '$ciudad', '$telefono', '$email')";

    if ($conn->getConexion()->query($sqlCliente)) {

        header('Location: /sistema/app/vistas/vista_cliente.php?id_hotel='.$id_hotel.'');
        ob_end_flush();
        //echo "Registro exitoso";
    } else {
        echo "Error: " . $sqlCliente . "<br>" . $conn->getConexion()->error;
    }
}
?>