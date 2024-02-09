
<?php

function getHotelInfo($conn, $id_hotel) {
    $sql = "SELECT * FROM vista_info_hotel WHERE id_hotel = ?";
    $stmt = $conn->getConexion()->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $id_hotel);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
       
    } else {
        die("Error en la preparación de la consulta: " . $conn->getConexion()->error);
    }
}


function getHoteles($conn) {
    $sql = "SELECT * FROM vista_hoteles";
    $result1 = $conn->getConexion()->query($sql);

    if ($result1 && $result1->num_rows > 0) {
        $hoteles = array();
        while ($row = $result1->fetch_assoc()) {
            $hoteles[] = $row;
        }
     
        return $hoteles;
    } else {
        if ($result1) {
           
        }
        return array();
    }
}



?>

