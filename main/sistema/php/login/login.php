<?php

ob_start();
require_once '../conexion/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["usuario"];
    $password = $_POST["contrasena"];

    try {
        $conn = new ConexionMySQL("172.20.0.3", $username, $password, "bdd_hoteleria");
        if ($conn->getConexion() !== null) {
            ConexionManager::guardarConexionEnSesion("172.20.0.3", $username, $password, "bdd_hoteleria");
            header('Location: /sistema/app/vistas/vista_inicio.php');
            exit();
        } else {
            $_SESSION["conexion"]['login_error'] = "Credenciales incorrectas";
            header('Location: /sistema/index.php');
            exit();
        }
    } catch (mysqli_sql_exception $e) {
        $_SESSION["conexion"]['login_error'] = "Error de conexión: " . $e->getMessage();
        header('Location: /sistema/index.php');
        //echo "Error de conexión: " . $e->getMessage();
        exit();
    }
} else {

}
ob_end_flush();
?>
