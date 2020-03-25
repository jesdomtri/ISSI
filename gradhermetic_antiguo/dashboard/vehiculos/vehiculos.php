<?php
require_once '../gestion_funcionesBD.php';
echo('<script type="text/javascript" src="vehiculos/script_vehiculos.js"></script>');
?>

<div class="fila">
	<div class="cuadrado">
		<div class="cuadrado-header"><h5 class="title">Vehículos:</h5></div>
		<div class="cuadrado-body">
			<div id="vehiculos">
				
				
					

<?php
require_once 'nuevo_vehiculo.php';
if (isset($_REQUEST['acciones'])) {
	switch ($_REQUEST['acciones']) {

		case 'nuevo_vehiculo':
			foreach ($_POST as $campo => $valor) {$form[$campo] = $valor;}
			$_SESSION['nuevo_vehiculo'] = $form;

			$insert = "BEGIN NUEVO_VEHICULO(:MATRICULA, :MODELO, :COLOR); END;";

			$err = realizarProcedimiento($insert, $form);
			if (!$err) {
	                //unset($_SESSION['nuevo_vehiculo']);
			}
		break;

		case 'asignacion':
			$form = array(':DNI' =>$_REQUEST[':DNI'] ,':MATRICULA'=> $_REQUEST[':MATRICULA'], ':FECHARECOGIDA' => $_REQUEST[':FECHARECOGIDA'], ':FECHAENTREGA' => $_REQUEST[':FECHAENTREGA']);

			//VALIDAR LOS CAMPOS
			
			$query = "BEGIN NUEVA_ASIGNACIONV(:DNI, :MATRICULA, TO_DATE(:FECHARECOGIDA, 'YYYY-MM-DD'), TO_DATE(:FECHAENTREGA, 'YYYY-MM-DD')); END;";
			realizarProcedimiento($query, $form);
		break;
		case 'eliminar_vehiculo':
		$proc = "DELETE FROM VEHICULOS WHERE MATRICULA='".$_REQUEST['MATRICULA']."'";
		$err = realizarProcedimiento($proc, 'none');
		break;
	}
}

//Comprobar en que pagina estamos y que accion nos han pedido.
$page         = isset($_REQUEST['PAGE']) ? $_REQUEST['PAGE'] : 1;
$tamano_filas = isset($_REQUEST['fila']) ? $_REQUEST['fila'] : 5;
$query        = "SELECT DISTINCT MATRICULA, MODELO, COLOR, IT.PROXIMAREVISION FROM VEHICULOS NATURAL JOIN REVISIONES_ITV IT WHERE IT.REVISIONITV='NO PASADA'";
$total_filas  = consultaTotalFilas($query);


$total_paginas = ceil($total_filas / $tamano_filas);
$vehiculos     = consultaPaginada($query, $page, $tamano_filas);

$_SESSION['VISTA'] = array('PAGE' => $page, 'fila' => $tamano_filas);
?>


				<div class="btn-group padding-bottom30">
					<a class="botonDash botonVehiculo" >
						Añadir vehículo
					</a>
				</div>
			<!--CONTROL DEL NUMERO DE FILAS DEL GRID -->
            <form action="dashboard.php">
                <input hidden name=rend value="vehiculos/vehiculos.php">
                <input hidden name=PAGE value=<?php echo ($page) ?>>
                <input hidden name=a value=ve >
                Número de filas por página: <input class="controlPaginacion" type="number" min=3 max= 10 name="fila">
                <button type="submit" class=botonDash >Cambiar</button>
            </form>

				<table>
					<tr>
						<th>Matrícula</th>
						<th>Modelo</th>
						<th>Color</th>
						<th>Próxima revisión</th>
					</tr>
					<?php
					foreach ($vehiculos as $vehiculo) {
						$ID = $vehiculo['MATRICULA'];
						echo ("<tr>"); 
						foreach ($vehiculo as $clave => $campo) {
							if ($clave != 'R') {
								echo ("<td>$campo</td>");
							}
						}
						echo ("<td><a class='botonDash info' value=".$ID.">Trabajadores asignados</a></td>
							<td><a class='botonDash revitv' value=".$ID.">Modificar revisiones</a></td></tr>");
					}
					echo ("</table>");

				//BOTONES DE TABULACION
					echo ("<div>");
					for ($i = 1; $i <= $total_paginas; $i++) {
						echo '<a href="dashboard.php?rend=vehiculos/vehiculos.php&a=ve&fila='.$tamano_filas.'&PAGE='.$i.'">'.$i.'</a>';
					}
					echo ("</div>");
					
					?>

				</div>
			</div>	
		</div>
	</div>