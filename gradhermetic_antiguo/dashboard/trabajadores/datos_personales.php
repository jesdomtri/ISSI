<?php $trabajador = $_SESSION["trabajador"][0];

        unset($_SESSION["trabajador"]); ?>
<div class="modal" id="modal-personal">
    <form class="modal-content animate">
        <div class="container-modal">
            <span class="titulo2">
                <h3>Información de <?php echo($trabajador["NOMBRE"]); ?></h3>
            </span>
            <div class="flex">
               <span class="padding-bottom20">DNI: <?php echo($trabajador["DNI"]); ?></span>
            </div>
            <div class="flex">
                <span class="padding-bottom20">Fecha de nacimiento: <?php echo($trabajador["FECHANAC"]); ?></span>
            </div>
            <div class="flex">
               <span class="padding-bottom20">Correo electrónico: <?php echo($trabajador["EMAIL"]); ?></span>
            </div>
                
            <div class="flex">
             <span class="padding-bottom20">Nº SS: <?php echo($trabajador["NSS"]); ?></span>
            </div>

            <div class="flex">
             <span class="padding-bottom20">Contraseña: <?php echo($trabajador["PASS"]); ?></span>
            </div>

            <div class="flex">
             <span class="padding-bottom20">Administrador:
              <?php $admin = $trabajador["ESADMIN"]== 'T' ? 'Sí' : 'No';
              echo($admin); 
              ?></span>
            </div>
            
        </div>
    </form>
                    </div>
<script>
    var modal = document.getElementById('modal-personal');
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
</script>