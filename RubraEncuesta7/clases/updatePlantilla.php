<?php
include("db.php");
session_start();



//if (isset($_POST["info"])) {

	try {  
	
		//desactivo el autocomit
		mysqli_autocommit($db, false);



		// Decode our JSON into PHP objects we can use
//		$info = json_decode($_POST["info"]);
		
		 $info = json_decode('{"cliente":"34","evento":"34","objetivo":"43","fechaInicio":"43","fechaFinal":"34","textoFinal":[{"valor":"43","idioma":"1"},{"valor":"33","idioma":"2"}],"textoInicial":[{"valor":"3","idioma":"2"},{"valor":"43","idioma":"1"}],"id":30,"idiomas":["1","2"],"form":"{\"fields\":[{\"label\":\"Sin Titulo\",\"language\":\"\",\"languageID\":\"1\",\"field_type\":\"dropdown\",\"required\":true,\"field_options\":{\"options\":[{\"label\":\"\",\"checked\":false},{\"label\":\"\",\"checked\":false}],\"include_blank_option\":false},\"cid\":\"c2\"},{\"label\":\"Sin Titulo\",\"language\":\"(Ingles)\",\"languageID\":\"2\",\"field_type\":\"dropdown\",\"required\":true,\"field_options\":{\"options\":[{\"label\":\"\",\"checked\":false},{\"label\":\"\",\"checked\":false}],\"include_blank_option\":false},\"cid\":\"c7\"}]}"}');
		$idPlantilla=$info->id;
		$nombrePlantilla=$info->nombrePlantilla;
		$idiomas=$info->idiomas;
		$controlesArray=json_decode($info->form);
		$controles=$controlesArray->fields;
		
		$update="update `plantillas` SET `nombre`='".$nombrePlantilla."'	 WHERE  `id` ='".$idPlantilla."';";
//		print_r("\n".$update);
		$result=mysqli_query($db,$update);













		/*-1- Modifica el listado de idiomas*/
		/* selecciono los idiomas anteriores*/
		//COnsulto
		$selectENID="SELECT enid.`id_plantilla_idioma`, enid.`id_plantilla`, enid.`id_idioma`, idi.`nombre` idiomaNombre, enid.`txt_inicio`, enid.`txt_fin`, enid.`link`, enid.`estado` FROM `plantillas_idioma` enid left outer join idioma idi on (idi.id_idioma = enid.id_idioma) WHERE enid.id_plantilla= '".$idPlantilla."';";
//				print_r("\n".$update);
		//CONSULTA
		$resultENID=mysqli_query($db,$selectENID);
	
		$idiomasEnBd = array();
		while($rowIDIOMA = mysqli_fetch_array($resultENID,MYSQLI_ASSOC)){ 
			array_push($idiomasEnBd,$rowIDIOMA);
		}

		$idiomasModif=array();
	
		/* -2- Borro todos los controles para el idioma*/
		$delete="DELETE FROM `plantillas_elemento` WHERE id_plantilla= '".$idPlantilla."';";
//				print_r("\n".$delete);
		$result=mysqli_query($db,$delete);
		
		foreach ($idiomas as &$idiomaId) {
	
			$encontroIdioma="false";
			$plantillaIdiomaId=0;
			foreach ($idiomasEnBd as &$rowIDIOMA) {
				if ($idiomaId == $rowIDIOMA['id_idioma'] ){
					$encontroIdioma="true";
					$plantillaIdiomaId=$rowIDIOMA['id_plantilla_idioma'];
				}
			}
	
			if ($encontroIdioma=="false"){
				//si no encontro el idioma en el listado lo agrego	
				$insert="INSERT INTO  `plantillas_idioma` ( `id_plantilla`,`id_idioma`,`txt_inicio`,`txt_fin`,`link`) VALUES ('".$idPlantilla."','".$idiomaId."', '','', 'www.rubraencuestas.com.ar');";
//						print_r("\n".$insert);
				$result=mysqli_query($db,$insert);
	
				/*nombre del link*/
				$plantillaIdiomaId=mysqli_insert_id($db);
				$codigoPlantilla=$plantillaIdiomaId * $plantillaId;
				$link= "http://belasoft.com.ar/encuestarubra/render/examples/encuestaFinal.html?ehIdi=".$idPlantilla."&ideNC=".$plantillaIdiomaId."&eNcIdi=".$codigoPlantilla;
				
				/*Actualizo el link en la BD */
				$updateLink="UPDATE  `plantillas_idioma` SET `codigo_seguridad` =  '".$codigoPlantilla."', `link` =  '".$link."' WHERE `id_plantilla_idioma` = '".$plantillaIdiomaId."';";
//		print_r("\n".$updateLink);
				//Actualiza
				$result=mysqli_query($db,$updateLink);
			}
	
			/* -3- Agrego los controles para el idioma*/
	
			$couentaOrden=1;
	
			foreach ($controles as &$control) {
				$ctrl = 	json_decode($control);
				if ($control->languageID == $idiomaId){
					$insertElem = "INSERT INTO  `plantillas_elemento` (	`id_plantilla_idioma` ,`id_plantilla` ,	`codigo` ,`tipo_elemento` ,	`orden` ,`label` ,`language` ,`required`, `field_option`	)  VALUES ('".$plantillaIdiomaId."', '".$idPlantilla."', '".$control->cid."','".$control->field_type."',  '".$couentaOrden."',  '".$control->label."',  '".$control->languageID."', '".$control->required."', '".(json_encode($control->field_options))."'); ";
//							print_r("\n".$insertElem);
					//Inserta el elemento
					$result=mysqli_query($db,$insertElem);
					
					$couentaOrden++;
				}
			}
	
			//array con data de los idiomas agregados
			$idiomaModif['idIdiomaPlantilla']=$plantillaIdiomaId;
			$idiomaModif['idIdioma']=$idiomaId;
			
			array_push($idiomasModif,$idiomaModif);
			
		}
	///////////////////////////falta borrar idiomas deseleccionado//////////////////////////////////		
			/* -4- Borro los idiomas */
			foreach ($idiomasEnBd as &$rowIDIOMA) {
				$encontroIdioma="false";
				foreach ($idiomas as &$idiomaId) {
					if ($idiomaId == $rowIDIOMA['id_idioma'] ){
						$encontroIdioma="true";
					}
				}
				if 	($encontroIdioma=="false"){
					$delete="DELETE FROM `plantillas_idioma` WHERE id_plantilla_idioma= '".$rowIDIOMA['id_plantilla_idioma']."' ;";
					$result=mysqli_query($db,$delete);
				}
			}

		print_r("ACTUALIZADO CON EXITO");

		mysqli_commit($db);

		
	} catch (Exception $e) {
	  mysqli_rollback($db);
	  print_r ( "Fallo: " . $e->getMessage());
	}
	mysqli_close($db);

//} else {
//	print_r ("ERROR");	
//}

?>