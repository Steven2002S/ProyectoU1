<?php
	/*session_start();
	require 'conexion.php';
	
	if(!isset($_SESSION['id'])){
		header("Location: index.php");
	}
	
	$id = $_SESSION['id'];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	
	if($tipo_usuario == 1){
		$where = "";
		} else if($tipo_usuario == 2){
		$where = "WHERE id=$id";
	}
	
	$sql = "SELECT * FROM usuarios $where";
	$resultado = $mysqli->query($sql);
	*/

	session_start();
	
require_once('../.././php/get/datos_hotel.php');
require_once('../.././php/conexion/conexion.php');
require_once('../.././php/config/config.php');

$conn = ConexionManager::obtenerConexionDesdeSesion();

	// Definir valores predeterminados
    $hotel_id = 'N/D';
    $nombre_hotel = 'N/D';
    $total_habitaciones = 'N/D';
    $habitaciones_disponibles = 'N/D';
    $habitaciones_ocupadas = 'N/D';
    $reservaciones_hoy = 'N/D';


if (isset($_GET['id_hotel'])) {

    $id_hotel = $_GET['id_hotel'];

    // Obtener información del hotel
    $hotel_info = getHotelInfo($conn, $id_hotel);

    // Asignar valores si se encontraron resultados, de lo contrario, se quedan con los valores predeterminados
    if ($hotel_info) {
        $hotel_id = $hotel_info["hotel_id"];
        $nombre_hotel = $hotel_info["nombre_hotel"];
        $total_habitaciones = $hotel_info["total_habitaciones"];
        $habitaciones_disponibles = $hotel_info["total_habitaciones_disponibles"];
        $habitaciones_ocupadas = $hotel_info["total_habitaciones_ocupadas"];
        $reservaciones_hoy = $hotel_info["reservaciones_hoy"];
    }

    // Consultar cargos
    $result_cargo = $conn->getConexion()->query("SELECT * FROM cargo");
    $cargos = ($result_cargo->num_rows > 0) ? $result_cargo->fetch_all(MYSQLI_ASSOC) : [];

    // Consultar clientes
    $result_cliente = $conn->getConexion()->query("SELECT * FROM vista_clientes");

    // Consultar ciudades
    $result_ciudades = $conn->getConexion()->query("SELECT * FROM ciudad");
    $ciudades = ($result_ciudades->num_rows > 0) ? $result_ciudades->fetch_all(MYSQLI_ASSOC) : [];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<meta name="description" content="" />
	<meta name="author" content="" />
	<title>Cargos</title>
	<link href="../.././css/styles.css" rel="stylesheet" />
	<link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet"
		crossorigin="anonymous" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js"
		crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
	<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
		<a class="navbar-brand" href="../dashboard/principal.php?id_hotel=<?php echo $id_hotel; ?>">
			<?php echo $nombre_hotel ; ?>
		</a>
		<button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i
				class="fas fa-bars"></i></button><!-- Navbar Search-->
		<form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
			<div class="input-group">
				<input class="form-control" type="text" placeholder="Search for..." aria-label="Search"
					aria-describedby="basic-addon2" />
				<div class="input-group-append">
					<button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
				</div>
			</div>
		</form>
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
					<h1 class="mt-4">Cargo nuevo</h1>
					<ol class="breadcrumb mb-4">
						<li class="breadcrumb-item"><a href="../vistas/vista_empleado.php?id_hotel=<?php echo $id_hotel?>">Empleados</a></li>
						<li class="breadcrumb-item active">Cargo</li>
					</ol>
                    <div class="card mb-4" id="form-registrar">
						<div class="card-header"><i class="fas fa-table mr-1"></i> Registro de nuevo cargo para empleados</div>
						<div class="card-body">
                            <form action="../.././php/post/registrar_cargo.php" method="post" id="registro-form">
							<div class="row">
								<div class="col form-group">
									<label for="cedula">Ingrese el cargo:</label>
									<input type="text" id="cargo" name="cargo" class="form-control" required>
								</div>
							</div>
                            <input type="hidden" name="id_hotel" value="<?php echo $id_hotel; ?>">
							<button type="submit" class="btn btn-primary btn-realizar-compra">Registrar</button>
                            </form>
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
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"
		crossorigin="anonymous"></script>
	<script src="../.././js/scripts.js"></script>
	<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
	<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
	<script src="assets/demo/datatables-demo.js"></script>
	<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
	<script>
		$(document).ready(function() {
			$("#registro-form").validate({
				rules: {
					cargo: "required",
				},
				messages: {
					cargo: "Debe ingresar el cargo para registrar",
				},
				errorClass: "error",
				errorElement: "small",
				highlight: function (element, errorClass, validClass) {
					$(element).addClass("is-invalid");
					$(element).removeClass("is-valid");
				},
				unhighlight: function (element, errorClass, validClass) {
					$(element).removeClass("is-invalid");
					$(element).addClass("is-valid");
				},
				errorPlacement: function(error, element) {
					error.addClass("text-danger");
					error.insertAfter(element);
				},
			});
		});
	</script>
</body>

</html>