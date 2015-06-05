<?php
include("db.php");
session_start();

if(isset($_POST["id"]))
{
//	$nombre = $_POST["name"];
	
	$id=$_POST['id']; 


	$delete="DELETE FROM `encuestas` WHERE `id` = '".$id."'; ";

	//CONSULTA
	$result=mysqli_query($db,$delete);
}

?>