<?php
session_start();
if (isset($_POST['email'])) {

    require_once "gestion_funcionesBD.php";

    //Recuperamos el usuario y lo guardamos en la sesion.
    $login['email'] = $_POST['email'];

    //Comprobamos las credenciales de acceso
    $credentials = checkCredentials($_POST['email'], $_POST['psw']);

    $login['nombre']   = $credentials['nombre'];
    $login['check']    = $credentials['check'];
    $login['admin']    = $credentials['admin'];
    $login['DNI']      = $credentials['DNI'];
    $login['error']    = $credentials['usuario'];
    $_SESSION['LOGIN'] = $login;

    if ($credentials['check']) {

        header("Location:dashboard/dashboard.php");

    } else {
        //La contraseña no coincide con el usuario
        if ($_SESSION['LOGIN']['error'] == "user_ok") {
            $_SESSION['LOGIN']['error'] = "bad_psw";
        }

        header("Location:index.php?rend=login.php");
    }

} else {
    header("Location:index.php?rend=login.php");
}
