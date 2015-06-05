<?php
include("db.php");
session_start();
	
ini_set('magic_quotes_runtime', 0);

if (isset($_POST["info"])) {

	
	$info = json_decode($_POST["info"]);
	$id=$info->id;
	
//	$id=11;
	
	//COnsulto
	$selectEn="SELECT en.`id`, en.`idEvento`, ev.nombre nombreEvento, cl.id idCliente , cl.RazonSocial , en.`objetivo`, DATE_FORMAT(en.`fechaInicio`, '%d-%m-%Y') fechaInicio, DATE_FORMAT(en.`fechaFin`, '%d-%m-%Y') fechaFin, en.`rtaMultiple`, en.`logo`, en.`estado` FROM `encuestas` en left outer join eventos ev on (en.idEvento = ev.id) left outer join clientes cl on (cl.id = ev.idCliente) WHERE en.id= '".$id."';";
	//CONSULTA
	$resultEN=mysqli_query($db,$selectEn);

	$rowEN = mysqli_fetch_array($resultEN,MYSQLI_ASSOC);

	
//{"cliente":"34","evento":"33","objetivo":"33","fechaInicio":"07/03/2015","fechaFinal":"05/03/2015","textoFinal":[{"valor":"3","idioma":"2"}],"textoInicial":[{"valor":"3","idioma":"2"}],"id":0,"idiomas":["2"],"form":"{"fields":[{"label":"Sin Titulo","language":"2","field_type":"paragraph","required":true,"field_options":{"size":"small"},"cid":"c2"}]}"}

//{"id":"7","evento":"1","objetivo":"33","fechaInicio":"0000-00-00","fechaFinal":null,"rtaMultiple":"1","textoInicial":[{"idioma":"2","valor":"3"}],"textoFinal":[{"idioma":"2","valor":"3"}],"idiomas":["2"],"fields":[{"cid":"0","field_type":"paragraph","label":"Sin Titulo","language":"2","required":"1","field_option":"{\"size\":\"small\"}","orden":"1"}]}

	$encuesta= new stdClass();
	$encuesta->id=$rowEN["id"];
	$encuesta->evento=$rowEN["idEvento"]; 
	$encuesta->eventoNombre=$rowEN["nombreEvento"];
	$encuesta->clienteId=$rowEN["idCliente"];
	$encuesta->clienteNombre=$rowEN["RazonSocial"];
	$encuesta->objetivo=$rowEN["objetivo"];
	$encuesta->fechaInicio=$rowEN["fechaInicio"];
	$encuesta->fechaFinal=$rowEN["fechaFin"];
	$encuesta->rtaMultiple=$rowEN["rtaMultiple"];


	//COnsulto
	$selectENID="SELECT enid.`id_encuesta_idioma`, enid.`id_encuesta`, enid.`id_idioma`, idi.`nombre` idiomaNombre, enid.`txt_inicio`, enid.`txt_fin`, enid.`link`, enid.`estado` FROM `encuestas_idioma` enid left outer join idioma idi on (idi.id_idioma = enid.id_idioma) WHERE enid.id_encuesta= '".$id."';";
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
		$txtIni['idiomaNombre']=$rowIDIOMA ["idiomaNombre"];
		$txtIni['valor']=$rowIDIOMA ["txt_inicio"];
		$txtFin['idioma']=$rowIDIOMA ["id_idioma"];
		$txtFin['idiomaNombre']=$rowIDIOMA ["idiomaNombre"];
		$txtFin['valor']=$rowIDIOMA ["txt_fin"];
		array_push($textoInicial,$txtIni);
		array_push($textoFinal,$txtFin);
		array_push($idiomas,$rowIDIOMA ["id_idioma"]);
	}	

	$encuesta->textoInicial=$textoInicial;
	$encuesta->textoFinal=$textoFinal;
	$encuesta->idiomas=$idiomas;



	//COnsulto
	$selectENIDCO="SELECT enel.`id`, enel.`id_encuesta_idioma`,enel.`id_encuesta`, enel.`codigo`, enel.`tipo_elemento`, enel.`orden`, enel.`label`, enel.`language`, idi.`nombre` languageNombre, enel.`required`, enel.`field_option` FROM `encuestas_elemento` enel left outer join idioma idi on (idi.id_idioma = language) WHERE enel.id_encuesta= '".$id."' Order by enel.orden,enel.language;";

	//CONSULTA
	$resultENIDCO=mysqli_query($db,$selectENIDCO);


	$elementos=array();
	while($rowELEM = mysqli_fetch_array($resultENIDCO,MYSQLI_ASSOC)){ 
			$elemento=array();
			$elemento['cid']=$rowELEM ["codigo"];
			$elemento['field_type']=$rowELEM ["tipo_elemento"];
			$elemento['label']=$rowELEM ["label"];
			$elemento['language']=$rowELEM ["languageNombre"];
			$elemento['languageID']=$rowELEM ["language"];
			$elemento['required']=$rowELEM ["required"];

			$field_option= new stdClass();
			$field_option= json_decode($rowELEM ["field_option"]);
			$elemento['field_options']=$field_option;
//			$elemento['field_option']=$rowELEM ["field_option"];

			$elemento['orden']=$rowELEM ["orden"];
			array_push($elementos,$elemento);
	}
	$form=array();
	$form['fields']=$elementos;
	
	$encuesta->form=$form;
	
	print_r(json_encode($encuesta));
	
	
}
	



?>