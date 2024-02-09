<?php

class ConexionMySQL {
    private $conexion;

    public function __construct($host, $usuario, $password, $baseDatos) {
        $this->conexion = new mysqli($host, $usuario, $password, $baseDatos);

        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }

        $this->conexion->set_charset("utf8");
    }

    public function getConexion() {
        return $this->conexion;
    }

    public function cerrarConexion() {
        if ($this->conexion) {
            $this->conexion->close();
        }
    }
}

class ConexionManager {
    public static function guardarConexionEnSesion($host, $username, $password, $database) {
        session_start();
        $_SESSION['conexion'] = array(
            'host' => $host,
            'username' => $username,
            'password' => $password,
            'database' => $database
        );
    }

    public static function obtenerConexionDesdeSesion() {
        //session_start();
        if (isset($_SESSION['conexion'])) {
            $conexionInfo = $_SESSION['conexion'];
            return new ConexionMySQL($conexionInfo['host'], $conexionInfo['username'], $conexionInfo['password'], $conexionInfo['database']);
        }
        return null;
    }
}


?>


