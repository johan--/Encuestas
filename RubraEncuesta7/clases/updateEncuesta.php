<?php
include("db.php");

session_start();

try {

//desactivo el autocomit
mysqli_autocommit($db, false);

	if (isset($_POST["info"])) {

		$info = json_decode($_POST["info"]);

	   //$info = json_decode('{"id":"18","nombrePlantilla":"","objetivo":"testear","fechaInicio":"10/10/2013","fechaFinal":"10/10/2015","textoFinal":[{"valor":"cambio9","idioma":"3"},{"valor":"cambio4","idioma":"2"}],"textoInicial":[{"valor":"cambio1","idioma":"2"},{"valor":"cambio5","idioma":"3"}],"idiomas":["3","2"],"form":"{\"fields\":[{\"label\":\"Sin Titulo\",\"language\":\"\",\"languageID\":\"3\",\"field_type\":\"dropdown\",\"required\":true,\"field_options\":{\"options\":[{\"label\":\"\",\"checked\":false},{\"label\":\"\",\"checked\":false}],\"include_blank_option\":false},\"cid\":\"c2\"},{\"label\":\"Sin Titulo\",\"language\":\"(Ingles)\",\"languageID\":\"2\",\"field_type\":\"dropdown\",\"required\":true,\"field_options\":{\"options\":[{\"label\":\"\",\"checked\":false},{\"label\":\"\",\"checked\":false}],\"include_blank_option\":false},\"cid\":\"c7\"}]}"}');

		$idiomas=$info->idiomas;
		$idEncuesta=$info->id;
		$objetivoStr=$info->objetivo;
		$fInicio=mysqli_real_escape_string($db,$info->fechaInicio);
		$fFin=mysqli_real_escape_string($db,$info->fechaFinal);
		$txtIniciales=$info->textoInicial;
		$txtFinales=$info->textoFinal;

		$controlesArray=json_decode($info->form);
		$controles=$controlesArray->fields;
		$nombrePlantilla=$info->nombrePlantilla;

		//MODIFICAR valores de la encuesta
		$fchIni = date('d-m-Y', strtotime(str_replace('-', '/', $fInicio)));
		$fchFin = date('d-m-Y', strtotime(str_replace('-', '/', $fFin)));

		/*-0- Modifica datos de la encuesta */
		$update="UPDATE `encuestas` SET `objetivo`= '".$objetivoStr."' , `fechaInicio`= STR_TO_DATE('".$fchIni."', '%d-%m-%Y')  ,`fechaFin`= STR_TO_DATE('".$fchFin."', '%d-%m-%Y') ,`rtaMultiple`= '1' WHERE id= '".$idEncuesta."';";
	//	print_r($update);
	//	print_r("update\n");
	//	print_r($update);
		//Actualiza
		$result=mysqli_query($db,$update);

		/*-1- Modifica el listado de idiomas y textos iniciales y finales */
		/* selecciono los idiomas anteriores*/
		//COnsulto
		$selectENID="SELECT enid.`id_encuesta_idioma`, enid.`id_encuesta`, enid.`id_idioma`, idi.`nombre` idiomaNombre, enid.`txt_inicio`, enid.`txt_fin`, enid.`link`, enid.`estado` FROM `encuestas_idioma` enid left outer join idioma idi on (idi.id_idioma = enid.id_idioma) WHERE enid.id_encuesta= '".$idEncuesta."';";

		//CONSULTA
		$resultENID=mysqli_query($db,$selectENID);

		$idiomasEnBd = array();
		while($rowIDIOMA = mysqli_fetch_array($resultENID,MYSQLI_ASSOC)){
			array_push($idiomasEnBd,$rowIDIOMA);
		}

		$textoFinal=array();
		$textoInicial=array();
		//
		$idiomasModif=array();

		/* -2- Borro todos los controles para el idioma*/
		$delete="DELETE FROM `encuestas_elemento` WHERE id_encuesta= '".$idEncuesta."';";
		$result=mysqli_query($db,$delete);

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

			$encontroIdioma="false";
			$encuestaIdiomaId=0;

			foreach ($idiomasEnBd as &$rowIDIOMA) {
				if ($idiomaId == $rowIDIOMA['id_idioma'] ){
					$encontroIdioma="true";
					$encuestaIdiomaId=$rowIDIOMA['id_encuesta_idioma'];

					/*-1- Modifica datos de los textos y el estado como A */
					$update="UPDATE `encuestas_idioma` SET `txt_inicio`= '".$txtIni."' , `txt_fin`= '".$txtFin."' ,`estado`= 'A' WHERE id_encuesta_idioma= '".$encuestaIdiomaId."';";
				//	print_r($update);
					//Actualiza
					$result=mysqli_query($db,$update);

				}
			}

			if ($encontroIdioma=="false"){

				//si no encontro el idioma en el listado lo agrego
				$insert="INSERT INTO  `encuestas_idioma` ( `id_encuesta`,`id_idioma`,`txt_inicio`,`txt_fin`,`link`) VALUES ('".$idEncuesta."','".$idiomaId."','".$txtIni."','".$txtFin."','www.rubraencuestas.com.ar');";
				$result=mysqli_query($db,$insert);

				/*nombre del link*/
				$encuestaIdiomaId=mysqli_insert_id($db);
				$codigoEncuesta=$encuestaIdiomaId * $encuestaId;
				$link= "http://belasoft.com.ar/encuestarubra/render/examples/encuestaFinal.html?ehIdi=".$idEncuesta."&ideNC=".$encuestaIdiomaId."&eNcIdi=".$codigoEncuesta;

				/*Actualizo el link en la BD */
				$updateLink="UPDATE  `encuestas_idioma` SET `codigo_seguridad` =  '".$codigoEncuesta."', `link` =  '".$link."' WHERE `id_encuesta_idioma` = '".$encuestaIdiomaId."';";
				//Actualiza
				$result=mysqli_query($db,$updateLink);
			}

			/* -3- Agrego los controles para el idioma*/

			$couentaOrden=1;

			foreach ($controles as &$control) {
				$ctrl = 	json_decode($control);
				if ($control->languageID == $idiomaId){

					$insertElem = "INSERT INTO  `encuestas_elemento` (	`id_encuesta_idioma` ,`id_encuesta` ,	`codigo` ,`tipo_elemento` ,	`orden` ,`label` ,`language` ,`required`, `field_option`	)  VALUES ('".$encuestaIdiomaId."', '".$idEncuesta."', '".$control->cid."','".$control->field_type."',  '".$couentaOrden."',  '".$control->label."',  '".$control->languageID."', '".$control->required."', '".(json_encode($control->field_options))."'); ";


					//Inserta el elemento


					$result=mysqli_query($db,$insertElem);
					$couentaOrden++;
				}
			}

			//array con data de los idiomas agregados
			$idiomaModif['idIdiomaEncuesta']=$encuestaIdiomaId;
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
					$delete="DELETE FROM `encuestas_idioma` WHERE id_encuesta_idioma= '".$rowIDIOMA['id_encuesta_idioma']."' ;";
					$result=mysqli_query($db,$delete);
				}
			}


		/*-5- Verifico si guardo la plantilla */
		if ( ! empty( trim($nombrePlantilla))){
			//Si el nombre de la plantilla no esta vació, guardo la plantilla.
			include("guardarPlantilla.php");
		}

		print_r("ACTUALIZADO CON EXITO");

	} else {
		print_r ("ERROR");
	}
	mysqli_commit($db);


} catch (Exception $e) {
  mysqli_rollback($db);
  print_r ( "Fallo: " . $e->getMessage());
}

mysqli_close($db);
?>