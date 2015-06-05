<?php
include("db.php");
session_start();



if (isset($_POST["info"])) {

    // Decode our JSON into PHP objects we can use
   $info = json_decode($_POST["info"]);

//   $info = json_decode('{"cliente":"34","evento":"34","objetivo":"43","fechaInicio":"43","fechaFinal":"34","textoFinal":[{"valor":"43","idioma":"1"},{"valor":"33","idioma":"2"}],"textoInicial":[{"valor":"3","idioma":"2"},{"valor":"43","idioma":"1"}],"id":0,"idiomas":["1","2"],"form":"{\"fields\":[{\"label\":\"Sin Titulo\",\"language\":\"\",\"languageID\":\"1\",\"field_type\":\"dropdown\",\"required\":true,\"field_options\":{\"options\":[{\"label\":\"\",\"checked\":false},{\"label\":\"\",\"checked\":false}],\"include_blank_option\":false},\"cid\":\"c2\"},{\"label\":\"Sin Titulo\",\"language\":\"(Ingles)\",\"languageID\":\"2\",\"field_type\":\"dropdown\",\"required\":true,\"field_options\":{\"options\":[{\"label\":\"\",\"checked\":false},{\"label\":\"\",\"checked\":false}],\"include_blank_option\":false},\"cid\":\"c7\"}]}"}');

	$nombrePlantilla=$info->nombrePlantilla;
	$idiomas=$info->idiomas;
	$controles=$controlesArray->fields;

	$controlesArray=json_decode($info->form);
	$controles=$controlesArray->fields;

	$insert="INSERT INTO  `plantillas` ( `nombre`)	VALUES ('".$nombrePlantilla."');";
//		print_r($insert);
	//INSERTA
	$result=mysqli_query($db,$insert);
	//Guarda el id de la plantilla ingresada
	$plantillaIngresadaId=mysqli_insert_id($db);

	//almaceno los links de respuesta
	$urlsPlantilla=array();
  	//Recorro los idiomas.
	//inserto en la tabla de idiomas
	//inserto en la tabla de controles para cada idioma
	foreach ($idiomas as &$idiomaId) {
		//Inserto el Idioma
		$insert="INSERT INTO  `plantillas_idioma` ( `id_plantilla`,`id_idioma`,`link`) VALUES ('".$plantillaIngresadaId."','".$idiomaId."','www.rubraencuestas.com.ar');";
//		print_r($insert);
		//INSERTA
		$result=mysqli_query($db,$insert);
		//Guarda el id de la plantilla_idioma
		$plantillaIdiomaId=mysqli_insert_id($db);

		//Recorro el formulario para obtener los controles por idioma
		$idiomaNombre="";
		$couentaOrden=1;
		
		foreach ($controles as &$control) {
		//	print_r($control);
			$ctrl = 	json_decode($control);
			if ($control->languageID == $idiomaId){
				$idiomaNombre=$control->language;
				$insertElem = "INSERT INTO  `plantillas_elemento` (	`id_plantilla_idioma` ,`id_plantilla` ,	`codigo` ,`tipo_elemento` ,	`orden` ,`label` ,`language` ,`required`, `field_option`	)  VALUES ('".$plantillaIdiomaId."', '".$plantillaIngresadaId."', '".$control->cid."','".$control->field_type."',  '".$couentaOrden."',  '".$control->label."',  '".$control->languageID."', '".$control->required."', '".(json_encode($control->field_options))."'); ";
				//Inserta el elemento
				$result=mysqli_query($db,$insertElem);
				
				$couentaOrden++;
			}
		}
	
		/*************    GENERAR LINK  	****************/
		/*nombre del link*/
		$urlPlantilla["idiomaNombre"]=$idiomaNombre;
		$urlPlantilla["idiomaId"]=$idiomaId;
		$linkPlantilla= "http://belasoft.com.ar/encuestarubra/render/examples/encuestaFinal.html?ehIdi=".$idiomaId."&ideNC=".$plantillaIngresadaId.";";
		$urlPlantilla["link"]=$linkPlantilla;
		
		array_push($urlsPlantilla,$urlPlantilla);
		
		/*Actualizo el link en la BD */
		$updateLinkPlantilla="UPDATE  `plantillas_idioma` SET `link` =  '".$linkPlantilla."' WHERE `id_plantilla_idioma` = '".$plantillaIdiomaId."';";
		//Actualiza
		$result=mysqli_query($db,$updateLinkPlantilla);


	} 
		
//	print_r(json_encode($urls));

} else {
	print_r ("ERROR");	
}

?>