<?php
include("db.php");
session_start();


if (isset($_POST["info"])) {
	
    // Decode our JSON into PHP objects we can use
    $info = json_decode($_POST["info"]);
	$entidad= new stdClass();

    $razonSocial=$info->nombre; 
	$comentario=$info->comentario; 

		$insert="INSERT INTO `clientes` (`RazonSocial`, `Comentario`) VALUES ( '".$razonSocial."', '".$comentario."');";
		//INSERTA
		$result=mysqli_query($db,$insert);

		//obtengo el id ingresado
		$id=mysqli_insert_id($db);
		$entidad->id=$id;
	    print_r(json_encode($entidad));	


} else {
	print_r ("ERROR");	
}

?>