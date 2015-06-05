<?php
$request_body = file_get_contents('php://input');
$data = json_decode($request_body);
// ESTO TE DEVUELVE TODA LA DATA EN NEWTWORK,RESPONSE 
//var_dump($data );
//Aca estoy devolviendo solo el primer dato que es Cliente

print_r($data);
print_r($data[0]);


//Cliente
$data[0];
//Evento
$data[1];
//Objetivo
$data[2];
//Fecha Inicio
$data[3];
//Fecha Fin
$data[4];
//idoma 1
$data[5];
//idoma 2
$data[6];
//text Intro 1
$data[7];
 	
$data[8];
$data[9];
$data[10];
$data[11];
$data[12];
$data[13];





?>




<?php
include("clases/db.php");
session_start();
$request_body = file_get_contents('php://input');
$data = json_decode($request_body);

print_r($data);

//ENcuesta
$ClienteId=mysqli_real_escape_string($db,$data[0]['value']); 
$EventoId=mysqli_real_escape_string($db,$data[1]['value']); 
$objetivoStr=mysqli_real_escape_string($db,$data[2]['value']); 
$fInicio=mysqli_real_escape_string($db,$data[3]['value']); 
$fFin=mysqli_real_escape_string($db,$data[4]['value']); 
$idiomaId=mysqli_real_escape_string($db,$data[5]['value']); 


//$encuestaIngresadaId =$_POST['idUsuarioInsert']; 

/*if( ! empty($_SESSION['login_user']) ) {
	$inserted_login_usr = $_SESSION['login_user'];*/

//	if (trim($name) <> "" && trim($last_name) <> "" ){
	
		if ($agregarNuevo == "SI"){
			//Creo la encuesta
			$insert="INSERT INTO  `encuestas` ( `idEvento`)	VALUES ('".$EventoId."');";
			//INSERTA
			$result=mysqli_query($db,$insert);
	
			//Guarda el id de la encuesta ingresada
			$encuestaIngresadaId=mysqli_insert_id($db);

			/*****************************************  IMPORTANTE *****************************************/
			//ITERO los idiomas de cada encuesta. 
			$insert="INSERT INTO  `id_encuesta_idioma` ( `id_encuesta`,`id_idioma`,`txt_inicio`,`txt_fin`,`link`) VALUES ('".$encuestaIngresadaId."','".$idiomaId."','".$txtInicio."','".$txtFin."','".$link."');";
			//INSERTA
			mysqli_query($db,$insert);
			//Guarda el id de la encuesta ingresada
			$encuestaIdiomaId=mysqli_insert_id($db);


			//Mantiene el orden de los elementos
			$couentaOrden=1;
			/*****************************************  IMPORTANTE *****************************************/
			//ITERO por cada IDIOma todos los Elementos q vengan. Agregar que por n idiomas (deber{ia chequera con el campo language o algo así)
			$insertElem = "INSERT INTO  `encuestas_elemento` (	`id_encuesta_idioma` ,	`codigo` ,`tipo_elemento` ,	`orden` ,`label` ,`language` ,`required`, `field_option`	) " +
			"VALUES (	'".$encuestaIdiomaId."',  '".$cid."',  '".$field_type."',  '".$couentaOrden."',  '".$label."',  '".$language."',  '".$required."',  '".$field_options."');";
			$couentaOrden++;

		}


		//MODIFICAR
				$update="UPDATE `encuestas` SET `idEvento`= '".$name."' , `objetivo`= '".$name."' , `fechaInicio`= '".$name."' ,`fechaFin`= '".$name."'  ,`logo_enuesta`= '".$name."' ,`rtaMultiple`= '".$name."' ,`estado`= '".$name."' WHERE id= '".$encuestaIngresadaId."';";
				//Actualiza
				$result=mysqli_query($db,$update);
		
		
/*		if($encuestaIngresadaId > 0){
	
			$consultaEN="SELECT * FROM encuestas WHERE id='".$encuestaIngresadaId."' limit 1;";
	
			$resultEN=mysqli_query($db,$consultaEN);
			$rowEN=mysqli_fetch_array($resultEN,MYSQLI_ASSOC);
			$count=mysqli_num_rows($resultEN);
			
			if($count==1)
			{
				$save_info = true;
			}
			if ($save_info){


				//ACTUALIZO LA INformacion de la encuesta
				$update="UPDATE `encuestas` SET `idEvento`= '".$name."' , `objetivo`= '".$name."' , `fechaInicio`= '".$name."' ,`fechaFin`= '".$name."'  ,`logo_enuesta`= '".$name."' ,`rtaMultiple`= '".$name."' ,`estado`= '".$name."' WHERE id= '".$encuestaIngresadaId."';";
				//Actualiza
				$result=mysqli_query($db,$update);


				//Creo el registro en la tabla de Participation
				$insert="INSERT INTO  `encuestas_elemento` ( `id_encuesta_idioma`) VALUES ('".$inserted_newUserId."');";
				//INSERTA
				mysqli_query($db,$insert);

	
*/

//if ($save_info == 'true'){
	echo "OK";
/*} else {
	$_POST['error_motivo'] = $motivo_error;
	include("clases/notification/notifErrorAdm.php"); 
	echo "ERROR";
}*/

?>