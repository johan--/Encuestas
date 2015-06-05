<?php
include("db.php");
session_start();

$select="SELECT `id`, `nombre`,`estado` FROM `plantillas` WHERE `Estado`='A'; ";

	//CONSULTA
	$result=mysqli_query($db,$select);

	$listaJson = new stdClass();
	$lista=array();
	while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){ 
			$item=array();
			$item['id']=$row ["id"];
			$item['label']=$row ["nombre"];
			$item['estado']=$row ["estado"];
			array_push($lista,$item);
	}
	$listaJson->plantillas=$lista;
	print_r(json_encode($listaJson));	

?>