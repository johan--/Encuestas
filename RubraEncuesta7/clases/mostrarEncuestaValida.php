<?php
include("db.php");
session_start();

$select=" SELECT en.fechaFin, en.estado , eve.`imagen_ruta` imagen_ruta_eve , eve.`imagen_nombre` imagen_nombre_eve, cli.`imagen_ruta` imagen_ruta_cli , cli.`imagen_nombre` imagen_nombre_cli FROM  `encuestas` en  left join `eventos` eve on (eve.id = en.idEvento) left join `clientes` cli on (eve.`idCliente` = cli.id) WHERE en.id = '".$_GET["ehIdi"]."'; ";

	//CONSULTA
	$result=mysqli_query($db,$select);

	$lista=array();
	while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){ 
			$lista['fechaFin']=$row ["fechaFin"];
			$lista['estado']=$row ["estado"];
			$lista['imagen_ruta_eve']=$row ["imagen_ruta_eve"];
			$lista['imagen_nombre_eve']=$row ["imagen_nombre_eve"];
			$lista['imagen_ruta_cli']=$row ["imagen_ruta_cli"];
			$lista['imagen_nombre_cli']=$row ["imagen_nombre_cli"];
	}


?>
