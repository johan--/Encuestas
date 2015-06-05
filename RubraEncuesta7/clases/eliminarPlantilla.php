<?php
include("db.php");
session_start();

if(isset($_POST["id"]))
{
//	$nombre = $_POST["name"];
	print_r("nombre");	
	$id=$_POST['id']; 
	print_r($id);

	$delete="DELETE FROM `plantillas` WHERE `id` = '".$id."'; ";

	//CONSULTA
	$result=mysqli_query($db,$delete);
}

?>