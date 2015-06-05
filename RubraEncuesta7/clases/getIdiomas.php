<?php

	include("db.php");
	session_start();

	
	$select="SELECT `id_idioma`, `nombre`, `tooltip` FROM `idioma` ;";

	//CONSULTA
	$result=mysqli_query($db,$select);

	$listaJson = new stdClass();
	$lista=array();

	
	while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){ 
			$item=array();
			$item['id']=$row ["id_idioma"];
			$item['nombre']=$row ["nombre"];
			$item['tooltip']=$row ["tooltip"];
			array_push($lista,$item);
	}
	$listaJson->idiomas=$lista;
	print_r(json_encode($listaJson));


?>