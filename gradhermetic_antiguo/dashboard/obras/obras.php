<?php
require_once '../gestion_funcionesBD.php';
echo ("<script src='obras/script_obras.js'></script>"); //incluir el script que maneja esta pagina


if (isset($_REQUEST['acciones'])) {
    switch ($_REQUEST['acciones']) {
        case 'nueva_obra':
        foreach ($_POST as $campo => $valor) {$form[$campo] = $valor;}
        $_SESSION['nueva_obra'] = $form;
            //HAY QUE COMPROBAR QUE TODOS LOS CAMPOS PASAN LAS VALIDACIONES.
        $form[':FECHAINICIO'] = formateoFechas($form[':FECHAINICIO']);
        $form[':FECHAFIN']    = formateoFechas($form[':FECHAFIN']);
        print_r($form);

        if ($form[':DNIOFICIAL2'] == '') {
            unset($form[':DNIOFICIAL2']);
            $insert = "BEGIN NUEVA_OBRA(:DNIJEFE, :DNIOFICIAL1, NULL, :DIRECCION, :PRESUPUESTO, :PROFORMA, :COSTO, TO_DATE(:FECHAINICIO,'YYYY-MM-DD'), TO_DATE(:FECHAFIN, 'YYYY-MM-DD')); END;";
        } else {
            $insert = "BEGIN NUEVA_OBRA(:DNIJEFE, :DNIOFICIAL1, :DNIOFICIAL2, :DIRECCION, :PRESUPUESTO, :PROFORMA, :COSTO, TO_DATE(:FECHAINICIO,'YYYY-MM-DD'), TO_DATE(:FECHAFIN, 'YYYY-MM-DD')); END;";
        }

        $err = realizarProcedimiento($insert, $form);
        if (!$err) {
                //unset($_SESSION['nueva_obra']);
        }
        break;

        case 'eliminar_obra':
        $proc= "DELETE FROM OBRAS WHERE OBID='".$_REQUEST['OBID']."'";
        $err = realizarProcedimiento($proc, 'none');
        break;
    }
}

//Comprobar en que pagina estamos y que accion nos han pedido.
$page         = isset($_REQUEST['PAGE']) ? $_REQUEST['PAGE'] : 1;
$query        = "SELECT OBID,DNIJEFE, DIRECCION, PRESUPUESTO, FECHAFIN FROM OBRAS";
$total_filas  = consultaTotalFilas($query);
$tamano_filas = isset($_REQUEST['fila']) ? $_REQUEST['fila'] : 5;

$total_paginas = ceil($total_filas / $tamano_filas);
$obras         = consultaPaginada($query, $page, $tamano_filas);

$_SESSION['VISTA'] = array('PAGE' => $page, 'fila' => $tamano_filas);

?>


<div class="fila">

    <div class="cuadrado">
       <div class="cuadrado-header"> <h5 class="title"> Obras:</h5></div>
       <div class=cuadrado-body>
          <div id=obras>
            <?php require_once "nueva_obra.php";?>
            <!--BOTONES DE ACCION DE LAS OBRAS -->
            <div class="btn-group padding-bottom30">

                <a class="botonDash botonObra">Añadir obra</a>
            </div>


            <!--CONTROL DEL NUMERO DE FILAS DEL GRID -->
            <form action="dashboard.php">
                <input hidden name=rend value="obras/obras.php">
                <input hidden name=PAGE value=<?php echo ($page) ?>>
                <input hidden name=a value=ob >
                Número de filas por página: <input class="controlPaginacion" type="number" min=3 max= 10 name="fila">
                <button type="submit" class=botonDash >Cambiar</button>
            </form>


            <!--TABLA DONDE SE MUESTRAN LAS OBRAS -->
            <table>
                <tr>
                    <th>ID</th>
                    <th>DNI Jefe</th>
                    <th>Dirección</th>
                    <th>Presupuesto</th>
                    <th>Fecha Fin</th>
                    <th>Información</th>
                </tr>
                <?php
                foreach ($obras as $obra) {
                    $ID = $obra['OBID'];
                    echo ("<tr>");

                    foreach ($obra as $clave => $campo) {
                        if ($clave != 'R') {

                            echo ("<td>$campo</td>");
                        }

                    }
                    echo ("<td><a class='botonDash info' value=$ID>Más información</a></td></tr>");
                }
                echo ("</table>");

//BOTONES DE TABULACION
                echo ("<div>");
                for ($i = 1; $i <= $total_paginas; $i++) {
                    echo '<a href="dashboard.php?rend=obras/obras.php&a=ob&fila='.$tamano_filas.'&PAGE='.$i.'">'.$i.'</a>';;
                }
                echo ("</div>");
                ?>
                <!--CIERRE DE LOS DIV OBRAS, CUADRADO-BODY, CUADRADO -->
            </div>
        </div>
    </div>


            <!--CIERRE DEL DIV FILA -->
</div>