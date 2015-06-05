<?php
include("db.php");
session_start();
	
if (isset($_POST["info"])) {

	
	$info = json_decode($_POST["info"]);
	$idPlantilla=$info->idPlantilla;
	$idiomasFilter=$info->idiomas;

	
//	$idPlantilla=23;
//	$idiomasFilter=array("1","2","3","4");
	
	//Array donde guardo los id_plantilla_idiomas
	$idiomasPlantilla=array();
	
	//Busco por cada idioma si tiene controles.
	$buscarIdiomaVacio="false";
	
	foreach ($idiomasFilter as &$idiomaId) {
		$selectEn="SELECT en.`id_plantilla_idioma`, en.`id_plantilla` FROM `plantillas_idioma` en WHERE en.estado like 'A' AND en.id_plantilla= '".$idPlantilla."' AND en.id_idioma= '".$idiomaId."' LIMIT 1 ;";
		$result=mysqli_query($db,$selectEn);
		$rowcount=mysqli_num_rows($result);
		
		//Si viene vacio le pongo -1 al id_plantilla_idioma. Sino le pongo el id_plantilla_idioma.
		$idiPlantilla = array();
		$idiPlantilla['idIdioma']=$idiomaId;

		if ($rowcount > 0){
			$rowELEM = mysqli_fetch_array($result,MYSQLI_ASSOC);
			$idiPlantilla['idPlantillaIdioma']=$rowELEM ["id_plantilla_idioma"];
		} else {
			$idiPlantilla['idPlantillaIdioma']=-1;
			//Busco controles vacios para agregar.
			$buscarIdiomaVacio="true";
		}
		// Free result set
		mysqli_free_result($result);

		array_push($idiomasPlantilla,$idiPlantilla);
	}
	
	//pregunto si tengo seleccionado algun idioma que no tiene controles
	$selectControlesVacios="";
	if ($buscarIdiomaVacio == "true"){
		//Obtengo un id_idioma_plantilla de la Plantilla seleccionada
		$select="SELECT en.`id_plantilla_idioma`, en.`id_plantilla` FROM `plantillas_idioma` en WHERE en.estado like 'A' AND en.id_plantilla= '".$idPlantilla."' LIMIT 1 ;";
		$result=mysqli_query($db,$select);
		$rowcount=mysqli_num_rows($result);
		if ($rowcount > 0){
			$rowELEM = mysqli_fetch_array($result,MYSQLI_ASSOC);
			
			$id_plantilla_idioma=$rowELEM["id_plantilla_idioma"];
			//Este query se utilizara para los controles que no tienen idioma.
			$selectControlesVacios="(SELECT enel.`id`, enel.`id_plantilla_idioma`,enel.`id_plantilla`, '0' as `codigo`, enel.`tipo_elemento`, enel.`orden`, enel.`label`, 'languageCODIGO' as language , idi.`nombre` languageNombre, enel.`required`, enel.`field_option` FROM `plantillas_elemento` enel left outer join idioma idi on (idi.id_idioma = languageCODIGO)  WHERE enel.id_plantilla= '".$idPlantilla."' AND enel.id_plantilla_idioma= '".$id_plantilla_idioma."')";
			
			// Free result set
			mysqli_free_result($result);

		} else {
			$selectControlesVacios="(SELECT enel.`id` FROM `plantillas_elemento` WHERE enid.id_plantilla= '-2')";	
		}
	}
	$query="";
	foreach ($idiomasPlantilla as &$idiomaControl) {	
			$querySelectIdioma="";
			
			if ($idiomaControl['idPlantillaIdioma'] > 0){
				$querySelectIdioma="( SELECT enel.`id`, enel.`id_plantilla_idioma`,enel.`id_plantilla`, enel.`codigo`, enel.`tipo_elemento`, enel.`orden`, enel.`label`, enel.`language`, idi.`nombre` languageNombre, enel.`required`, enel.`field_option` FROM `plantillas_elemento` enel left outer join idioma idi on (idi.id_idioma = language)  WHERE enel.id_plantilla= '".$idPlantilla."' AND enel.id_plantilla_idioma= '".$idiomaControl['idPlantillaIdioma']."' )";
			} else {
				$querySelectIdioma = str_replace ( "languageCODIGO" , $idiomaControl['idIdioma'] , $selectControlesVacios );				
			}
			$query = $query.$querySelectIdioma." UNION ALL ";		
	}
	//le saco el ultimo " UNION ALL "
	$query = substr($query, 0, strlen($query)-11);
	//le agrego el orden
	$query = $query." Order by orden,language;";
	
	$result=mysqli_query($db,$query);
	
	$elementos=array();
	while($rowELEM = mysqli_fetch_array($result,MYSQLI_ASSOC)){ 
			$elemento=array();
			$elemento['cid']=$rowELEM ["codigo"];
			$elemento['field_type']=$rowELEM ["tipo_elemento"];
			$elemento['label']=$rowELEM ["label"];
			$elemento['language']=$rowELEM ["languageNombre"];
			$elemento['languageID']=$rowELEM ["language"];
			$elemento['required']=$rowELEM ["required"];
			$elemento['field_options']=$rowELEM ["field_option"];
			$elemento['orden']=$rowELEM ["orden"];
			array_push($elementos,$elemento);
	}
	// Free result set
	mysqli_free_result($result);
	
	$form=array();
	$form['fields']=$elementos;
	
	$controles->form=$form;
	
	
	
	print_r(json_encode($controles));
	
	
}
	
?>