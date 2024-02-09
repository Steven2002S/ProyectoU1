<?php
session_start();
ob_start();
require_once '../conexion/conexion.php';

$conn = ConexionManager::obtenerConexionDesdeSesion();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger valores del formulario

    $cargo = strtoupper(trim($_POST["cargo"]));
    $nombre = strtoupper(trim($_POST["nombre"]));
    $apellido = strtoupper(trim($_POST["apellido"]));
    $fecha = $_POST["fecha"];
    $salario = $_POST["salario"];
    $id_hotel = $_POST['id_hotel'];

    // Insertar datos en la tabla Hotel
    $sqlEmpleado = "CALL sp_insertar_empleado ('$cargo', '$id_hotel', '$nombre', '$apellido', '$fecha', '$salario')";

    if ($conn->getConexion()->query($sqlEmpleado)) {

        header('Location: /sistema/app/vistas/vista_empleado.php?id_hotel='.$id_hotel.'');
        ob_end_flush();

        //echo "Registro exitoso";
    } else {
        echo "Error: " . $sqlEmpleado . "<br>" . $conn->getConexion()->error;
    }

}
?>