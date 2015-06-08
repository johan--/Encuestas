<?php
//MAIL BODY
include("../db.php");
session_start();


$query = " SELECT res.`id_encuesta`, res.`id_encuesta_idioma`, res.`id_encuestado`, res.`mail`, res.`cid`, res.`respuesta`, ene.label
FROM  `respuesta` res
left join `encuestas_elemento` ene on (res.cid = ene.codigo and res.`id_encuesta_idioma` = ene.`id_encuesta_idioma`)
WHERE  res.`id_encuesta_idioma` = ".$idEncuestaIdioma."
AND  res.`id_encuestado` = ".$idEncuestado." ;";

	//CONSULTA
	$result=mysqli_query($db,$query);





$mailTo = "kaloye_ale@hotmail.com";

$body = "
<html>
<head>
<title>Mail</title>
</head>
<body style='background:#EEE; padding:30px;'>";
$body .= "</body></html>";

if( strcmp($_name, "") ) //FILES EXISTS
{ 
$fp = fopen($_temp, "rb");
$file = fread($fp, $_size);
$file = chunk_split(base64_encode($file)); 

// MULTI-HEADERS Content-Type: multipart/mixed and Boundary is mandatory.
$headers = "From: Encuestas Info <encuestas@rubraeventos.com.ar>\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: multipart/mixed; "; 
$headers .= "boundary=".$num."\r\n";
$headers .= "--".$num."\n"; 

// HTML HEADERS 
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
$headers .= "Content-Transfer-Encoding: 8bit\r\n";
$headers .= "".$body."\n";
$headers .= "--".$num."\n"; 

// FILES HEADERS 
$headers .= "Content-Type:application/octet-stream "; 
$headers .= "name=\"".$_name."\"r\n";
$headers .= "Content-Transfer-Encoding: base64\r\n";
$headers .= "Content-Disposition: attachment; ";
$headers .= "filename=\"".$_name."\"\r\n\n";
$headers .= "".$file."\r\n";
$headers .= "--".$num."--"; 

}else { //FILES NO EXISTS

// HTML HEADERS
$headers = "From: Encuestas Info <encuestas@rubraeventos.com.ar> \r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
$headers .= "Content-Transfer-Encoding: 8bit\r\n";

} 
$body .= "<DIV style='font-family: 'Helvetica',Arial,sans-serif;'>";
		$body .= "<BR>";
		$body .= "<BR>";
		$body .= "Información de Nueva Encuesta";
		$body .= "<BR>";
		while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){ 
				$body .= "<BR>";
				$body .= "<label ><strong>Pregunta: </strong></label><label style='color: #C32027;' ><strong>Pregunta: ".$row ["label"]."</strong></label>";
				$body .= "<BR>";
				$body .= "<p style='color: #2A272C; padding:0px; margin:0px;' ><strong>Respuesta: </strong>".$row ["respuesta"]."</p>";
				$body .= "<BR>";		
		}
$body .= "</DIV>";
$body .= "</body></html>";

// HTML HEADERS
$headers = "From: Encuestas Info <encuestas@rubraeventos.com.ar> \r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
$headers .= "Content-Transfer-Encoding: 8bit\r\n";




// SEND MAIL
mail($mailTo, "Nueva Encuesta" , $body, $headers);

?>
