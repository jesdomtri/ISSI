<?php 

if(isset($_SESSION['nueva_obra'])){
	$form = $_SESSION['nueva_obra'];
}else{
	$form = array(':DNIJEFE' => '',':DNIOFICIAL1' => '',':DNIOFICIAL2' => '',':DIRECCION' => '',
        ':PRESUPUESTO' => '',':PROFORMA' => '',':COSTO' => '', ':FECHAINICIO'=>'', ':FECHAFIN'=>'');
}
unset($_SESSION['nueva_obra']);
?>

<div class="modal" id="form-modal">
    <form class="modal-content animate" method="post" action="dashboard.php?rend=obras/obras.php&acciones=nueva_obra">
        <div class="container-modal">
            <span class="titulo2"> Añadir obra</span>
            <div class="inputExt">
                <select class="inputInt" name=":DNIJEFE" required="">
                    <option>---- DNI JEFE ----</option>
                    <?php 
                    require_once '../gestion_funcionesBD.php';
                    $query = 'SELECT DNI FROM TRABAJADORES';
                    $trab = consulta($query);
                    foreach ($trab as $tr) {
                        if ($tr['DNI'] != $form[":DNIJEFE"]) {
                            echo "<option value=".$tr['DNI'].">".$tr['DNI']."</option>";
                        } else {
                            echo "<option selected value=".$tr['DNI'].">".$tr['DNI']."</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="inputExt">
                <select class="inputInt" name=":DNIOFICIAL1" required="" >
                    <option>---- DNI OFICIAL 1 ----</option>
                    <?php 
                    $query = 'SELECT DNI FROM TRABAJADORES';
                    $trab = consulta($query);
                    foreach ($trab as $tr) {
                        if ($tr['DNI'] != $form[":DNIJEFE"]) {
                            echo "<option value=".$tr['DNI'].">".$tr['DNI']."</option>";
                        } else {
                            echo "<option selected value=".$tr['DNI'].">".$tr['DNI']."</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="inputExt">
                <select class="inputInt" name=":DNIOFICIAL2" required="" >
                    <option>---- DNI OFICIAL 2 ----</option>
                    <option value="NULL">NULL</option>
                    <?php 
                    $query = 'SELECT DNI FROM TRABAJADORES';
                    $trab = consulta($query);
                    foreach ($trab as $tr) {
                        if ($tr['DNI'] != $form[":DNIJEFE"]) {
                            echo "<option value=".$tr['DNI'].">".$tr['DNI']."</option>";
                        } else {
                            echo "<option selected value=".$tr['DNI'].">".$tr['DNI']."</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="inputExt">
                <input class="inputInt" name=":DIRECCION" placeholder="Dirección" required="" type="text" value=<?php echo($form[":DIRECCION"]); ?>> </input>
            </div>
            <div class="inputExt">
                <input class="inputInt" name=":PRESUPUESTO" placeholder="Presupuesto" required="" type="text" value=<?php echo($form[":PRESUPUESTO"]); ?>></input>
            </div>
            <div class="inputExt">
                <input class="inputInt" name=":PROFORMA" placeholder="Proforma" required="" type="text" value=<?php echo($form[":PROFORMA"]); ?>> </input>
            </div>
            <div class="inputExt">
                <input class="inputInt" name=":COSTO" placeholder="Costo" required="" type="text" value=<?php echo($form[":COSTO"]); ?>> </input>
            </div>
            <div class="inputExt">
                <input class="inputInt" name=":FECHAINICIO" placeholder="Fecha de inicio" required="" type="date" value=<?php echo($form[":FECHAINICIO"]); ?>></input>
            </div>
            <div class="inputExt">
                <input class="inputInt" name=":FECHAFIN" placeholder="Fecha de fin" required="" type="date" value=<?php echo($form[":FECHAFIN"]); ?>></input>
            </div>
            <div class="botonExt">
                <button class="botonInt" type="submit">
                    Añadir
                </button>
            </div>
        </div>
    </form>
</div>
