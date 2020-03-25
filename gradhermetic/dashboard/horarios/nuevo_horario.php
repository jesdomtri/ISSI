<?php
if (isset($_SESSION['nuevo_horario'])) {
	$form = $_SESSION['nuevo_horario'];
} else {
	$form = array(':OBID' => '', ':FECHA' => '', ':HORAENTRADA' => '', ':HORASALIDA' => '', ':COSTEDESPLAZAMIENTO' => '');
}
unset($_SESSION['nuevo_horario']);
?>

<div class="modal" id="form-modal">
	<form class="modal-content animate" method="post" action="dashboard.php?rend=horarios/horarios.php&acciones=nuevo_horario&a=ho">
		<div class="container-modal">
			<span class="titulo2">
				Añadir horario
			</span>
			<div class="inputExt">
				<select class="inputInt" name=":OBID" required="">
					<option>---- DIRECCION ----</option>
					<?php 
					require_once '../gestion_funcionesBD.php';
					$query = 'SELECT OBID, DIRECCION FROM OBRAS';
					$obras = consulta($query);
					foreach ($obras as $obra) {
						if ($obra['OBID'] != $form[":OBID"]) {
							echo "<option value=".$obra['OBID'].">".$obra['DIRECCION']."</option>";
						} else {
							echo "<option selected value=".$obra['OBID'].">".$obra['DIRECCION']."</option>";
						}
					}
					?>
				</select>
			</div>
			<div class="inputExt">
				<input class="inputInt" title="Fecha de obra" name=":FECHA" placeholder="Fecha" required="" type="date" value=<?php echo ($form[":FECHA"]); ?>>
			</input>
		</div>
		<div class="inputExt">
			<input class="inputInt" title="Hora entrada" name=":HORAENTRADA" placeholder="Hora de entrada" required="" type="time" value=<?php echo ($form[":HORAENTRADA"]); ?>>
		</input>
	</div>
	<div class="inputExt">
		<input class="inputInt" name=":HORASALIDA" title="Hora salida" placeholder="Hora de salida" required="" type="time" value=<?php echo ($form[":HORASALIDA"]); ?>>
	</input>
</div>
<div class="inputExt">
	<input class="inputInt" name=":COSTEDESPLAZAMIENTO" placeholder="Coste de desplazamiento" required="" type="text" value=<?php echo ($form[':COSTEDESPLAZAMIENTO']); ?>>
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