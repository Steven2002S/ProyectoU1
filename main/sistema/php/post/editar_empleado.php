<?php
session_start();
ob_start();
require_once '../conexion/conexion.php';

$conn = ConexionManager::obtenerConexionDesdeSesion();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger valores del formulario

    $id_empleado = $_POST["id_empleado_editar"];
    $cargo = strtoupper(trim($_POST["cargo_editar"]));
    $nombre = strtoupper(trim($_POST["nombre_editar"]));
    $apellido = strtoupper(trim($_POST["apellido_editar"]));
    $fecha = $_POST["fecha_editar"];
    $salario = $_POST["salario_editar"];

    $id_hotel = $_POST['id_hotel'];

    // Insertar datos en la tabla Hotel
    $sqlEmpleado = "CALL sp_actualizar_empleado ('$id_empleado', '$cargo', '$nombre', '$apellido', '$fecha', '$salario')";

    if ($conn->getConexion()->query($sqlEmpleado) === TRUE) {
        $hotelId = $conn->getConexion()->insert_id;  // Obtener el ID del hotel recién insertado
        echo json_encode(["status" => "success"]);
        header('Location: /sistema/app/vistas/vista_empleado.php?id_hotel='.$id_hotel.'');
        b_end_flush();
        //echo "Registro exitoso";
    } else {
        echo json_encode(["status" => "error", "message" => $conn->getConexion()->error]);
    }

}
?>