<?php
include("db.php");
session_start();
	
if (isset($_POST["info"])) {
	$info = json_decode($_POST["info"]);
//   $info = json_decode('{"cliente":"34","evento":"34","objetivo":"43","fechaInicio":"43","fechaFinal":"34","textoFinal":[{"valor":"43","idioma":"1"},{"valor":"33","idioma":"2"}],"textoInicial":[{"valor":"3","idioma":"2"},{"valor":"43","idioma":"1"}],"id":0,"idiomas":["1","2","3"],"form":"{\"fields\":[{\"label\":\"Sin Titulo\",\"language\":\"\",\"languageID\":\"1\",\"field_type\":\"dropdown\",\"required\":true,\"field_options\":{\"options\":[{\"label\":\"\",\"checked\":false},{\"label\":\"\",\"checked\":false}],\"include_blank_option\":false},\"cid\":\"c2\"},{\"label\":\"Sin Titulo\",\"language\":\"(Ingles)\",\"languageID\":\"2\",\"field_type\":\"dropdown\",\"required\":true,\"field_options\":{\"options\":[{\"label\":\"\",\"checked\":false},{\"label\":\"\",\"checked\":false}],\"include_blank_option\":false},\"cid\":\"c7\"}]}"}');


	$idEncuesta=$info->idEncuesta;
	$idiomasSeleccionados=$info->idiomas;

	$controlesArray=json_decode($info->form);
	$controles=$controlesArray->fields;
	
	//Guardo el idioma Principal para saber que cambia de pregunta	
		$idiomaPrincipalId="";
		//obtengo el primer control
		$control = $controles[0];
		$ctrl = json_decode($control);
		//seteo el idioma principal
		$idiomaPrincipalId=$control->languageID;

	
//	print_r("\nidiomaPrincipalId: ".	$idiomaPrincipalId);
//	print_r("\nidiomasSeleccionados: ".	$idiomasSeleccionados);	
	//Voy a recorrer los idiomas de los controles para saber cuales son los idiomas que tengo agregados
 	 
	$idiomasEnControlesEncuesta=array();
	$controlesPorIdiomasEncontrados = array();	
	foreach ($controles as &$control) {
		$ctrl = 	json_decode($control);
		foreach ($idiomasSeleccionados as &$idiomaId) {
			if ($control->languageID == $idiomaId) {
				$agregoIdioma ="true";
				//reviso en la lista si ya lo agegue
				foreach ($idiomasEnControlesEncuesta as &$idiomaAgregadoId) {
					if ($idiomaAgregadoId == $idiomaId){
						$agregoIdioma ="true";
					}
				}
				if ($agregoIdioma == "true"){
					array_push($idiomasEnControlesEncuesta,$idiomaId);
				}
				//Si pertenece a un idioma encontrado lo agrego a la nueva lista de controles
				array_push(	$controlesPorIdiomasEncontrados , $control);
			} 
		}
	}
	
//	print_r("\nidiomasEnControlesEncuesta: ".	$idiomasEnControlesEncuesta);
	
	//Ahora obtengo los ids de idiomas seleccionados que no tengo controles
	$idiomasNoSeleccionados=array();
	foreach ($idiomasSeleccionados as &$idiomaId) {
//		print_r("\nIdioma de turno: ".	$idiomaId);	
		$idiomaEncontrado="false";
		foreach ($idiomasEnControlesEncuesta as &$idiomaAgregadoId) {
//			print_r("\n Compara Idioma de turno: ".	$idiomaId."n con Idioma agregado: ".$idiomaAgregadoId);	
			if ($idiomaId == $idiomaAgregadoId){
				$idiomaEncontrado="true";
			}
		}
		if 	($idiomaEncontrado=="false"){
//			print_r("\nAgrega idioma: ".	$idiomaId);	
			array_push($idiomasNoSeleccionados,$idiomaId);
		}
	}
//	print_r("\nidiomasEnControlesEncuesta: ".	$idiomasNoSeleccionados);
	
	/* Primero pregunto si hay nuevos idiomas, si no ha igual la lista final a controlesPorIdiomasEncontrados */

//print_r("HOLA");
//print_r($controlesPorIdiomasEncontrados);
//print_r("CHAU");


	//recorro los controles
	//$primerElemento == false;
	$controlesFinal = array();	
	foreach ($controlesPorIdiomasEncontrados as &$control) {
		$ctrl = 	json_decode($control);

		//Agrego el primer elemento si es del idioma principal Id
		if ($control->languageID == $idiomaPrincipalId) {
			array_push($controlesFinal,$control);
			
			foreach ($idiomasNoSeleccionados as &$idiomaNoAgregadoId) {
				$ctrlCopy= new stdClass();
				$ctrlCopy->label=$control->label;
				$ctrlCopy->language=""; 
				$ctrlCopy->languageID=$idiomaNoAgregadoId;
				$ctrlCopy->field_type=$control->field_type;
				$ctrlCopy->required=$control->required;
				$ctrlCopy->field_options=$control->field_options;
				$ctrlCopy->cid=$control->cid;
				array_push($controlesFinal,$ctrlCopy);
			}
		} else {
			array_push($controlesFinal,$control);
		}
	}


	print_r(json_encode($controlesFinal));
	
	
}
	
?>