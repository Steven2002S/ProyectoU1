<?php
session_start();
require_once '../conexion/conexion.php';

$conn = ConexionManager::obtenerConexionDesdeSesion();

if(isset($_GET['id_empleado']) && !empty(trim($_GET['id_empleado']))){

    $query = "CALL sp_eliminar_empleado (?)";

    if($stmt = $conn->getConexion()->prepare($query)){
        $stmt->bind_param('i',$_GET['id_empleado']);
        if($stmt->execute()){
            header("location: /main/sistema/app/vistas/vista_empleado.php");
            exit();
        }
    }
    $stmt ->close();
}


?>