CREATE DATABASE bdd_hoteleria;

USE bdd_hoteleria;

CREATE TABLE ciudad (
  id_ciudad INT PRIMARY KEY,
  nombre varchar(100) NOT NULL
);

CREATE TABLE hotel (
    id_hotel INT AUTO_INCREMENT PRIMARY KEY,
    id_ciudad INT,
    nombre VARCHAR(100),
    direccion VARCHAR(150),
    telefono VARCHAR(10),
    correo_electronico VARCHAR(150),
    FOREIGN KEY (id_ciudad) REFERENCES ciudad (id_ciudad)
);

CREATE TABLE cliente (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,
	id_ciudad INT,
    cedula VARCHAR(10),
    nombre VARCHAR(100),
    apellido VARCHAR(100),
    direccion VARCHAR(150),
    telefono VARCHAR(10),
    correo_electronico VARCHAR(150),
    FOREIGN KEY (id_ciudad) REFERENCES ciudad(id_ciudad)
);

CREATE TABLE cargo (
  id_cargo INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(50) NOT NULL
);

CREATE TABLE empleado (
    id_empleado INT AUTO_INCREMENT PRIMARY KEY,
    id_cargo INT,
    id_hotel INT,
    nombre VARCHAR(100),
    apellido VARCHAR(100),
    fecha_contratacion DATE,
    salario DECIMAL(10, 2),
    FOREIGN KEY (id_cargo) REFERENCES cargo(id_cargo),
    FOREIGN KEY (id_hotel) REFERENCES hotel(id_hotel)
);

CREATE TABLE tipo_habitacion (
    id_tipo_habitacion INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    descripcion TEXT,
    capacidad INT,
    precio DECIMAL(10, 2)
);

CREATE TABLE habitacion (
    id_habitacion INT AUTO_INCREMENT PRIMARY KEY,
    id_tipo_habitacion INT,
    id_hotel INT,
    numero VARCHAR(10),
	disponibilidad BOOLEAN,
    FOREIGN KEY (id_tipo_habitacion) REFERENCES tipo_habitacion(id_tipo_habitacion),
    FOREIGN KEY (id_hotel) REFERENCES hotel(id_hotel)
);


CREATE TABLE reserva (
    id_reserva INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT,
    id_habitacion INT,
    fecha_inicio DATE,
    fecha_fin DATE,
    FOREIGN KEY (id_cliente) REFERENCES cliente(id_cliente),
    FOREIGN KEY (id_habitacion) REFERENCES habitacion(id_habitacion)
);

CREATE TABLE factura (
    id_factura INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT,
    id_reserva INT,
	fecha_emision DATE,
    total DECIMAL(10, 2)
);


SELECT * FROM factura

INSERT INTO ciudad (id_ciudad, nombre) VALUES (1, 'Azuay'),
(2, 'Bolivar'),
(3, 'Cañar'),
(4, 'Carchi'),
(5, 'Cotopaxi'),
(6, 'Chimborazo'),
(7, 'El Oro'),
(8, 'Esmeraldas'),
(9, 'Guayas'),
(10, 'Imbabura'),
(11, 'Loja'),
(12, 'Los Rios'),
(13, 'Manabi'),
(14, 'Morona Santiago'),
(15, 'Napo'),
(16, 'Pastaza'),
(17, 'Pichincha'),
(18, 'Tungurahua'),
(19, 'Zamora Chinchipe'),
(20, 'Galapagos'),
(21, 'Sucumbios'),
(22, 'Orellana'),
(23, 'Santo Domingo de los Tsachilas'),
(24, 'Santa Elena');


CREATE VIEW vista_info_hotel AS
SELECT
    h.id_hotel,
    h.nombre AS nombre_hotel,
    COUNT(hab.id_habitacion) AS total_habitaciones,
    SUM(CASE WHEN hab.disponibilidad = 1 THEN 1 ELSE 0 END) AS total_habitaciones_disponibles,
    SUM(CASE WHEN hab.disponibilidad = 0 THEN 1 ELSE 0 END) AS total_habitaciones_ocupadas,
    SUM(CASE WHEN DATE(res.fecha_inicio) = CURDATE() THEN 1 ELSE 0 END) AS reservaciones_hoy
FROM
    hotel h
JOIN
    habitacion hab ON h.id_hotel = hab.id_hotel
LEFT JOIN
    reserva res ON hab.id_habitacion = res.id_habitacion
GROUP BY
    h.id_hotel, h.nombre;

drop view vista_hoteles;

CREATE VIEW vista_hoteles AS
SELECT
    h.id_hotel,
    h.nombre AS nombre_hotel,
    h.direccion,
    h.telefono,
    h.correo_electronico,
    c.nombre AS nombre_ciudad,
    COUNT(r.id_reserva) AS num_reservas
FROM
    hotel h
LEFT JOIN
    habitacion hab ON h.id_hotel = hab.id_hotel
LEFT JOIN
    reserva r ON hab.id_habitacion = r.id_habitacion
LEFT JOIN
    ciudad c ON h.id_ciudad = c.id_ciudad
GROUP BY
    h.id_hotel, h.nombre, h.direccion, h.telefono, h.correo_electronico, c.nombre;


CREATE VIEW vista_clientes AS
SELECT
    c.id_cliente,
    c.cedula,
    c.nombre AS nombre_cliente,
    c.apellido,
    c.direccion,
    c.telefono,
    c.correo_electronico,
    ci.nombre AS nombre_ciudad
FROM
    cliente c
LEFT JOIN
    ciudad ci ON c.id_ciudad = ci.id_ciudad;


CREATE VIEW vista_habitaciones_disponibles AS
SELECT
    h.id_habitacion,
    th.nombre AS tipo_habitacion,
    th.capacidad,
    th.precio,
    h.numero,
    h.disponibilidad,
    h.id_hotel,
    h.id_tipo_habitacion
FROM
    habitacion h
JOIN
    tipo_habitacion th ON h.id_tipo_habitacion = th.id_tipo_habitacion
WHERE
    h.disponibilidad = 1;
    

    

CREATE VIEW vista_habitaciones_no_disponibles AS
SELECT
    h.id_habitacion,
    th.nombre AS tipo_habitacion,
    th.capacidad,
    th.precio,
    h.numero,
    h.disponibilidad,
    h.id_hotel,
    h.id_tipo_habitacion,
    c.nombre AS nombre_cliente,
    c.apellido AS apellido_cliente,
    r.fecha_fin AS fecha_fin_reserva
FROM
    habitacion h
JOIN
    tipo_habitacion th ON h.id_tipo_habitacion = th.id_tipo_habitacion
JOIN
    reserva r ON h.id_habitacion = r.id_habitacion
JOIN
    cliente c ON r.id_cliente = c.id_cliente
WHERE
    h.disponibilidad = 0;
    

CREATE VIEW vista_reservas_dia_actual AS
SELECT
    r.id_reserva,
    c.id_cliente,
    c.nombre AS nombre_cliente,
    c.apellido AS apellido_cliente,
    h.id_habitacion,
    h.numero,
    th.nombre AS tipo_habitacion,
    r.fecha_inicio,
    r.fecha_fin,
    h.id_hotel
FROM
    reserva r
JOIN
    cliente c ON r.id_cliente = c.id_cliente
JOIN
    habitacion h ON r.id_habitacion = h.id_habitacion
JOIN
    tipo_habitacion th ON h.id_tipo_habitacion = th.id_tipo_habitacion
WHERE
    DATE(r.fecha_inicio) = CURDATE() OR DATE(r.fecha_fin) = CURDATE();


CREATE VIEW vista_hab_todas AS
SELECT
    h.id_habitacion,
    th.nombre AS tipo_habitacion,
    th.capacidad,
    th.precio,
    h.numero,
    h.disponibilidad,
    h.id_hotel,
    h.id_tipo_habitacion,
    c.nombre AS nombre_cliente,
    c.apellido AS apellido_cliente,
    r.fecha_inicio,
    r.fecha_fin
FROM
    habitacion h
JOIN
    tipo_habitacion th ON h.id_tipo_habitacion = th.id_tipo_habitacion
LEFT JOIN
    reserva r ON h.id_habitacion = r.id_habitacion
LEFT JOIN
    cliente c ON r.id_cliente = c.id_cliente;

    
CREATE VIEW vista_habitaciones AS
SELECT
    h.id_habitacion,
    th.nombre AS tipo_habitacion,
    th.capacidad,
    th.precio,
    h.numero,
    h.disponibilidad,
    h.id_hotel,
    h.id_tipo_habitacion
FROM
    habitacion h
JOIN
    tipo_habitacion th ON h.id_tipo_habitacion = th.id_tipo_habitacion;

DELIMITER //

CREATE PROCEDURE registrar_reservacion(
    IN p_id_cliente INT,
    IN p_id_habitacion INT,
    IN p_fecha_inicio DATE,
    IN p_fecha_fin DATE,
    IN p_fecha_emision DATE,
    IN p_total DECIMAL(10, 2)
)
BEGIN
    DECLARE v_id_reserva INT;

    -- Registrar la reserva
    INSERT INTO reserva (id_cliente, id_habitacion, fecha_inicio, fecha_fin)
    VALUES (p_id_cliente, p_id_habitacion, p_fecha_inicio, p_fecha_fin);

    -- Obtener el ID de la reserva recién creada
    SET v_id_reserva = LAST_INSERT_ID();

    -- Agregar la factura
    INSERT INTO factura (id_cliente, id_reserva, fecha_emision, total)
    VALUES (p_id_cliente, v_id_reserva, p_fecha_emision, p_total);

    -- Actualizar disponibilidad en la tabla de habitaciones
    UPDATE habitacion
    SET disponibilidad = 0
    WHERE id_habitacion = p_id_habitacion;
END //

DELIMITER ;


SELECT * FROM vista_info_hotel WHERE hotel_id = 1;
SELECT * FROM vista_hoteles

SELECT * FROM hotel
SELECT * FROM habitacion
SELECT * FROM tipo_habitacion
SELECT * FROM cargo

SELECT * FROM reserva
SELECT * FROM cliente
SELECT * FROM vista_info_hotel;

SELECT * FROM vista_hoteles;