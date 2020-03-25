<?php 

if(isset($_SESSION['contratar'])){
	$form = $_SESSION['contratar'];
}else{
	$form = array(':NOMBRE' => '',':DNI' => '',':FECHA_NAC' => '',':NSS' => '',
		          ':EMAIL' => '',':PSW' => '',':ADMIN' => '');
}
unset($_SESSION['contratar']);
 ?>



<div class="modal" id="form-modal">
    <form class="modal-content animate"  method="post" action="dashboard.php?rend=trabajadores/trabajadores.php&acciones_trabajadores=contratar_resp">
        <div class="container-modal">
            <span class="titulo2">
                Contratar trabajador
            </span>
            <div class="inputExt">
                <input class="inputInt" name=":DNI" placeholder="DNI" required="" type="text" value='<?php echo($form[":DNI"]) ?>'>
                </input>
            </div>
            <div class="inputExt">
                <input class="inputInt" name=":NOMBRE" placeholder="Nombre completo" required="" type="text"value='<?php echo($form[":NOMBRE"]) ?>'>
                </input>
            </div>
            <div class="inputExt">
                <input class="inputInt" name=":FECHA_NAC" placeholder="Fecha de nacimiento" required="" type="date" value='<?php echo($form[":FECHA_NAC"]) ?>'>
                </input>
            </div>
            <div class="inputExt">
                <input class="inputInt" name=":EMAIL" placeholder="Email" required="" type="text" value='<?php echo($form[":EMAIL"]) ?>'>
                </input>
            </div>
            <div class="inputExt">
                <input class="inputInt" name=":NSS" placeholder="Número de seguridad social" required="" type="text" value='<?php echo($form[":NSS"]) ?>'>
                </input>
            </div>
            <div class="inputExt">
                <input class="inputInt" name=":PSW" placeholder="Contraseña" required="" type="password" value='<?php echo($form[":PSW"]) ?>'>
                </input>
            </div>
            <label>
                <input name=":ADMIN" type="checkbox" value="T">
                    ¿Permisos de administrador?
                </input>
            </label>
            <div class="botonExt">
                <button class="botonInt" type="submit">
                    Contratar
                </button>
            </div>
        </div>
    </form>
</div>





