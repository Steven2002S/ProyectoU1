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

// Verificar si se encontraron resultados
if ($id_hotel !== null) {
    // Obtener información del hotel
    $hotel_info = getHotelInfo($conn, $id_hotel);

    if ($hotel_info !== null){
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

}



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
            <a class="navbar-brand" href="principal.php?id_hotel=<?php echo $id_hotel; ?>"> <?php echo $nombre_hotel ?></a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button
			><!-- Navbar Search-->
            <!--<form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <div class="input-group">
				<input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
				<div class="input-group-append">
				<button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
				</div>
                </div>
			</form>-->
            <!-- Navbar-->
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
                            <a class="nav-link" href="principal.php?id_hotel=<?php echo $id_hotel; ?>"
							><div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard</a
							>
							
	
							<div class="sb-sidenav-menu-heading">Personal</div>
							<a class="nav-link" href=".././vistas/vista_cliente.php?id_hotel=<?php echo $id_hotel; ?>">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>Clientes</a>
                            <a class="nav-link" href=".././vistas/vista_empleado.php?id_hotel=<?php echo $id_hotel; ?>">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>Empleados</a>
							</div>
					</div>

				</nav>
			</div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
						</ol>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Total de Habitaciones</div>
                                    <h3 class="pl-4"><?php echo $total_habitaciones; ?></h3>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href=".././vistas/vista_hab_todas.php?id_hotel=<?php echo $id_hotel; ?>">Ver Detalles</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
									</div>
								</div>
							</div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">Habitaciones Libres</div>
                                    <h3 class="pl-4"><?php echo $habitaciones_disponibles; ?></h3>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href=".././vistas/vista_hab_disponibles.php?id_hotel=<?php echo $id_hotel; ?>">Ver Detalles</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
									</div>
								</div>
							</div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-secondary text-white mb-4">
                                    <div class="card-body">Habitaciones ocupadas</div>
                                    <h3 class="pl-4"><?php echo $habitaciones_ocupadas; ?></h3>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href=".././vistas/vista_hab_no_disponibles.php?id_hotel=<?php echo $id_hotel; ?>">Ver Detalles</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
									</div>
								</div>
							</div>
                            
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body">Reservaciones hoy</div>
                                    <h3 class="pl-4"><?php echo $reservaciones_hoy; ?></h3>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href=".././vistas/vista_hab_reserva_hoy.php?id_hotel=<?php echo $id_hotel; ?>">Ver Detalles</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
									</div>
								</div>
							</div>
						</div>
                        <div class="row">
                           <!-- <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header"><i class="fas fa-chart-area mr-1"></i>Area Chart Example</div>
                                    <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
								</div>
							</div>-->
                            <div class="col-xl-12">
                                <div class="card mb-4">
                                    <div class="card-header"><i class="fas fa-chart-bar mr-1"></i>Bar Chart Example</div>
                                    <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
								</div>
							</div>
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
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script>
            // Bar Chart Example
            var ctx = document.getElementById("myBarChart");
            var myLineChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                datasets: [{
                label: "Ingresos",
                backgroundColor: "rgba(2,117,216,1)",
                borderColor: "rgba(2,117,216,1)",
                data: [4215, 5312, 6251, 7841, 9821, 14984, 12158, 14234, 16842, 19453, 21562, 23145],
                }],
            },
            options: {
                scales: {
                xAxes: [{
                    time: {
                    unit: 'month'
                    },
                    gridLines: {
                    display: false
                    },
                    ticks: {
                    maxTicksLimit: 12
                    }
                }],
                yAxes: [{
                    ticks: {
                    min: 0,
                    max: 25000, // Ajusta según tus necesidades
                    maxTicksLimit: 5
                    },
                    gridLines: {
                    display: true
                    }
                }],
                },
                legend: {
                display: false
                }
            }
            });

        </script>
	</body>
</html>
