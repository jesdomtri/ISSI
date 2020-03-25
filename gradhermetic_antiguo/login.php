<?php 
 echo("<script src='script_login.js'></script>");
  session_start();
  $email ="";
 if(isset($_SESSION['LOGIN'])){
  $login = $_SESSION['LOGIN'];
  $email = $login['email'];
  unset($_SESSION['LOGIN']);

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
      <input type="email" autofocus placeholder="Email" id="email" name="email" class="inputInt" required value="<?php echo($email);?>">

     </div>
   
     <div class="inputExt">
      <input type="password" placeholder="Insertar contraseña" name="psw" class="inputInt" required>
     </div>

     <div class="botonExt">
      <button type=submit class="botonInt">Entrar</button>
     </div><br>

     <label>
      <input type="checkbox" checked="checked" name="recordar"> Recuérdame
     </label><br><br><br>

     <div class="text-center">
      <span class="txt1">
       ¿Olvidaste 
      </span>
      <a class="txt2" href="#">
       la contraseña?
      </a>
     </div>

    </div>
    
   </form>

  </div>
 </div>

