<?php
include("db.php");
session_start();


if (isset($_POST["info"])) {

//print_r ($_POST["info"]);

    // Decode our JSON into PHP objects we can use
    $info = json_decode($_POST["info"]);

 //   $info = json_decode('{"cliente":"34","evento":"34","objetivo":"43","fechaInicio":"43","fechaFinal":"34","textoFinal":[{"valor":"43","idioma":"1"},{"valor":"33","idioma":"2"}],"textoInicial":[{"valor":"3","idioma":"2"},{"valor":"43","idioma":"1"}],"id":0,"idiomas":["1","2"],"form":"{\"fields\":[{\"label\":\"Sin Titulo\",\"language\":\"\",\"languageID\":\"1\",\"field_type\":\"dropdown\",\"required\":true,\"field_options\":{\"options\":[{\"label\":\"\",\"checked\":false},{\"label\":\"\",\"checked\":false}],\"include_blank_option\":false},\"cid\":\"c2\"},{\"label\":\"Sin Titulo\",\"language\":\"(Ingles)\",\"languageID\":\"2\",\"field_type\":\"dropdown\",\"required\":true,\"field_options\":{\"options\":[{\"label\":\"\",\"checked\":false},{\"label\":\"\",\"checked\":false}],\"include_blank_option\":false},\"cid\":\"c7\"}]}"}');


	//ENcuesta
//	$ClienteId=mysqli_real_escape_string($db,$info["cliente"]); 
	$ClienteId=$info->cliente; 
//	$EventoId=mysqli_real_escape_string($db,$info["evento"]); 
	$EventoId=$info->evento; 
	$objetivoStr=$info->objetivo; 
	$fInicio=mysqli_real_escape_string($db,$info->fechaInicio); 
	$fFin=mysqli_real_escape_string($db,$info->fechaFinal); 
	$txtIniciales=$info->textoInicial; 
	$txtFinales=$info->textoFinal; 
	$idiomas=$info->idiomas;
	$controles=$controlesArray->fields;
	$nombrePlantilla=$info->nombrePlantilla;

	$controlesArray=json_decode($info->form);
	$controles=$controlesArray->fields;

/*	print_r("\nIDIOMAS\n");
	print_r($idiomas);
	print_r("\nIDIOMAS\n");
//	print_r($idiomasArray);
	print_r("\nCONTROLES\n");
	print_r($controles)	;
	print_r("rochas\n");
*/	//Creo la encuesta
	$insert="INSERT INTO  `encuestas` ( `idEvento`)	VALUES ('".$EventoId."');";
//		print_r($insert);
	//INSERTA
	$result=mysqli_query($db,$insert);
	//Guarda el id de la encuesta ingresada
	$encuestaIngresadaId=mysqli_insert_id($db);

	//MODIFICAR valores de la encuesta
	$fchIni = date('d-m-Y', strtotime(str_replace('/', '-', $fInicio)));
	$fchFin = date('d-m-Y', strtotime(str_replace('/', '-', $fFin)));
	
	//$fecha = date_create_from_format('j-M-Y', '15-Feb-2009');
 //   echo date_format($fecha, 'Y-m-d');
	$fecha =date_format($fchIni, 'Y-m-d');

	$update="UPDATE `encuestas` SET `idEvento`= '".$EventoId."' , `objetivo`= '".$objetivoStr."' , `fechaInicio`= STR_TO_DATE('".$fchIni."', '%d-%m-%Y') ,`fechaFin`= STR_TO_DATE('".$fchFin."', '%d-%m-%Y') ,`rtaMultiple`= '1' WHERE id= '".$encuestaIngresadaId."';";
	
//	print_r($update);
//print_r($update);
//		print_r("update\n");
//		print_r($update);
	//Actualiza
	$result=mysqli_query($db,$update);


	//almaceno los links de respuesta
	$urls=array();
  	//Recorro los idiomas.
	//inserto en la tabla de idiomas
	//inserto en la tabla de controles para cada idioma
	foreach ($idiomas as &$idiomaId) {
		//Selecciono los textos iniciales y finales
		$txtIni="vacio";
		$txtFin="vacio";
		foreach ($txtIniciales as &$txt) {
			if ($txt->idioma == $idiomaId){
				$txtIni = $txt->valor;
			}
		}
		foreach ($txtFinales as &$txt) {
			if ($txt->idioma == $idiomaId){
				$txtFin = $txt->valor;
			}
		}
		//Inserto el Idioma
		$insert="INSERT INTO  `encuestas_idioma` ( `id_encuesta`,`id_idioma`,`txt_inicio`,`txt_fin`,`link`) VALUES ('".$encuestaIngresadaId."','".$idiomaId."','".$txtIni."','".$txtFin."','www.rubraencuestas.com.ar');";
//		print_r($insert);
		//INSERTA
		$result=mysqli_query($db,$insert);
		//Guarda el id de la encuesta_idioma
		$encuestaIdiomaId=mysqli_insert_id($db);

		//Recorro el formulario para obtener los controles por idioma
		$idiomaNombre="";
		$couentaOrden=1;
		foreach ($controles as &$control) {
			$ctrl = 	json_decode($control);
			if ($control->languageID == $idiomaId){
				$idiomaNombre=$control->language;
				$insertElem = "INSERT INTO  `encuestas_elemento` (	`id_encuesta_idioma` ,`id_encuesta` ,	`codigo` ,`tipo_elemento` ,	`orden` ,`label` ,`language` ,`required`, `field_option`	)  VALUES ('".$encuestaIdiomaId."', '".$encuestaIngresadaId."', '".$control->cid."','".$control->field_type."',  '".$couentaOrden."',  '".$control->label."',  '".$control->languageID."', '".$control->required."', '".(json_encode($control->field_options))."'); ";
				//Inserta el elemento
				$result=mysqli_query($db,$insertElem);
				
				$couentaOrden++;
			}
		}
	
		/*************    GENERAR LINK  	****************/
		/*nombre del evento*/
//		$select="SELECT * FROM `evento` WHERE `Id` = '".$EventoId."'; ";
//		$result=mysqli_query($db,$select);
	
//		$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
//		$nombreEvento=$row['nombre'];
		
		/*nombre del link*/
		$url["idiomaNombre"]=$idiomaNombre;
		$url["idiomaId"]=$idiomaId;
		$codigoEncuesta=$encuestaIdiomaId * $encuestaIngresadaId;
		$link= "http://belasoft.com.ar/encuestarubra/render/examples/encuestaFinal.php?ehIdi=".$encuestaIngresadaId."&ideNC=".$encuestaIdiomaId."&eNcIdi=".$codigoEncuesta;
		$url["link"]=$link;
		
		array_push($urls,$url);
		
		/*Actualizo el link en la BD */
		$updateLink="UPDATE  `encuestas_idioma` SET `codigo_seguridad` =  '".$codigoEncuesta."', `link` =  '".$link."' WHERE `id_encuesta_idioma` = '".$encuestaIdiomaId."';";
		//Actualiza
		$result=mysqli_query($db,$updateLink);


	} 
	
	if ( ! empty( trim($nombrePlantilla))){
		//Si el nombre de la plantilla no esta vació, guardo la plantilla.
		include("guardarPlantilla.php");
	}
		
	print_r(json_encode($urls));

} else {
	print_r ("ERROR");	
}

?>