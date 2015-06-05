<?php
include("clases/db.php");
session_start();

	$id1="asd";

  $ar=fopen("../encuesta/datos.php","a") or
    die("Problemas en la creacion de la encuesta");
  fputs($ar,'<?php include("clases/db.php"); session_start();');
  fputs($ar,"\n");
  fputs($ar,' $id= "'.$id1.'"; ');
  fputs($ar,' $id= "'.$id1.'"; ');

  fputs($ar,"\n");
  fputs($ar,"--------------------------------------------------------");
  fputs($ar,"\n");
  fclose($ar);


?>