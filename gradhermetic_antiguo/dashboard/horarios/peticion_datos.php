<?php
session_start();
require_once(__DIR__.'/../../gestion_funcionesBD.php');

if(isset($_REQUEST['TABLA'])){
	$_SESSION['OBID'] = $_REQUEST['OBID'];
	$query = "SELECT HID,FECHA, TO_CHAR(HORAENTRADA, 'HH24:MI') AS H_ENTRADA, TO_CHAR(HORASALIDA, 'HH24:MI') AS H_SALIDA FROM HORARIOS WHERE OBID=".$_REQUEST['OBID'];
	$total_filas = consultaTotalFilas($query);
	$page = 1;
	$tamano_filas = isset($_REQUEST['fila']) ? $_REQUEST['fila'] : 5;
	$total_paginas = ceil($total_filas/$tamano_filas);
	$horarios = consultaPaginada($query, $page, $tamano_filas);

	if(isset($horarios)){
		echo("<table>");
		echo("<tr><th>FECHA</th>");
		echo("<th>ENTRADA</th>");
		echo("<th>SALIDA</th>");
		echo("<th>ASIGNACIONES</th>");
		echo("</tr>");

		foreach ($horarios as $horario) {
			echo("<tr>");
			$HID = $horario['HID'];
			foreach($horario as $clave => $campo){
				if($clave != 'R' and $clave != 'HID'){
					echo("<td>".$campo."</td>");
				}
			}
			echo("<td><a class='botonDash asignaciones' value=".$HID.">Ver trabajadores asignados</a></td>");
			echo("<td><a class='botonDash botonRojo' href='dashboard.php?rend=horarios/horarios.php&a=ho&acciones=eliminar_horario&HID=".$HID."'>Eliminar horario</a></td>");
			echo("</tr>");
		}
		echo("</table>");
	}else{
		echo("<h3>La obra seleccionada no tiene horarios</h3>");
	}



         	
}elseif(isset($_REQUEST['ASIGNACIONES'])){

	//Si hemos llegado aqui porque estamos asignando un nuevo trabajador a un horario:
	if(isset($_REQUEST['NUEVA'])){
		$query = "BEGIN NUEVA_ASIGNACIONH(:DNI, :HID); END;";
		$nueva_asignacion = realizarProcedimiento($query, array(":DNI" =>$_REQUEST['DNI'] , ":HID" => $_REQUEST['HID']));
	}
$query = "SELECT DNI, NOMBRE FROM TRABAJADORES NATURAL JOIN ASIGNACIONES_H WHERE HID='".$_REQUEST['HID']."'";
$asignaciones = consulta($query);
?>


<div class="modal" id="modal-datos">
    <form class="modal-content animate">
        <div class="container-modal">
            <span class="titulo2"> <h3>Asignaciones de <?php echo($_REQUEST["NOMBRE"]); ?></h3></span>

<?php
$trabajadores_asignados = array();
if(isset($asignaciones[0])){
	foreach ($asignaciones as $key => $asignacion) {
		echo('<div class="flex"><span class="padding-left10 padding-bottom20">Nombre: '.$asignacion['NOMBRE'].'</span></div>');
		echo('<div class="flex"><span class="padding-left10 padding-bottom20">DNI: '.$asignacion['DNI'].'</span></div>');
		echo("<hr>");
		$trabajadores_asignados[$asignacion['DNI']] = 'ok';
	}
	}else{
		echo("<h3>No existen asignaciones para esta obra</h3>");
	}
	$query = "SELECT DNI, NOMBRE FROM TRABAJADORES";
	$trabajadores = consulta($query);
	echo("<select id=select_trabajadores>");
	foreach ($trabajadores as $key => $trabajador) {
		if(!isset($trabajadores_asignados[$trabajador['DNI']])){
			echo("<option value=".$trabajador['DNI'].">".$trabajador['NOMBRE']."</option>");
		}
	}
	echo("</select><a class='botonDash asignarHorario'>Asignar trabajador</a>");
	echo("</div></form></div"); //Cierre de los div del modal.
	
}


?>