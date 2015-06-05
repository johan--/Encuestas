<?php
include("db.php");
session_start();


$select="SELECT fechaFin, estado FROM  `encuestas` WHERE id = '".$_GET["ehIdi"]."'; ";

	//CONSULTA
	$result=mysqli_query($db,$select);

	$lista=array();
	while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){ 
			$lista['fechaFin']=$row ["fechaFin"];
			$lista['estado']=$row ["estado"];
	}


?>