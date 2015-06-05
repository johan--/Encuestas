<?php
include("db.php");
session_start();

$select="SELECT en.id, idi.nombre idioma, enev.link, cli.RazonSocial, eve.nombre, en.objetivo, en.FechaInicio, en.fechaFin, (SELECT count(*) FROM `respuesta` WHERE `id_encuesta`=en.id ) AS totaEncuestados, 0 AS ptjRespuesta, en.estado
FROM  `encuestas` en 
LEFT OUTER JOIN  `encuestas_idioma` enev ON ( enev.id_Encuesta = en.id ) 
LEFT OUTER JOIN  `idioma` idi ON ( enev.id_idioma = idi.id_idioma ) 
LEFT OUTER JOIN  `eventos` eve ON ( en.idEvento = eve.id ) 
LEFT OUTER JOIN  `clientes` cli ON ( eve.idCliente = cli.id ) order by en.id desc; ";

	//CONSULTA
	$result=mysqli_query($db,$select);

	$lista=array();
	while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){ 
			$item=array();
			$item['id']=$row ["id"];
			$item['razonSocial']=$row ["RazonSocial"];
			$item['eventoNombre']=$row ["nombre"];
			$item['idiomaNombre']=$row ["idioma"];
			$item['encuestaLink']=$row ["link"];
			$item['objetivo']=$row ["objetivo"];
			$item['fechaInicio']=$row ["FechaInicio"];
			$item['fechaFin']=$row ["fechaFin"];
			$item['totaEncuestados']=$row ["totaEncuestados"];
			$item['ptjRespuesta']=$row ["ptjRespuesta"];
			$item['estado']=$row ["estado"];						
			array_push($lista,$item);
	}
	
	//print_r(json_encode($lista));

?>