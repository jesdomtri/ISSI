<?php 
	session_start();

	if($_SESSION['LOGIN']['check'] !== true){
		//Si no hemos iniciado sesion...
		header('Location:../index.php');
	}elseif ($_SESSION['LOGIN']['admin']=='T') {
		//Si hemos iniciado sesion como administrador
		$rendering =isset($_REQUEST["rend"]) ? $_REQUEST["rend"] : "dashboard.php";
		switch ($rendering) {
			case 'dashboard.php':

				$title = "Dashboard";
				$dash = "class=activo";
				break;
			case 'obras/obrasAsignadas.php':
				$title = "Obras Asignadas";
				$obrasAs="class=activo";
				break;
			case 'vehiculos/vehiculosAsignados.php':
				$title = "Vehiculos Asignados";
				break;
			case 'trabajadores/trabajadores.php':
				$title = "Trabajadores";
				break;
			case 'obras/obras.php':
				$title = "Obras";
				break;
			case 'vehiculos/vehiculos.php':
				$title = "Vehículos";
				break;
			case 'horarios/horarios.php':
			$title = "Horarios";
				break;
			case 'salir.php':
				unset($_SESSION['LOGIN']);
				session_destroy();
				header('Location:../index.php');
				break;

			default:
				$title = "Dashboard";
				$rendering = "dashboard.php";
			}
	}else{
		//Si hemos iniciado sesion como no administrador
		$rendering =isset($_REQUEST["rend"]) ? $_REQUEST["rend"] : "dashboard.php";
		switch ($rendering) {
			case 'dashboard.php':
				$title = "Dashboard";
				break;
			case 'obras/obrasAsignadas.php':
				$title = "Obras Asignadas";
				break;
			case 'vehiculos/vehiculosAsignados.php':
				$title = "Vehiculos Asignados";
				break;
			case 'salir.php':
				unset($_SESSION['LOGIN']);
				session_destroy();
				header('Location:../index.php');
				break;
			default:
				$title = "Dashboard";
				$rendering = "dashboard.php";
				break;
		}
		

	} 
?>


<!DOCTYPE html>
<html>
<head>
	<title><?php echo($title)?></title>
	<meta charset="utf-8" lang="es">
	<link rel=icon href=/gradhermetic/img/favicon.ico >
	<link href="estilo_dash2.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans" rel="stylesheet"></link>
    </link>
	<script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
</head>

<body>
   <div class="limitador" id="dashboard">
        <div class="container">
            <div class="containerInt">	
	
	 	<!-- BARRA DE NAVEGACION -->
	 	 <div class="sidebar">
            <div class="logo">
            	<?php $activo = isset($_REQUEST['a']) ? $_REQUEST['a'] : 'dash' ?>
                <span class="simple-text pos-logo"><?php echo($title)?></span>
				<!-- BOTONES DE NAVEGACION-->
                <div class="sidebar-wrapper">
                    <ul class="nav" pagActiva=<?php echo($activo)?>>
                        <li id=dash><a href="dashboard.php?rend=dashboard.php&a=dash"> <p>Dashboard</p></a></li>
                        <li id=oasig><a href="dashboard.php?rend=obras/obrasAsignadas.php&a=oasig"><p>Obras asignadas</p></a></li>
                        <li id=vasig><a href="dashboard.php?rend=vehiculos/vehiculosAsignados.php&a=vasig"><p>Vehículos asignados</p></a> </li>
                        <?php if($_SESSION['LOGIN']['admin']=='T'){ ?>
                        <li id=tr> <a href="dashboard.php?rend=trabajadores/trabajadores.php&a=tr"><p>Trabajadores</p></a></li>
                        <li id=ob><a href="dashboard.php?rend=obras/obras.php&a=ob"> <p> Obras</p></a></li>
                        <li id=ve><a href="dashboard.php?rend=vehiculos/vehiculos.php&a=ve"><p>Vehículos</p></a></li>
                        <li id=ho><a href="dashboard.php?rend=horarios/horarios.php&a=ho"><p>Horarios</p></a></li>
                        <?php } ?>
                         <li><a href="dashboard.php?rend=salir.php"> <p>Salir</p></a></li>
                    </ul>
                </div>
            </div>
          </div>


<!-- CONTENIDO DINAMICO -->
<div class="panel-main">
    <div class="panel-header "></div>
    	<div class="content">
<?php
	echo("<script src=script_dashboard.js></script>");
	if($rendering == 'dashboard.php'){
		
		require_once('dashboardContenido.php');
	}else{
		require_once($rendering);}
		 ?>


		<!-- Cierre de los div panel-main content-->
		</div>
	</div>

		 <!-- Cierre de los div limitador container containerInt-->
		</div>
	
	</div>
<footer>© 2018 Gradhermetic</footer>
</div>
	
</body>
</html>