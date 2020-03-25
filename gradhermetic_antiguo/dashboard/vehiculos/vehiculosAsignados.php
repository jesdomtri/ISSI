<?php 

require_once('../gestion_funcionesBD.php');


$query = "SELECT MATRICULA, FECHARECOGIDA, FECHAENTREGA FROM ASIGNACIONES_V WHERE DNI='".$_SESSION['LOGIN']['DNI']."'";
$vehiculos = consulta($query);

if(isset($vehiculos['0'])){
?>
<div class="content">
	<div class="fila"> 
	<?php foreach($vehiculos as $k => $vehiculo){ ?>
		<div class="cuadrado">
			<div class="cuadrado-header"><h5 class="title">Vehiculo: <?php echo($vehiculo['MATRICULA']) ?></h5></div>
				<div class="cuadrado-body">
					<?php
					foreach ($vehiculo as $clave => $propiedad) {
						if($clave != 'R'){
						echo("<p><strong>$clave</strong>: $propiedad </p>");
						}
					}

					?>

			</div> <!--Cierre del div de cuadrado-body-->
		</div> <!--Cierre del div cuadrado -->

		<?php }?>
</div></div> <!--Cierre de los div content y fila -->
<?php 
}else{
	?>
<h3>No tienes vehículos asignados.</h3>
	<?php
}


?>