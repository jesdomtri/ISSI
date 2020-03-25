<?php
session_start();
require_once(__DIR__.'/../../gestion_funcionesBD.php');
if(isset($_REQUEST['personal'])){
//Si nos han pedido datos de un trabajador, responder con un modal con los datos.
$peticion = "SELECT * FROM TRABAJADORES WHERE DNI ='".$_REQUEST["DNI"]."'";

$trabajador = consulta($peticion)[0];

?>
<div class="modal" id="modal-datos">
    <form class="modal-content animate">
        <div class="container-modal">
            <span class="titulo2">
                <h3>Información de <?php echo($trabajador["NOMBRE"]); ?></h3>
            </span>
            <div class="flex">
               <span class="padding-bottom20">DNI: <?php echo($trabajador["DNI"]); ?></span>
            </div>
            <div class="flex">
                <span class="padding-bottom20">Fecha de nacimiento: <?php echo($trabajador["FECHANAC"]); ?></span>
            </div>
            <div class="flex">
               <span class="padding-bottom20">Correo electrónico: <?php echo($trabajador["EMAIL"]); ?></span>
            </div>
                
            <div class="flex">
             <span class="padding-bottom20">Nº SS: <?php echo($trabajador["NSS"]); ?></span>
            </div>

            <div class="flex">
             <span class="padding-bottom20">Contraseña: <?php echo($trabajador["PASS"]); ?></span>
            </div>

            <div class="flex">
             <span class="padding-bottom20">Administrador:
              <?php $admin = $trabajador["ESADMIN"]== 'T' ? 'Sí' : 'No';
              echo($admin); 
              ?></span>
            </div>
            <div class=flex>
              <span class="padding-bottom20"><a href="dashboard.php?rend=trabajadores/trabajadores.php&a=tr&fila=<?php echo($_SESSION['VISTA']['fila']);?>&PAGE=<?php echo($_SESSION['VISTA']['PAGE']);?>&acciones_trabajadores=eliminar&DNI=<?php echo($_REQUEST['DNI']); ?>" class="botonDash botonRojo">Eliminar trabajador</a></span>
            </div>
            
        </div>
    </form>
</div>

<?php 

}elseif(isset($_REQUEST['nominas'])) {

	$peticion_trabajador ="SELECT * FROM TRABAJADORES WHERE DNI ='".$_REQUEST["DNI"]."'";
	$peticion_nomina = "SELECT SALARIO, FECHA, HORASTRABAJADAS, HORASEXTRA FROM NOMINAS WHERE DNI ='".$_REQUEST["DNI"]."'";
    
   $calcular = $_REQUEST['calcular'];
  
	if($calcular == 'true'){
		$q = "BEGIN NUEVA_NOMINA(:DNI, TO_DATE(:FECHA, 'YYYY-MM-DD')); END;";
		$fecha = formateoFechas(date('Y-m-d',time()));
		$params = array(':DNI'=>$_REQUEST["DNI"], ':FECHA'=>$fecha);
		
		$calcular_nomina = realizarProcedimiento($q, $params);
		}

	$trabajador= consulta($peticion_trabajador)[0];
	$nominas= consulta($peticion_nomina);
		?>
<div class="modal" id="modal-datos">
    <form class="modal-content animate">
        <div class="container-modal">
            <span class="titulo2">
                <h3>Nóminas y horario de <?php echo($trabajador["NOMBRE"]); ?></h3>
            </span>

            <?php
            foreach ($nominas as $nomina) {
            	foreach ($nomina as $campo => $valor) {

            		$element = ' <div class="flex"> <span class="padding-bottom20">'.$campo.': '.$valor.'</span></div>';
            		echo($element);

            	}
            	echo("<hr>");
            		
            }
            echo('<div class="flex">');
            echo('<a class="botonDash calc_nomina" value="'.$trabajador["DNI"].'" >Calcular nómina </a> </div>');

             ?>
         
        </div>
    </form>
</div>



<?php 
}
?>
