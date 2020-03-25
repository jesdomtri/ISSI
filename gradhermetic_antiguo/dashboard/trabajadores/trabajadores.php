<?php 
require_once('../gestion_funcionesBD.php');
echo("<script src='trabajadores/script_trabajadores.js'></script>"); //incluir el script que maneja esta pagina


$query = 'SELECT DNI, NOMBRE, EMAIL FROM TRABAJADORES';
$page = isset($_REQUEST['PAGE']) ? $_REQUEST['PAGE'] : 1;
$acciones = isset($_REQUEST['acciones_trabajadores']) ? $_REQUEST['acciones_trabajadores'] : 'todos';


?>
<div class="fila">
	<div class=cuadrado >
	   <div class="cuadrado-header"><h5 class="title"> Trabajadores: </h5></div>
	   		<div class="cuadrado-body">
				<div id="trabajadores">

<!--Botones de trabajadores-->
 <div class="btn-group padding-bottom30">
    <a class="botonDash contratar">Contratar trabajador </a>
</div>


<?php

require_once('contratar_trabajador.php');
switch ($acciones) {
	
	case 'contratar_resp':
		
		foreach ($_POST as $campo => $valor) { $form[$campo] = $valor; }

		$_SESSION['contratar'] = $form; //Guardamos en la sesion los datos del formulario.

		//Checkear que los campos pasan las validaciones. Si los pasan insertar al trabajador en la base de datos.
		$form[':FECHA_NAC'] = formateoFechas($form[':FECHA_NAC']);
		$form[':ADMIN'] = ($form[':ADMIN'] == 'T') ? 'T': 'F';
		$insert = "BEGIN CONTRATAR_TRABAJADOR(:DNI, :NOMBRE, TO_DATE(:FECHA_NAC, 'YYYY-MM-DD'), :EMAIL, :NSS, :PSW, :ADMIN); END;";
		
		$err = realizarProcedimiento($insert, $form);
		if(!$err){
			unset($_SESSION['contratar']);
		}
		
		break;
	case 'eliminar':
		$proc = "DELETE FROM TRABAJADORES WHERE DNI='".$_REQUEST['DNI']."'";
		$err = realizarProcedimiento($proc, 'none');


	}
	
//Control de la paginacion de la consulta
$total_filas = consultaTotalFilas($query);
$tamano_filas = isset($_REQUEST['fila']) ? $_REQUEST['fila'] : 5;

$total_paginas = ceil($total_filas/$tamano_filas);
$trabajadores = consultaPaginada($query, $page, $tamano_filas);
$_SESSION['VISTA'] = array('PAGE' => $page, 'fila' => $tamano_filas);
?>

	<form action="dashboard.php">
		<input hidden name=rend value="trabajadores/trabajadores.php">
		<input hidden name=PAGE value=<?php echo($page)?>>
		<input hidden name=a value=tr >
	Número de filas por página: <input class="controlPaginacion" type="number" min=3 max= 10 name="fila">	
	<button type="submit" class=botonDash >Cambiar</button>
	</form>
<table>
	<tr>
	        <th> DNI </th>
	        <th> Nombre y apellidos</th>
	        <th>Correo electrónico</th>
	       
	</tr>

<?php

foreach ($trabajadores as $trabajador) {
	echo("<tr>");
	$DNI = $trabajador['DNI'];
	foreach ($trabajador as  $clave =>$propiedad) {
		if($clave != 'R'){
		echo("<td>".$propiedad."</td>");
		}
	}
	 $personal = '<td class="txt-align-center"><a class="botonDash personal" name=personal value="'.$DNI.'"> Datos personales</a> </td>';
	 $nominas = '<td class="txt-align-center"><a class="botonDash nominas" name=nominas value="'.$DNI.'"> Nóminas</a> </td>';
	echo($personal);
	echo($nominas);
	echo("</tr>");
}

echo("</table>");
echo("<div>");
for ($i=1; $i<=$total_paginas;$i++){
	
	echo '<a href="dashboard.php?rend=trabajadores/trabajadores.php&a=tr&fila='.$tamano_filas.'&PAGE='.$i.'">'.$i.'</a>';
	
}
echo("</div>");

?>

<!--Botones al final de la tabla -->
 <div class="btn-group padding-bottom30" >

    <a class="botonDash contratar">Contratar trabajador </a>
</div>


<!--Fin del div con el id, body-cuadrado cuadrado, fila de la clase-->
			</div>
		</div>
	</div>
</div>
