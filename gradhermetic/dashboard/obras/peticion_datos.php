<?php
require_once(__DIR__.'/../../gestion_funcionesBD.php');
session_start();
if(isset($_REQUEST['info'])){
//Si nos han pedido datos de un trabajador, responder con un modal con los datos.
    $peticion = "SELECT * FROM OBRAS WHERE OBID='".$_REQUEST["OBID"]."'";


    $obra = consulta($peticion)[0];
    $dir_piezas = str_replace(" ", "+", $obra["DIRECCION"]);

    ?>

    <div class="modal" id="modal-datos">
        <form class="modal-content animate">
            <div class="container-modal">
                <span class="titulo2">Información de <?php echo($obra['DIRECCION']); ?> </span>
                <div class="flex">
                    <span class="padding-left10 padding-bottom20"> DNI Jefe Obra: <?php echo($obra['DNIJEFE']); ?></span>
                </div>
                <div class="flex">
                    <span class="padding-left10 padding-bottom20"> DNI oficial 1: <?php echo($obra['DNIOFICIAL1']); ?></span>
                </div>
                <?php if($obra['DNIOFICIAL2'] != ''){?>
                    <div class="flex">
                        <span class="padding-left10 padding-bottom20"> DNI oficial 2:  <?php echo($obra['DNIOFICIAL2']); ?></span>
                    </div>
                    <?php } ?>
                    <div class="flex">
                        <span class="padding-left10 padding-bottom20"> Proforma: <?php echo($obra['PROFORMA']); ?></span>
                    </div>
                    <div class="flex">
                        <span class="padding-left10 padding-bottom20">Costo: <?php echo($obra['COSTO']); ?></span>
                    </div>
                    <div class="flex">
                        <span class="padding-left10 padding-bottom20"> Fecha de inicio: <?php echo($obra['FECHAINICIO']); ?></span>

                    </div>
                    <div class="flex">
                        <span class="padding-left10 padding-bottom20"> Fecha de fin: <?php echo($obra['FECHAFIN']); ?></span>

                    </div>
                    <div class=flex>
                        <span class="padding-bottom20"><a href="dashboard.php?rend=obras/obras.php&a=ob&fila=<?php echo($_SESSION['VISTA']['fila']);?>&PAGE=<?php echo($_SESSION['VISTA']['PAGE']);?>&acciones=eliminar_obra&OBID=<?php echo($_REQUEST['OBID']); ?>" class="botonDash botonRojo">Eliminar obra</a></span>
                    </div>
              </div>
              <div class="cuadrado">
                <div class="cuadrado-header">
                    <h5 class="title"> Mapa de la obra </h5>
                </div>

                <iframe frameborder="0" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyB5yjJ2timzwN2nrdO3YMCt5K8sDwRr6D4
                &q= <?php echo($dir_piezas)?>,Sevilla" style="border:0;">
            </iframe>

        </div>


    </form>



</div>

<?php }elseif(isset($_REQUEST['horario'])){
  $consulta_fechas="SELECT TO_CHAR(HORAENTRADA, 'HH24:MI') AS H_ENTRADA, TO_CHAR(HORASALIDA, 'HH24:MI') AS H_SALIDA FROM HORARIOS WHERE HID='".$_REQUEST['HID']."'";
  $horario = consulta($consulta_fechas)['0'];
  echo($horario['H_ENTRADA'].' '.$horario['H_SALIDA']);

} 

?>