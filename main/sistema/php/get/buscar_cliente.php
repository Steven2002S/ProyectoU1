<?php
session_start();
ob_start();
require_once '../conexion/conexion.php';

$conn = ConexionManager::obtenerConexionDesdeSesion();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

$cedulaBusqueda = $_POST['cedula'];

$sql = "SELECT * FROM cliente WHERE cedula = '$cedulaBusqueda'";
$result = $conn->getConexion()->query($sql);

if ($result->num_rows > 0) {
    $cliente = $result->fetch_assoc();
    $response = array(
        'success' => true,
        'cliente' => array(
            'cedula' => $cliente['cedula'],
            'nombre' => $cliente['nombre'],
            'apellido' => $cliente['apellido'],
            'direccion' => $cliente['direccion'],
            'ciudad' => $cliente['id_ciudad'],
            'telefono' => $cliente['telefono'],
            'email' => $cliente['correo_electronico'],
        ),
    );
} else {
    $response = array('success' => false);
}

header('Content-Type: application/json');
echo json_encode($response);
}



?>