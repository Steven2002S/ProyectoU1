<?php
session_start();
ob_start();
require_once '../conexion/conexion.php';

$conn = ConexionManager::obtenerConexionDesdeSesion();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cedula = $_POST["cedula"];
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $direccion = $_POST["direccion"];
    $ciudad = $_POST["ciudad"];
    $telefono = $_POST["telefono"];
    $email = $_POST["email"];
    $id_habitacion = $_POST['id_habitacion'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    $precio = $_POST['precio_hidden'];
    $id_hotel = $_POST['id_hotel'];

    $sql_verificar_cliente = "SELECT id_cliente FROM cliente WHERE cedula = ?";
    $stmt_verificacion = $conn->getConexion()->prepare($sql_verificar_cliente);
    $stmt_verificacion->bind_param("s", $cedula);
    $stmt_verificacion->execute();
    $resultado_verificacion = $stmt_verificacion->get_result();

    //AQUI SE TOMA EL ID DE CLIENTE EN CASO DE QUE EXISTA EN LA BASE
    if ($resultado_verificacion->num_rows > 0) {
        $fila = $resultado_verificacion->fetch_assoc();
        $id_cliente = $fila["id_cliente"];
    } else {
    //AQUI NO SE ENCONTRO NINGUN CLIENTE POR LO QUE SE INSERTA UN NUEVO CLIENTE Y SE TOMA ESE NUEVO ID
        $sqlInsertarCliente = "INSERT INTO cliente (cedula, nombre, apellido, direccion, id_ciudad, telefono, correo_electronico)
                                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmtCliente = $conn->getConexion()->prepare($sqlInsertarCliente);
        $stmtCliente->bind_param("ssssiss", $cedula, $nombre, $apellido, $direccion, $ciudad, $telefono, $email);
        $stmtCliente->execute();
        $id_cliente = $stmtCliente->insert_id;
    }

    // APLICA LA RESERVACION
    $sql_registrar_reservacion = "CALL sp_registrar_reservacion(?, ?, ?, ?, ?, ?)";
    $stmt_reservacion = $conn->getConexion()->prepare($sql_registrar_reservacion);
    $stmt_reservacion->bind_param("iissss", $id_cliente, $id_habitacion, $fecha_inicio, $fecha_fin, $fecha_inicio, $precio);
    $stmt_reservacion->execute();

    // Redireccionar después de que todas las operaciones de la base de datos hayan concluido
    header('Location: /sistema/app/dashboard/principal.php?id_hotel=' . $id_hotel);
    ob_end_flush();
    exit; // Asegura que el script se detenga después de la redirección
}
?>
