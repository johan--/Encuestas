<?php
include("db.php");
session_start();
	
if (isset($_POST["info"])) {

	
	$info = json_decode($_POST["info"]);
	$id=$info->id;
	
//	$id=1;
	
	//COnsulto
	$selectEn="SELECT en.`id`, en.`nombre`, en.`estado` FROM `plantillas` en WHERE en.id= '".$id."';";
	//CONSULTA
	$resultEN=mysqli_query($db,$selectEn);

	$rowEN = mysqli_fetch_array($resultEN,MYSQLI_ASSOC);

	$plantilla= new stdClass();
	$plantilla->id=$rowEN["id"];
	$plantilla->nombre=$rowEN["nombre"];
	$plantilla->estado=$rowEN["estado"];

	//COnsulto
	$selectENID="SELECT enid.`id_plantilla_idioma`, enid.`id_plantilla`, enid.`id_idioma`, idi.`nombre` idiomaNombre, enid.`txt_inicio`, enid.`txt_fin`, enid.`link`, enid.`estado` FROM `plantillas_idioma` enid left outer join idioma idi on (idi.id_idioma = enid.id_idioma) WHERE enid.id_plantilla= '".$id."';";
	//CONSULTA
	$resultENID=mysqli_query($db,$selectENID);
	
	$textoFinal=array();
	$textoInicial=array();
	$idiomas=array();

	//PAISES
	while($rowIDIOMA = mysqli_fetch_array($resultENID,MYSQLI_ASSOC)){ 
		$txtIni=array();
		$txtFin=array();
//		$idioma=array();
		$txtIni['idioma']=$rowIDIOMA ["id_idioma"];
		$txtIni['idiomaNombre']=utf8_encode($rowIDIOMA ["idiomaNombre"]);
		$txtIni['valor']=utf8_encode($rowIDIOMA ["txt_inicio"]);
		$txtFin['idioma']=$rowIDIOMA ["id_idioma"];
		$txtFin['idiomaNombre']=utf8_encode($rowIDIOMA ["idiomaNombre"]);
		$txtFin['valor']=utf8_encode($rowIDIOMA ["txt_fin"]);
		array_push($textoInicial,$txtIni);
		array_push($textoFinal,$txtFin);
		array_push($idiomas,$rowIDIOMA ["id_idioma"]);
	}	

//	$plantilla->textoInicial=$textoInicial;
//	$plantilla->textoFinal=$textoFinal;
	$plantilla->idiomas=$idiomas;



	//Consulto
	$selectENIDCO="SELECT enel.`id`, enel.`id_plantilla_idioma`,enel.`id_plantilla`, enel.`codigo`, enel.`tipo_elemento`, enel.`orden`, enel.`label`, enel.`language`, idi.`nombre` languageNombre, enel.`required`, enel.`field_option` FROM `plantillas_elemento` enel left outer join idioma idi on (idi.id_idioma = language) WHERE enel.id_plantilla= '".$id."' Order by enel.orden,enel.language;";

	//CONSULTA
	$resultENIDCO=mysqli_query($db,$selectENIDCO);


	$elementos=array();
	while($rowELEM = mysqli_fetch_array($resultENIDCO,MYSQLI_ASSOC)){ 
			$elemento=array();
			$elemento['cid']=$rowELEM ["codigo"];
			$elemento['field_type']=$rowELEM ["tipo_elemento"];
			$elemento['label']=$rowELEM ["label"];
			$elemento['language']=utf8_encode($rowELEM ["languageNombre"]);
			$elemento['languageID']=$rowELEM ["language"];
			$elemento['required']=$rowELEM ["required"];
			$elemento['field_options']=$rowELEM ["field_option"];
			$elemento['orden']=$rowELEM ["orden"];
			array_push($elementos,$elemento);
	}
	$form=array();
	$form['fields']=$elementos;
	
	$plantilla->form=$form;
	
	print_r(json_encode($plantilla));
	
	
}
	
?>