<?php

    $global_id_hotel;

    function setIdHotel($variable){
        global $global_id_hotel;
        $global_id_hotel = $variable;
    }

    function getIdHotel(){
        global $global_id_hotel;
        return $global_id_hotel;
    }

?>
