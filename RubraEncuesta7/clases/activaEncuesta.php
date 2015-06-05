<?php
include("db.php");
session_start();

if(isset($_POST["id"]))
{
//	$nombre = $_POST["name"];
	
	$id=$_POST['id']; 


	$delete="UPDATE `encuestas` SET  `estado` =  'A' WHERE  `encuestas`.`id` ='".$id."';";

	//CONSULTA
	$result=mysqli_query($db,$delete);
}

?>