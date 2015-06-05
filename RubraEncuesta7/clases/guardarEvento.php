<?php
include("db.php");
session_start();


if (isset($_POST["info"])) {

    // Decode our JSON into PHP objects we can use
    $info = json_decode($_POST["info"]);
	$entidad= new stdClass();


    $nombre=$info->nombre; 
	$idCliente=$info->idCliente; 

		$insert="INSERT INTO `eventos` (`nombre`, `idCliente`) VALUES ( '".$nombre."', '".$idCliente."');";
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