<?php
include("db.php");
session_start();


if (isset($_POST["info"])) {

	print_r($_POST["info"]);
	
    // Decode our JSON into PHP objects we can use
    $info = json_decode($_POST["info"]);

    $idEncuesta=$info->ehIdi; 
	$idEncuestaIdioma=$info->ideNC; 
	$respuestas=$info->respuestas;

	//Busco si tiene mail
	$contieneMail="";
	print_r("HOLAS");
	//while( $rta = each($respuestas) && $contieneMail=="" ) {
	foreach ($respuestas as &$rta) {
			print_r("VAN");
		$res=json_decode($rta);
		$cid=$res->cid;
		$valueRta=$res->val;
		$tipoRta=$res->tipo;
		
		print_r($valueRta);

		$tipoRta=$res->tipo;
		
		
		//asi deberia buscar
		//if ($tipoRta== 'mail'){
		//parche hasta que me envie el tipo mail
		$pos = strpos($valueRta, '@');
		if ($pos !== false){
			$contieneMail=$valueRta;
			break;
		}
	}
		print_r("YVIENEN");


	//Inserto datos del encuestado
	$insert="INSERT INTO `respuesta_encuestado` (`mail`, `id_encuesta`, `id_encuesta_idioma`) VALUES ( '".$contieneMail."' , '".$idEncuesta."', '".$idEncuestaIdioma."');";
	//INSERTA
	$result=mysqli_query($db,$insert);
	
	$idEncuestado=mysqli_insert_id($db);;

	foreach ($respuestas as &$rta) {
		$res=json_decode($rta);
		$cid=$res->cid;
		$valueRta=$res->val;
		$tipoRta=$res->tipo;

		$insert="INSERT INTO `respuesta` (`id_encuesta`, `id_encuesta_idioma`,`id_encuestado`, `cid`, `respuesta`, `elemento`) VALUES ( '".$idEncuesta."', '".$idEncuestaIdioma."',  '".$idEncuestado."', '".$cid."', '".$valueRta."', '".$tipoRta."');";
		
		//INSERTA
		$result=mysqli_query($db,$insert);


		
	}


} else {
	print_r ("ERROR");	
}

?>