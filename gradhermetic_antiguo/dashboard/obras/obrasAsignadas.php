<?php 
require_once('../gestion_funcionesBD.php');
echo("<script src='obras/script_obras.js'></script>"); //incluir el script que maneja esta pagina
$query_aux = "SELECT UNIQUE(OBID) FROM ASIGNACIONES_H NATURAL JOIN HORARIOS WHERE DNI='".$_SESSION['LOGIN']['DNI']."'";

$query_obras = "SELECT DIRECCION,OBID FROM OBRAS NATURAL JOIN ($query_aux)";
$obras = consulta($query_obras);

if(isset($obras['0'])){


foreach ($obras as $obra) {
        

    $consulta_fechas="SELECT UNIQUE(FECHA), HID, TO_CHAR(HORAENTRADA, 'HH24:MI') AS H_ENTRADA, TO_CHAR(HORASALIDA, 'HH24:MI') AS H_SALIDA FROM ASIGNACIONES_H NATURAL JOIN HORARIOS WHERE DNI='".$_SESSION['LOGIN']['DNI']."' AND OBID='".$obra['OBID']."'";
    $horarios[$obra['OBID']] = consulta($consulta_fechas);
                  
            }

?> 

 <div class="content">
    <div class="fila">
        <div class="cuadrado">

            <div class="cuadrado-header">
                <h5 class="title">Obras que tienes asignadas</h5>
            </div>

            <div class="cuadrado-body">
                <?php foreach($obras as $obra){
                    echo("<p>".$obra['DIRECCION'] ."</p><br>");
                }
                    ?>
               
            </div>
        </div>

        <div class="cuadrado">
            <div class="cuadrado-header">
                <h5 class="title"> Fecha </h5>
            </div>

            <div class="cuadrado-body">
                <?php 
                foreach ($horarios as $obid => $horario) {
                    echo("<select value=".$obid.">");
                    foreach ($horario as $fecha) {
                    echo("<option value=".$fecha['HID'].">".$fecha['FECHA']."</option>");
                    }
                    echo("</select><br><br>");
                } ?>
            </div>
        </div>

        <div class="cuadrado">
            <div class="cuadrado-header">
                <h5 class="title">Hora de entrada</h5>
            </div>
            <div id=entrada class="cuadrado-body">
                
                <?php 
                
                foreach ($horarios as $obid => $horario) {
                 
                     $valor =  $horario['0']["H_ENTRADA"];
                    echo("<p id=e".$obid.">$valor</p><br>");
                    
                }
                ?>
            </div>
        </div>

        <div class="cuadrado">
            <div class="cuadrado-header">
                <h5 class="title"> Hora de salida </h5>
            </div>
            <div id=salida class="cuadrado-body">
               <?php 
                
                foreach ($horarios as $obid => $horario) {
                 
                     $valor =  $horario['0']["H_SALIDA"];
                    echo("<p id=s".$obid.">$valor</p><br>");
                    
                }
                ?>
            </div>
        </div>

    </div> <!--Cierre del div de la fila -->
</div> <!--Cierre del div del content -->

<?php }else{ ?><h3>No tienes obras asignadas.</h3> <?php }?>