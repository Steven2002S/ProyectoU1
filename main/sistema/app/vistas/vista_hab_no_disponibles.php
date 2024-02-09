<?php

session_start();

require_once  ('../.././php/get/datos_hotel.php');
require_once  ('../.././php/conexion/conexion.php');
require_once  ('../.././php/config/config.php');

/*if(getIdHotel() !== null){
    $hotelId = getIdHotel();
}*/
// Iniciar la sesión

$conn = ConexionManager::obtenerConexionDesdeSesion();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ID del hotel deseado
    if (isset($_POST['hotel'])) {
        $id_hotel= $_POST['hotel'];
    }
} else {
    if (isset($_GET['id_hotel'])) {
        $id_hotel = $_GET['id_hotel'];
    } else {
        $id_hotel = "N/D";
    }
}

// Obtener información del hotel
$hotel_info = getHotelInfo($conn, $id_hotel);

// Verificar si se encontraron resultados
if ($hotel_info) {
    // Guardar los datos en variables
    $hotel_id = $hotel_info["hotel_id"];
    $nombre_hotel = $hotel_info["nombre_hotel"];
    $total_habitaciones = $hotel_info["total_habitaciones"];
    $habitaciones_disponibles = $hotel_info["total_habitaciones_disponibles"];
    $habitaciones_ocupadas = $hotel_info["total_habitaciones_ocupadas"];
    $reservaciones_hoy = $hotel_info["reservaciones_hoy"];
} else {
    $hotel_id = "N/D";
    $nombre_hotel = "N/D";
    $total_habitaciones = "N/D";
    $habitaciones_disponibles = "N/D";
    $habitaciones_ocupadas = "N/D";
    $reservaciones_hoy = "N/D";
}

$sql_vhd = "SELECT * FROM vista_habitaciones_no_disponibles WHERE id_hotel = $id_hotel";
$result_vhd = $conn->getConexion()->query($sql_vhd);


?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Sistema Web</title>
        <link href="../.././css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
	</head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="../dashboard/principal.php?id_hotel=<?php echo $id_hotel; ?>"> <?php echo $nombre_hotel ?></a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button
			>
            <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $nombre_hotel." - ". strtoupper($_SESSION['conexion']['username']); ?><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#">Configuración</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="../.././php/config/logout.php">Salir</a>
					</div>
				</li>
			</ul>
		</nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <a class="nav-link" href="../dashboard/principal.php?id_hotel=<?php echo $id_hotel; ?>"
							><div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard</a
							>
							
							<?php if(false) { ?>
								
								<div class="sb-sidenav-menu-heading">Interface</div>
								<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts"
								><div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
									Layouts
									<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div
									></a>
									<div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
										<nav class="sb-sidenav-menu-nested nav"><a class="nav-link" href="layout-static.html">Static Navigation</a><a class="nav-link" href="layout-sidenav-light.html">Light Sidenav</a></nav>
									</div>
									<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages"
									><div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
										Pages
										<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div
										></a>
										<div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
											<nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
												<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth"
												>Authentication
													<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div
													></a>
													<div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
														<nav class="sb-sidenav-menu-nested nav"><a class="nav-link" href="login.html">Login</a><a class="nav-link" href="register.html">Register</a><a class="nav-link" href="password.html">Forgot Password</a></nav>
													</div>
													<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError"
													>Error
														<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div
														></a>
														<div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
															<nav class="sb-sidenav-menu-nested nav"><a class="nav-link" href="401.html">401 Page</a><a class="nav-link" href="404.html">404 Page</a><a class="nav-link" href="500.html">500 Page</a></nav>
														</div>
											</nav>
										</div>
										
							<?php } ?>
							
							<div class="sb-sidenav-menu-heading">Personal</div>
							<a class="nav-link" href="vista_cliente.php?id_hotel=<?php echo $id_hotel; ?>">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>Clientes</a>
                            <a class="nav-link" href="vista_empleado.php?id_hotel=<?php echo $id_hotel; ?>">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>Empleados</a>
							</div>
					</div>
				</nav>
			</div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Habitaciones ocupadas</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">En esta sección ud puede vizualizar las habitaciones que ya estan en uso dentro del hotel "<?php echo $nombre_hotel; ?>"</li>
						</ol>
                        <div class="row">
                            <?php while($row = $result_vhd->fetch_assoc()) { ?>
                                <div class="col-xl-3 col-md-6">
                                    <div class="card bg-danger text-white mb-4">
                                        <div class="card-body">
                                            <h4 class="pl-4"><?php echo $row['numero']; ?></h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="">
                                                        <i><b><h6 class="pl-4"><?php echo $row['nombre_cliente'] ." " . $row['apellido_cliente']; ?></b></h6></i>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <h6>Fecha fin de reserva: </h6>
                                                    <div class="bg-white rounded text-dark d-flex align-items-center justify-content-center">
                                                        <h6><?php echo $row['fecha_fin_reserva']; ?></h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
							<?php } ?>

						</div>
					</div>
				</main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Grupo 6
							<?php echo date('Y'); ?>
						</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
							</div>
						</div>
					</div>
				</footer>
			</div>
		</div>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../.././js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
	</body>
</html>
