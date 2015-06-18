<?php
include("db.php");
session_start();

$select="SELECT `Id`, `RazonSocial`, `ImagenLogo`, `Comentario`,`imagen_ruta`,`imagen_nombre`, `Estado` FROM `clientes` WHERE `Estado`='A'; ";

	//CONSULTA
	$result=mysqli_query($db,$select);

	$listaJson = new stdClass();
	$lista=array();
	while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){ 
			$item=array();
			$item['id']=$row ["Id"];
			$item['label']=$row ["RazonSocial"];
			//$item['ImagenLogo']=$row ["ImagenLogo"];
			$item['comentario']=$row ["Comentario"];
			$item['imagen_ruta_cli']=$row ["imagen_ruta"];
			$item['imagen_nombre_cli']=$row ["imagen_nombre"];				
			$item['estado']=$row ["Estado"];
			array_push($lista,$item);
	}
	$listaJson->clientes=$lista;
	print_r(json_encode($listaJson));	

?>
