<?php
echo ("<script src='script_login.js'></script>");
session_start();
$email = "";
if (isset($_SESSION['LOGIN'])) {
  $login = $_SESSION['LOGIN'];
  $email = $login['email'];
  $error = $login['error'];

  if ($error == 'bad_user') {
        //NOMBRE DE USUARIO INCORRECTO
    $mensaje_error = "El usuario introducido no existe";
  } else if ($error == 'bad_psw') {
        //MALA CONTRASEÑA
    $mensaje_error = "La contraseña es incorrecta";

  }
}

?>

<div id="login" class="limitador">
  <div class="container">
   <div class="containerInt">

    <div class="imagen">
     <img src="https://cdn1.iconfinder.com/data/icons/fs-icons-ubuntu-by-franksouza-/512/goa-account-msn.png" width="200" height="200" class="imagen" data-tilt>
   </div>


   <form action="gestion_login.php" method="post">

     <span class="titulo">
      Iniciar sesión
    </span>

    <div class="inputExt">
     <?php if (isset($mensaje_error)) {
      echo "<div class=error id=err>" . $mensaje_error . "</div>";
    }?>
    <input type="email" autofocus placeholder="Email" id="email" name="email" class="inputInt" required value="<?php echo ($email); ?>">

  </div>

  <div class="inputExt">

    <input type="password" placeholder="Insertar contraseña" name="psw" class="inputInt" required>
  </div>

  <div class="botonExt">
    <input type=submit class="botonInt" value=Entrar></input>


  </div><br>


</div>

</form>

</div>
</div>

