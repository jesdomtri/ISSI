<?php
session_start();
if(isset($_POST['email'])){

	require_once("gestion_funcionesBD.php");
	$credentials = checkCredentials($_POST['email'], $_POST['psw']);
	$login['email'] =$_POST['email'];
	echo($login['email']);
	$login['nombre']=$credentials['nombre'];
	$login['check'] = $credentials['check'];
	$login['admin'] = $credentials['admin'];
	$login['DNI'] = $credentials['DNI'];
	print_r($login);
	$_SESSION['LOGIN'] = $login;

	if($credentials['check']){
		header("Location:dashboard/dashboard.php");
	}else{
		header("Location:index.php?rend=login.php");
	}
}else{
	header("Location:index.php?rend=login.php");
}

?>