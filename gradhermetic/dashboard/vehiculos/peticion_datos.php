<?php
session_start();
require_once __DIR__ . '/../../gestion_funcionesBD.php';
if (isset($_REQUEST['info'])) {
	$peticion  = "SELECT * FROM ASIGNACIONES_V WHERE MATRICULA='" . $_REQUEST["MATRICULA"] . "'";

	$aVehiculo = consulta($peticion);
	if (isset($aVehiculo[0])) {

		

		?>

		<div class="modal" id="modal-datos">
			<div class="modal-content animate">
				<div class="container-modal">
					<span class="titulo2">
						Información de <?php echo $aVehiculo[0]["MATRICULA"]; ?>
					</span>
			<?php foreach ($aVehiculo as $asignacion) {
				$N = "SELECT NOMBRE FROM TRABAJADORES WHERE DNI='".$asignacion['DNI']."'";
				$NOMBRE = consulta($N)[0]['NOMBRE'];
				
			?>
				
					<div class="flex">
						<span class="padding-left10 padding-bottom20">
							Nombre: <?php echo $NOMBRE; ?>
						</span>
					</div>
					<div class="flex">
						<span class="padding-left10 padding-bottom20">
							DNI: <?php echo $asignacion["DNI"]; ?>
						</span>
					</div>
					<div class="flex">
						<span class="padding-left10 padding-bottom20">
							Fecha de recogida: <?php echo $asignacion["FECHARECOGIDA"]; ?>
						</span>
					</div>
					<div class="flex">
						<span class="padding-left10 padding-bottom20">
							Fecha de entrega: <?php echo $asignacion["FECHAENTREGA"]; ?>
						</span>
					</div>
					<hr>
			<?php	} 
					
				} else {
					echo "<div class='modal' id='modal-datos'><div class='modal-content animate'>
					<div class= 'container-modal'><h3>No tiene trabajadores asignados este vehículo</h3></br>";
				}
				
				?>

				<form name=asignacion_v method=post action="dashboard.php?rend=vehiculos/vehiculos.php&a=ve">
					<fieldset><legend>Asignar vehículo a trabajador</legend>
					<strong>Seleccione el trabajador:</strong> 
					<input name=acciones value=asignacion hidden />
					<select required name=":DNI">
						<?php
						$query = "SELECT DNI, NOMBRE FROM TRABAJADORES";
						$trabajadores = consulta($query);
						foreach ($trabajadores as $trabajador) {
							echo("<option value=".$trabajador['DNI'].">".$trabajador['NOMBRE']."</option>");
						}
						
						 ?>

					</select>

					<input type=text hidden name=":MATRICULA" value=<?php echo($_REQUEST["MATRICULA"]); ?> /><br>
					<strong>Fecha de recogida:</strong> <input required type=date name=":FECHARECOGIDA"/><br>
					<strong>Fecha de entrega:</strong> <input required type=date name=":FECHAENTREGA"/><br>
				</fieldset>
				
					
				<br>

				<div class=flex>
					<span class="padding-bottom20">
						<button type=sumbit class=botonDash>Asignar vehículo</button>
						<a href="dashboard.php?rend=vehiculos/vehiculos.php&a=ve&fila=<?php echo($_SESSION['VISTA']['fila']);?>&PAGE=<?php echo($_SESSION['VISTA']['PAGE']);?>&acciones=eliminar_vehiculo&MATRICULA=<?php echo($_REQUEST['MATRICULA']); ?>" class="botonDash botonRojo">Eliminar vehiculo</a></span>
				</div>
				</form>
			</div>
		</div>
	</div>
	<?php
}elseif (isset($_REQUEST['revitv'])) {
	$peticion = "SELECT ITVID, FECHA, REVISIONITV, PROXIMAREVISION FROM REVISIONES_ITV WHERE MATRICULA='".$_REQUEST["MATRICULA"]."'";
	$revisionItv = consulta($peticion);
	$_SESSION['matr']=$_REQUEST['MATRICULA'];
	?>
	<div class="modal" id="modal-datos">
		<form class="modal-content animate">
			<div class="container-modal">
				<span class="titulo2">
					Revisiones de <?php echo $_REQUEST["MATRICULA"]; ?>
				</span>
				<div class=flex>
					<span class="padding-bottom20"><a href="dashboard.php?rend=vehiculos/vehiculos.php&a=ve&fila=<?php echo($_SESSION['VISTA']['fila']);?>&PAGE=<?php echo($_SESSION['VISTA']['PAGE']);?>&acciones=eliminar_vehiculo&MATRICULA=<?php echo($_REQUEST['MATRICULA']); ?>" class="botonDash botonRojo">Eliminar vehiculo</a></span>
				</div>
				<?php
				foreach ($revisionItv as $ritv) {
					foreach ($ritv as $key => $value) {
						if ($key != 'R' and $key != 'ITVID') {
							if ($key == 'REVISIONITV' and $value == 'NO PASADA') {
								echo '<div class="flex"><span class="padding-left10 padding-bottom20">'.$key.': <select value="'.
								$ritv["ITVID"].'"><option value="NO PASADA">NO PASADA</option><option value="PASADA">PASADA</option></select></span></div>';
							}else{
								echo '<div class="flex"><span class="padding-left10 padding-bottom20">'.$key.': '.$value.'</span></div>';
							}
						}
					}
					echo "<hr>";
				}
				?>
			</div>
		</form>
	</div>

	<?php
}elseif (isset($_REQUEST['modRev'])) {
	print_r($_SESSION['matr']);
	$actualizar = "UPDATE REVISIONES_ITV SET REVISIONITV = 'PASADA' WHERE ITVID =".$_REQUEST['ITVID'];
	$dos = realizarProcedimiento($actualizar, 'none');
	$peticion = "BEGIN proxRevision('".$_SESSION["matr"]."'); END;";
	$uno = realizarProcedimiento($peticion, 'none');
	echo($uno);
	
}

?>
