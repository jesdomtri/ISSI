<?php

if (isset($_SESSION['nuevo_vehiculo'])) {
	$form = $_SESSION['nuevo_vehiculo'];
} else {
	$form = array(':MATRICULA' => '', ':MODELO' => '', ':COLOR' => '');
}
unset($_SESSION['nuevo_vehiculo']);
?>

<div class="modal" id="form-modal">
	<form class="modal-content animate" method="post" action="dashboard.php?rend=vehiculos/vehiculos.php&acciones=nuevo_vehiculo&a=ve">
		<div class="container-modal">
			<span class="titulo2">
				Añadir vehículo
			</span>
			<div id="erroresForm">
            </div>
			<div class="inputExt">
				<input id=matricula class="inputInt" name=":MATRICULA" placeholder="Matrícula" required="" type="text" value=<?php echo ($form[":MATRICULA"]); ?>>
			</input>
		</div>
		<div class="inputExt">
			<input class="inputInt" name=":MODELO" placeholder="Modelo" required="" type="text" value=<?php echo ($form[":MODELO"]); ?>>
		</input>
	</div>
	<div class="inputExt">
		<input class="inputInt" name=":COLOR" placeholder="Color" required="" type="text" value=<?php echo ($form[":COLOR"]); ?>>
	</input>
</div>
<div class="botonExt">
	<button class="botonInt" type="submit">
		Añadir
	</button>
</div>
</div>
</form>
</div>