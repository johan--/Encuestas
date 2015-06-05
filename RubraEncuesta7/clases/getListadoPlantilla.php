


<?php
include("db.php");
session_start();

//$select="SELECT pla.id, pla.nombre, count(idio.id) AS idiomas,pla.estado FROM  `plantillas` pla left outer join (select id_plantilla id from plantillas_idioma) idio on (idio.id = pla.id) left outer join (select id_encuesta id from plantillas_elemento) preg on (preg.id = pla.id) group by idio.id, preg.id; ";
$select="SELECT pla.id, pla.nombre, 0 AS cantIdiomas,0 AS cantPreguntas,pla.estado FROM  `plantillas` pla ; ";

	//CONSULTA
	$result=mysqli_query($db,$select);

	$lista=array();
	while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){ 
			$item=array();
			$item['id']=$row ["id"];
			$item['nombre']=$row ["nombre"];
			$item['cantIdiomas']=$row ["cantIdiomas"];
			$item['cantPreguntas']=$row ["cantPreguntas"];
			$item['estado']=$row ["estado"];						
			array_push($lista,$item);
	}
	
//	print_r(json_encode($lista));

?>





