<?php
include("db.php");
session_start();

if (isset($_POST["info"])) {
	$info = json_decode($_POST["info"]);
	
	$id=$info->idCliente; 
	
	$select="SELECT `Id`, `Nombre`, `idCliente`, `Descripcion`, `FechaInicio`, `FechaFin`, `Estado` FROM `eventos` WHERE idCliente = '".$id."' AND `Estado` like 'A'; ";
	
		//CONSULTA
		$result=mysqli_query($db,$select);
	
		$listaJson = new stdClass();
		$lista=array();
		while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){ 
				$item=array();
				$item['id']=$row ["Id"];
				$item['label']=$row ["Nombre"];
				$item['idCliente']=$row ["idCliente"];
				$item['descripcion']=$row ["Descripcion"];
				$item['fechaInicio']=$row ["FechaInicio"];
				$item['fechaFin']=$row ["FechaFin"];
				$item['estado']=$row ["Estado"];
				array_push($lista,$item);
		}
		$listaJson->eventos=$lista;
		print_r(json_encode($listaJson));	

}

?>