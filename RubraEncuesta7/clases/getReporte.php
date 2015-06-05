<?php
include("db.php");
session_start();

//if (isset($_GET["gr"])) {
if (isset($_POST["info"])) {
	$info = json_decode($_POST["info"]);
	
	$idEncuesta=$info->idEncuesta; 
//	$idEncuesta=$_GET["gr"];
//	$idEncuestaIdioma=$info->idEncuestaIdioma; 	

//	$idEncuesta=127;

	//obtener total de encuestados por idioma y qt total
	/* Q1
	
SELECT re.`id_encuesta_idioma` , idi.id_idioma,idi.nombre, COUNT( re.`id_encuesta_idioma` ) AS qt_encuestados
FROM  `respuesta_encuestado` re
LEFT JOIN encuestas_idioma enidi ON ( enidi.id_encuesta_idioma = re.id_encuesta_idioma ) 
LEFT JOIN idioma idi ON ( enidi.id_idioma = idi.id_idioma ) 
WHERE re.`id_encuesta` =  '127'
GROUP BY re.`id_encuesta_idioma` 
	*/



/* Q2

SELECT enel1.id_encuesta_idioma,COUNT( enel1.id_encuesta ) qt_total, (

SELECT COUNT( enel.id_encuesta ) 
FROM encuestas_elemento enel
WHERE enel.id_encuesta =  enel1.id_encuesta
AND enel.id_encuesta_idioma =  enel1.id_encuesta_idioma
AND (
enel.tipo_elemento LIKE  'checkboxes'
OR enel.tipo_elemento LIKE  'radio'
)
)qt_no_txt
FROM encuestas_elemento enel1
WHERE enel1.id_encuesta =  '127'
group by enel1.id_encuesta_idioma

*/
	$selectQ2="SELECT enel1.id_encuesta_idioma,COUNT( enel1.id_encuesta ) qt_total, (
SELECT COUNT( enel.id_encuesta ) 
FROM encuestas_elemento enel
WHERE enel.id_encuesta =  enel1.id_encuesta
AND enel.id_encuesta_idioma =  enel1.id_encuesta_idioma
AND (
enel.tipo_elemento LIKE  'checkboxes'
OR enel.tipo_elemento LIKE  'radio'
)
)qt_no_txt
FROM encuestas_elemento enel1
WHERE enel1.id_encuesta =  '".$idEncuesta."' 
group by enel1.id_encuesta_idioma";

	//CONSULTA
	$resultQ2=mysqli_query($db,$selectQ2);



/* Q3
SELECT  `id_encuesta` ,  `id_encuesta_idioma` , COUNT( id_encuesta ) rtas_completas
FROM  `respuesta` 
WHERE id_encuesta =127
AND (
elemento NOT LIKE  'radio'
AND elemento NOT LIKE  'check'
)
AND respuesta NOT LIKE  ""
GROUP BY  `id_encuesta` ,  `id_encuesta_idioma` 


*/
$selectQ3="SELECT  `id_encuesta` ,  `id_encuesta_idioma` , COUNT( id_encuesta ) rtas_completas
FROM  `respuesta` 
WHERE id_encuesta = '".$idEncuesta."' 
AND (
elemento NOT LIKE  'radio'
AND elemento NOT LIKE  'check'
)
AND respuesta NOT LIKE  ''
GROUP BY  `id_encuesta` ,  `id_encuesta_idioma` ";

	//CONSULTA
	$resultQ3=mysqli_query($db,$selectQ3);


/* Q4
SELECT  `id_encuesta` ,  `id_encuesta_idioma` , COUNT( id_encuesta ) 
FROM  `respuesta` 
WHERE id_encuesta =127
AND (
elemento NOT LIKE  'radio'
AND elemento NOT LIKE  'check'
)
AND respuesta NOT LIKE  ""
GROUP BY  `id_encuesta` ,  `id_encuesta_idioma` ,  `id_encuestado` 
*/

$selectQ4="SELECT  `id_encuesta` ,  `id_encuesta_idioma` , COUNT( id_encuesta ) qt_rta
FROM  `respuesta` 
WHERE id_encuesta = '".$idEncuesta."' 
AND (
elemento NOT LIKE  'radio'
AND elemento NOT LIKE  'check'
)
AND respuesta NOT LIKE  ''
GROUP BY  `id_encuesta` ,  `id_encuesta_idioma` ,  `id_encuestado` ";

	//CONSULTA
	$resultQ4=mysqli_query($db,$selectQ4);


/*  Q5

SELECT res.`id_encuesta` , res.`id_encuesta_idioma` , enel.label, res.respuesta, res.`id_encuestado`, reen.mail, res.elemento
FROM  `respuesta` res
left join respuesta_encuestado reen on (reen.id_encuestado = res.id_encuestado)
LEFT JOIN encuestas_elemento enel ON ( enel.id_encuesta_idioma = res.id_encuesta_idioma
                                      
AND enel.id_encuesta = res.id_encuesta
AND enel.codigo = res.cid ) 
WHERE res.id_encuesta =127

*/

/* Q6
SELECT * 
FROM encuestas_elemento enel1
WHERE enel1.id_encuesta =  '127'
AND tipo_elemento
IN (
'radio',  'checkboxes'
)
GROUP BY orden
ORDER BY orden
*/


	//ESTADISTICAS GENERALES
	$reporte = new stdClass();
	$reporte->idEncuesta=$idEncuesta ; 

	$reporteIdiomas=array();
		
	$qtTotalEncuestados = 0;
	$qtTotalPreguntas = 0;
	$qtTotalPreguntasACompletar = 0;
	$qtTotalPreguntasMultiples = 0;
	
    //para qt_total tengo q iterar todo	
	$selectQ1="SELECT re.`id_encuesta_idioma` , idi.id_idioma,idi.nombre, COUNT( re.`id_encuesta_idioma` ) AS qt_encuestados
FROM  `respuesta_encuestado` re
LEFT JOIN encuestas_idioma enidi ON ( enidi.id_encuesta_idioma = re.id_encuesta_idioma ) 
LEFT JOIN idioma idi ON ( enidi.id_idioma = idi.id_idioma ) 
WHERE re.`id_encuesta` =  '".$idEncuesta."'
GROUP BY re.`id_encuesta_idioma` ;";

	//CONSULTA
	$resultQ1=mysqli_query($db,$selectQ1);	
	while($rowELEM = mysqli_fetch_array($resultQ1,MYSQLI_ASSOC)){ 

		$reporteIdioma=array();
		$reporteIdioma['language'] = $rowELEM["nombre"];							//Q1 OK
		$reporteIdioma['idIdioma'] = $rowELEM["id_idioma"];							//Q1 OK
		$reporteIdioma['idIdiomaEncuesta'] = $rowELEM["id_encuesta_idioma"];		//Q1 OK	
		$reporteIdioma['totalEncuestados'] = $rowELEM["qt_encuestados"];			//Q1 OK
		$reporteIdioma['totalEncuestasIncompletas'] = 0;
		$qtTotalEncuestados = $qtTotalEncuestados + $rowELEM['qt_encuestados'];
		array_push($reporteIdiomas,$reporteIdioma);
	}

		
	while($rowELEM = mysqli_fetch_array($resultQ2,MYSQLI_ASSOC)){ 
		foreach ($reporteIdiomas as &$reporteIdioma) {
			if ($rowELEM['id_encuesta_idioma'] == $reporteIdioma['idIdiomaEncuesta']){
				$reporteIdioma['totalPreguntas'] = $rowELEM['qt_total'];	//Q2 OK
				$reporteIdioma['totalPreguntasACompletar'] = $rowELEM['qt_total'] - $rowELEM['qt_no_txt'];	//Q2 OK
				$reporteIdioma['totalPreguntasMultiples'] = $rowELEM['qt_no_txt'];	//Q2 resta OK
				
				if ($rowELEM['qt_total'] > $qtTotalPreguntas  ){
					$qtTotalPreguntas = $rowELEM['qt_total'];
				}
				if (($rowELEM['qt_total'] - $rowELEM['qt_no_txt']) > $qtTotalPreguntasACompletar  ){
					$qtTotalPreguntasACompletar = $rowELEM['qt_total'];
				}
				if ($rowELEM['qt_no_txt'] > $qtTotalPreguntasMultiples  ){
					$qtTotalPreguntasMultiples = $rowELEM['qt_total'];
				}						
			}
		}
	}		

	$totalRespuestas=array();
	while($rowELEM = mysqli_fetch_array($resultQ3,MYSQLI_ASSOC)){ 
		foreach ($reporteIdiomas as &$reporteIdioma) {
			if ($rowELEM['id_encuesta_idioma'] == $reporteIdioma['idIdiomaEncuesta'] ){
			  $reporteIdioma['ptjPreguntasACompletarCompletas'] = (($rowELEM['rtas_completas'] / $reporteIdioma['totalEncuestados']) * 100) / $reporteIdioma['totalPreguntasACompletar'] ;
			}
		}
	}			


	while($rowELEM = mysqli_fetch_array($resultQ4,MYSQLI_ASSOC)){ 
		foreach ($reporteIdiomas as &$reporteIdioma) {
			if ($rowELEM['id_encuesta_idioma'] == $reporteIdioma['idIdiomaEncuesta'] ){
				if ($rowELEM['qt_rta'] < $reporteIdioma['totalPreguntasACompletar'] ){
					$reporteIdioma['totalEncuestasIncompletas'] = $reporteIdioma['totalEncuestasIncompletas'] +1;
				}
			}
		}
	}		
		foreach ($reporteIdiomas as &$reporteIdioma) {
					$reporteIdioma['totalEncuestasCompletas'] = $reporteIdioma['totalEncuestados'] - $reporteIdioma['totalEncuestasIncompletas'];
		}
	

		$reporte->totalEncuestados=$qtTotalEncuestados;
		$reporte->totalPreguntas=$qtTotalPreguntas;
		$reporte->totalPreguntasACompletar=$qtTotalPreguntasACompletar;		
		$reporte->totalPreguntasMultiples=$qtTotalPreguntasMultiples;		
	
	$totalEncuestasIncompletas = 0;
	$totalEncuestasCompletas = 0;
	foreach ($reporteIdiomas as &$reporteIdioma) {
		$totalEncuestasIncompletas = $totalEncuestasIncompletas + $reporteIdioma['totalEncuestasIncompletas'];
		$totalEncuestasCompletas = $totalEncuestasCompletas  + $reporteIdioma['totalEncuestasCompletas'];
	}
		$reporte->totalEncuestasCompletas=$totalEncuestasCompletas;
		$reporte->ptjEncuestasCompletas=($totalEncuestasCompletas * 100) / $qtTotalEncuestados;
		$reporte->totalSinRespuesas=$totalEncuestasIncompletas;			//
		$reporte->ptjSinRespuesas=($totalEncuestasIncompletas * 100) / $qtTotalEncuestados;

	
	//ESTADISTICAS POR IDIOMA	
	$reporte->estadisticasPorIdioma=$reporteIdiomas;	
	
	
	$respuestas = array();


	$select="SELECT res.`id`  `id` , res.`id_encuesta` , reen.mail mail, res.`id_encuesta_idioma` id_encuesta_idioma, res.cid cid, enel.label pregunta, res.respuesta respuesta, res.`id_encuestado` id_encuestado, reen.mail mail, res.elemento elemento, enel.orden
FROM  `respuesta` res
LEFT JOIN respuesta_encuestado reen ON ( reen.id_encuestado = res.id_encuestado ) 
LEFT JOIN encuestas_elemento enel ON ( enel.id_encuesta_idioma = res.id_encuesta_idioma ) 
AND enel.id_encuesta = res.id_encuesta
AND enel.codigo = res.cid
WHERE res.id_encuesta = '".$idEncuesta."'
ORDER BY enel.orden,id_encuesta_idioma, reen.mail,res.id_encuestado;";

	//CONSULTA
	$result=mysqli_query($db,$select);


	$respuestas=array();
	$respuesta=array();
	$rtas=array();
	$ordenAnterior="noHay";
	$totalRespuestas = 0;
	$totalIncompletas = 0;

	while($rowELEM = mysqli_fetch_array($result,MYSQLI_ASSOC)){ 
		$rta=array();
		$rta['id'] = $rowELEM['id'];
		$rta['orden'] = $rowELEM['orden'];
		$rta['idEncuestado']= $rowELEM['id_encuestado'];
		$rta['mail']= $rowELEM['mail'];
		$rta['valor'] = $rowELEM['respuesta'];

		if ($rowELEM['elemento'] != "check" && $rowELEM['elemento'] != "radio" ){
/*			$rta=array();
			$rta['id'] = $rowELEM['id'];
			$rta['orden'] = $rowELEM['orden'];
			$rta['idEncuestado']= $rowELEM['id_encuestado'];
			$rta['mail']= $rowELEM['mail'];
			$rta['valor'] = $rowELEM['respuesta'];
*/
			//Si el orden es distinto del orden anterior
			if ($rowELEM['orden'] != $ordenAnterior){
				//no lo hace la primer vez
				if ($ordenAnterior != "noHay" ){
					if ($respuesta['respuestasTipo']== "Simple"){
						$respuesta['totalRespuestas']= $totalRespuestas;
						$respuesta['totalCompletas']= $totalRespuestas - $totalIncompletas;
						$respuesta['ptjCompletas']= ($respuesta['totalCompletas'] * 100) /  $totalRespuestas;			
						$respuesta['totalIncompletas']= $totalIncompletas;
						$respuesta['ptjIncompletas']= ($respuesta['totalIncompletas'] * 100) /  $totalRespuestas;	
						$respuesta['respuestasValores']= $rtas;				
						array_push($respuestas,$respuesta);	
					} else {
						$respuesta['totalRespuestas']= $totalRespuestas;
						$respuesta['respuestasTipo']= "Multiple";	
						$respuesta['respuestasValores']= $rtas;				
						array_push($respuestas,$respuesta);	
					}
				} 
				$ordenAnterior = $rowELEM['orden'];
				$totalRespuestas = 0;
				$totalIncompletas = 0;
				$respuesta=array();
				$rtas=array();
//				$respuesta['cid']= $rowELEM['cid'];
				$respuesta['respuestasTipo']= "Simple";	
				$respuesta['orden']= $rowELEM['orden'];
				$respuesta['pregunta']= $rowELEM['pregunta'];
//				$respuesta['elemento']= $rowELEM['elemento'];
//				$respuesta['idEncuestado']= $rowELEM['id_encuestado'];
//				$respuesta['mail']= $rowELEM['mail'];
			} else {	
							
			}
			array_push($rtas,$rta);
			$totalRespuestas = $totalRespuestas + 1 ;
			if ($rowELEM['respuesta'] == ""){
				$totalIncompletas = $totalIncompletas + 1;	
			}				
		} else {

			//Si el orden es distinto del orden anterior
			if ($rowELEM['orden'] != $ordenAnterior){
				//no lo hace la primer vez
				if ($ordenAnterior != "noHay" ){
					if ($respuesta['respuestasTipo']== "Simple"){
						$respuesta['totalRespuestas']= $totalRespuestas;
						$respuesta['totalCompletas']= $totalRespuestas - $totalIncompletas;
						$respuesta['ptjCompletas']= "90%";			
						$respuesta['totalIncompletas']= $totalIncompletas;
						$respuesta['ptjIncompletas']= "10%";	
						$respuesta['respuestasValores']= $rtas;				
						array_push($respuestas,$respuesta);	
					} else {
						$respuesta['totalRespuestas']= $totalRespuestas;
						$respuesta['respuestasValores']= $rtas;				
						array_push($respuestas,$respuesta);	
					}
				} 
				$ordenAnterior = $rowELEM['orden'];
				$totalRespuestas = 0;
				$respuesta=array();
				$rtas=array();
				$respuesta['respuestasTipo']= "Multiple";	
				$respuesta['orden']= $rowELEM['orden'];
				$respuesta['pregunta']= $rowELEM['pregunta'];
				//array_push($rtas,$rta);	
			} else {	

			}	
/*			$rta=array();
			$rta['orden'] = $rowELEM['orden'];
			$rta['idEncuestado']= $rowELEM['id_encuestado'];
			$rta['mail']= $rowELEM['mail'];
			$rta['valor'] = $rowELEM['respuesta'];		
*/			array_push($rtas,$rta);			
			$totalRespuestas = $totalRespuestas + 1 ;			
			
		}
		
	}
	
	if ($ordenAnterior != "noHay" ){
		if ($respuesta['respuestasTipo']== "Simple"){
			$respuesta['totalRespuestas']= $totalRespuestas;
			$respuesta['totalCompletas']= $totalRespuestas - $totalIncompletas;
			$respuesta['ptjCompletas']= "90%";			
			$respuesta['totalIncompletas']= $totalIncompletas;
			$respuesta['ptjIncompletas']= "10%";	
			$respuesta['respuestasValores']= $rtas;				
			array_push($respuestas,$respuesta);	
		} else {
			$respuesta['totalRespuestas']= $totalRespuestas;
			$respuesta['respuestasTipo']= "Multiple";	
			$respuesta['respuestasValores']= $rtas;				
			array_push($respuestas,$respuesta);	
		}
	} 
	
	
	//ESTADISTICAS POR IDIOMA	
	$reporte->respuestas=$respuestas;	
	
	
	print_r(json_encode($reporte));
	
 }
?>