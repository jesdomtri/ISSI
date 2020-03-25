<?php require_once('../gestion_funcionesBD.php');
if (isset($_REQUEST['acciones'])) {
    switch ($_REQUEST['acciones']) {
        case 'nuevo_horario':
            foreach ($_POST as $campo => $valor) {
                $form[$campo] = $valor;
            }
            $_SESSION['nuevo_horario'] = $form;
            echo($form[':FECHA']);
            $form[':FECHA'] = formateoFechas($form[':FECHA']);
            echo($form[':FECHA']);
            
            $insert = "BEGIN NUEVO_HORARIO(:OBID, TO_DATE(:FECHA,'YYYY-MM-DD'), TO_TIMESTAMP(:HORAENTRADA,'HH24:MI'), TO_TIMESTAMP(:HORASALIDA,'HH24:MI'), :COSTEDESPLAZAMIENTO); END;";
            
            $err = realizarProcedimiento($insert, $form);
            if (!$err) {
                //unset($_SESSION['nuevo_horario]);
            }
            break;
        
        case 'eliminar_horario':
            $proc = "DELETE FROM HORARIOS WHERE HID='".$_REQUEST['HID']."'";
            $err = realizarProcedimiento($proc, 'none');
            break;
    }
}

echo("<script src=horarios/script_horarios.js></script>");
$page = isset($_REQUEST['PAGE']) ? $_REQUEST['PAGE'] : 1;
$query = "SELECT OBID, DIRECCION FROM OBRAS";
$obras = consulta($query); 


?>

<div class="fila">

    <div class="cuadrado">
         <div class="cuadrado-header"> <h5 class="title"> Horarios:</h5></div>
         <div class=cuadrado-body>
            <div id=obras>
            <?php require_once 'nuevo_horario.php';?>
            <div class="btn-group padding-bottom30">
                <a class="botonDash botonHorario" >
                    Añadir horario
                </a>
            </div></br>

            Seleccione la obra: <select><option value=none selected>Ninguna</option>
            <?php foreach($obras as $obra){
                        echo("<option value=".$obra['OBID'].">".$obra['DIRECCION']."</option>");}?>
                
            </select><br><br>
        
        <!--Control del numero de filas -->
        <form action="dashboard.php">
            <input hidden name=rend value="horarios/horarios.php">
            <input hidden name=PAGE value=<?php echo($page)?>>
            <input hidden name=a value=ho >
        Número de filas por página: <input class="controlPaginacion" type="number" min=3 max= 10 name="fila">   
        <button type="submit" class=botonDash >Cambiar</button>
        </form>

        <div id="tabla-horario">
        </div>

            </div> <!--Cierre div id=obras -->
         </div> <!--Cierre div cudarado-body-->

     </div><!-- Cierre div cuadrado -->
 </div> <!-- Cierre div fila-->