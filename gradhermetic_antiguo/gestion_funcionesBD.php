<?php 

function crearConexionBD(){ 
	$host="oci:dbname=localhost/XE;charset=UTF8";
	$usuario="gradhermetic";
	$password="12345";
	try {	$conexion=new PDO($host,$usuario,$password); 	
			$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOException $e){
	 echo "Error al conectar la base de datos: $e->getMessage()"; 
	}
	return $conexion;
}

function cerrarConexionBD($conexion){
 		$conexion=null;	
}

function checkCredentials($user, $pass){
	$conexion = crearConexionBD();
	$stm = "SELECT DNI,NOMBRE,PASS,ESADMIN FROM TRABAJADORES WHERE EMAIL='".$user."'";
	$passBD = $conexion->query($stm)->fetch(PDO::FETCH_ASSOC);

	$return['nombre'] = $passBD['NOMBRE'];
	$return['check'] = $passBD['PASS'] == $pass;
	$return['admin'] = $passBD['ESADMIN'];
	$return['DNI'] = $passBD['DNI'];
	cerrarConexionBD($conexion);
	return $return;
}

function consultaPaginada($consulta, $page, $tam){
	//Funcion que recibe una consulta($consulta) sobre una tabla, la pagina que se desea visitar($page) y el numero de elementos por pagina ($tam)
	$first = 1 +($page -1)*$tam;
	$last = ($page * $tam);
	
	$consulta_paginada= "SELECT * FROM (SELECT rownum R, X.* FROM ($consulta) X) WHERE R BETWEEN $first AND $last";
	$conexion = crearConexionBD();
	$ret = $conexion->query($consulta_paginada)->fetchAll(PDO::FETCH_ASSOC);
	cerrarConexionBD($conexion);
	return $ret;
}

function consulta($consulta){
	$conexion = crearConexionBD();
	try{
	$ret = $conexion->query($consulta)->fetchAll(PDO::FETCH_ASSOC);
	return $ret;
	}catch(PDOException $e){
	gestionErrores($e);
	
	}
	cerrarConexionBD($conexion);
	
}

function gestionErrores($e){
   $code = $e->getCode();
   $message = $e->getMessage();
   echo("<div id=err class=errores ><h3>Ha ocurrido el siguiente error: $code <br> Mensaje error: $message</h3></div>");
}

function consultaTotalFilas($consulta){
	$conexion = crearConexionBD();
	$consulta = "SELECT COUNT(*) TOTAL FROM (".$consulta.")";
	$ret = $conexion->query($consulta)->fetch()['TOTAL'];
	cerrarConexionBD($conexion);
	return $ret;
}

function formateoFechas($fecha){
	$ret = date('Y-m-d', strtotime($fecha));
	return $ret;
}

function formateoHoras($hora){
	$res = time('H:m',strtotime($hora));
	return $res;
}


function realizarProcedimiento($query, $params){
	$conexion = crearConexionBD();
	try{

	$stm = $conexion->prepare($query);
	if($params != 'none'){
		foreach ($params as $key => $value) {
		$stm->bindParam($key, $params[$key]);
		}
	}
	
	$stm->execute();
	return true;

	}catch(PDOException $e){
		gestionErrores($e);
         return false;
	}//Hay que meter todo los accesos a la base de datos en un try catch, capturar el error y tratarlo.
	cerrarConexionBD($conexion);
}
?>