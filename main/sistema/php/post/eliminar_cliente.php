<?php
session_start();
require_once '../conexion/conexion.php';

$conn = ConexionManager::obtenerConexionDesdeSesion();

$id_cliente = $_POST['id_cliente'];
$query = "CALL sp_eliminar_cliente ($id_cliente);";
if ($conn->getConexion()->query($query) === TRUE) {
    echo json_encode(["status" => "success"]);
} else {
    if (strpos($conn->getConexion()->error, 'Cannot delete or update a parent row') !== false) {
        echo json_encode(["status" => "error", "message" => "No se puede eliminar el cliente porque tiene una reservacion activa."]);
    } else {
        echo json_encode(["status" => "error", "message" => $conn->getConexion()->error]);
    }
}

?>