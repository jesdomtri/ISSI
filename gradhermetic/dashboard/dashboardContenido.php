<?php
require_once '../gestion_funcionesBD.php';
if(isset($_REQUEST['salvar_cambios'])){
    $_SESSION['LOGIN']['EMAIL'] = $_REQUEST['email'];
    $_SESSION['LOGIN']['nombre'] = $_REQUEST['nombre'];
    $pet = "UPDATE TRABAJADORES SET NOMBRE='".$_REQUEST['nombre']."', EMAIL='".$_REQUEST['email']."', PASS='".$_REQUEST['pass']."' WHERE DNI='".$_SESSION['LOGIN']['DNI']. "'";
    
    realizarProcedimiento($pet, 'none');
}

$query      = "SELECT DNI, NOMBRE, EMAIL, PASS FROM TRABAJADORES WHERE DNI = '" . $_SESSION['LOGIN']['DNI'] . "'";
$trabajador = consulta($query)[0];
$query2     = "SELECT FECHA, PROXIMORECONOCIMIENTO FROM REC_MEDICO WHERE DNI = '" . $trabajador["DNI"] . "'";
$recMedico  = consulta($query2);
$recMedico  = isset($recMedico[0]) ? $recMedico[0] : array("FECHA" =>'-', "PROXIMORECONOCIMIENTO" =>'-');
$query3     = "SELECT SALARIO, HORASTRABAJADAS, HORASEXTRA FROM NOMINAS WHERE DNI = '" . $trabajador["DNI"] . "'";
$nomina     = consulta($query3);
$nomina = isset($nomina[0]) ? $nomina[0] :  array('SALARIO' =>'-' ,'HORASTRABAJADAS' => '-', 'HORASEXTRA' =>'-' );
$greeting = '<h3>Bienvenido al dashboard de Gradhermetic '. $_SESSION['LOGIN']['nombre'].'</h3>';
echo($greeting);
?>

<div class="fila">
    <div class="cuadrado">
        <div class="cuadrado-header"><h5 class="title">Editar perfil </h5></div>
        <div class="cuadrado-body">
            <form action=dashboard.php?salvar_cambios=on method=post>
                <div class="fila">
                    <div class="columna">
                        <div class="padding-bottom10">
                            <label>DNI</label>
                            <?php
echo '<input class="datosPerfil" disabled="" placeholder="DNI" type="text" value=' . $trabajador["DNI"] . '>';
        ?>
                        </input>
                    </div>
                </div>
                <div class="columna">
                    <div class="padding-bottom10">
                        <label>
                            Nombre
                        </label>
                        <?php
echo '<input class="datosPerfil" placeholder="Username" name=nombre type="text" value="' . $trabajador["NOMBRE"] . '">';
?>
                    </input>
                </div>
            </div>
        </div>
        <div class="fila">
            <div class="columna">
                <div class="padding-bottom10">
                    <label>
                        Correo electrónico
                    </label>
                    <?php
echo '<input class="datosPerfil" placeholder="Email" name=email type="email" value=' . $trabajador["EMAIL"] . '>';
?>
                </input>
            </div>
        </div>
        <div class="columna">
            <div class="padding-bottom10">
                <label>
                    Contraseña
                </label>
                <?php
echo '<input id="contrasena" class="datosPerfil" name=pass placeholder="Contraseña" type="password" value=' . $trabajador["PASS"] . '>';
echo 'Mostrar contraseña: <input type=checkbox value=no id=mostrar>';
?>
            </input> 
            <div><br><button class="botonDash" type=submit>Guardar cambios</a></div>
        </div>

    </div>
</div>
</form>
</div>
</div>

<div class="cuadrado">
    <div class="cuadrado-header">
        <h5 class="title">
            Próxima revisión médica
        </h5>
    </div>
    <div class="cuadrado-body">
        <p>
            <?php
echo 'Pasaste la revisión médica el día: ' . $recMedico["FECHA"];
?>
        </p>
        <br/>
        <p>
           <?php
echo 'Tu próxima revisión es el día: ' . $recMedico["PROXIMORECONOCIMIENTO"];
?>
        </p>
    </div>
</div>
</div>
<div class="fila">
    <div class="cuadrado">
        <div class="cuadrado-header">
            <h5 class="title">
                Nóminas
            </h5>
        </div>
        <div class="cuadrado-body">
            <p>
                <?php
echo 'Tu salario actual es: ' . $nomina["SALARIO"];
?>
            </p>
            <br/>
            <p>
               <?php
echo 'Has trabajado ' . $nomina["HORASTRABAJADAS"] . ' horas';
?>
            </p>
            <br/>
            <p>
                <?php
echo 'Has trabajado ' . $nomina["HORASEXTRA"] . ' horas extras';
?>
            </p>
        </div>
    </div>
</div>
