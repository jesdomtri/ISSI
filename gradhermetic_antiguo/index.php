<?php $rendering =isset($_REQUEST["rend"]) ? $_REQUEST["rend"] : "home.html";
	switch ($rendering) {
		case 'home.html':
			session_reset();
			$title = "Gradhermetic";
			break;
		case 'sobrenosotros.html':
			$title = "Sobre nosotros";
			break;
		case 'contacto.html':
			$title = "Información de contacto";
			break;
		case 'login.php':
			$title = "Inicio de sesión";
			break;
		default:
			session_reset();
			$title = "Gradhermetic";
			$rendering = "home.html";


} ?>

 
<!DOCTYPE html>
<html>
<head>
	<title><?php echo($title);?></title>
	 <meta charset="utf-8" lang="es"></meta>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="estilo.css" rel="stylesheet" type="text/css">
            <link href="https://fonts.googleapis.com/css?family=Courgette|Lobster" rel="stylesheet">
            </link>
        </link>
</head>
<body id="home">
	 <header>
   <div class="top animate-opacity" id="barra">
            <div class="bar wide padding card colores">
                <a class="bar-item boton" href="index.php?rend=home.html">
                    <b>
                        Gradhermetic
                    </b>
                </a>
                <div class="right">
                    <a class="bar-item boton" href="index.php?rend=sobrenosotros.html">
                        Sobre nosotros
                    </a>
                    <a class="bar-item boton" href="index.php?rend=contacto.html">
                        Contacto
                    </a>
                    <a class="bar-item boton" href="index.php?rend=login.php">
                        Entrar
                    </a>
                </div>
            </div>
        </div>

 </header>


<?php require_once($rendering); ?>

<footer>© 2018 Gradhermetic</footer>
</body>
</html>