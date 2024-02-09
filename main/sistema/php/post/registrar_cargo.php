<?php
session_start();
ob_start();
require_once '../conexion/conexion.php';

$conn = ConexionManager::obtenerConexionDesdeSesion();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger valores del formulario

    $cargo = strtoupper(trim($_POST["cargo"]));

    $id_hotel = $_POST['id_hotel'];


    // Insertar datos en la tabla Hotel
    $sql = "CALL sp_insertar_cargo ('$cargo')";

    if ($conn->getConexion()->query($sql)) {

        header('Location: /sistema/app/vistas/vista_empleado.php?id_hotel='.$id_hotel.'');
        ob_end_flush();

        //echo "Registro exitoso";
    } else {
        echo "Error: " . $sqlEmpleado . "<br>" . $conn->getConexion()->error;
    }
}
?>