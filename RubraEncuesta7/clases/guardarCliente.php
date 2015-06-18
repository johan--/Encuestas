<?php
include("db.php");
session_start();


if (isset($_POST["info"])) {

    // Decode our JSON into PHP objects we can use
    $info = json_decode($_POST["info"]);
	$entidad= new stdClass();

    $razonSocial=$info->nombre; 
	$archivoNombre=$info->nombre; 
	$archivoRuta="http://belasoft.com.ar/encuestarubra/RubraEncuesta7/images_sys/clientes/"; 
	$comentario=$info->comentario; 
	
print_r($archivoNombre);
print_r("hola");


print_r("valor: ".$archivoNombre." ");
if (! $archivoNombre == ""){
	print_r("entra");
	$uploadedfileload="true";
	$uploadedfile_size=$_FILES['uploadedfile'][size];
		print_r("entra1");
	echo $_FILES[uploadedfile][name];
	/*if ($_FILES[uploadedfile][size]>2000000)
	{
		$msg=$msg."El archivo es mayor que 200KB, debes reduzcirlo antes de subirlo<BR>";
		$uploadedfileload="false";
	}*/
		print_r("entra2");
		print_r($_FILES[uploadedfile][type]);
	if (!($_FILES[uploadedfile][type] =="image/pjpeg" OR $_FILES[uploadedfile][type] =="image/gif" OR $_FILES[uploadedfile][type] =="image/png"))
	{
			print_r("entra3asdasda   33");
		$msg=$msg." Tu archivo tiene que ser JPG, PNG o GIF. Otros archivos no son permitidos<BR>";
		$uploadedfileload="false";
	}
		print_r("entra4");
	$file_name=$_FILES[uploadedfile][name];
			print_r("entra $file_name ho");
	$add=	$archivoRuta.$archivoNombre;
		print_r("entra5");
	if($uploadedfileload=="true"){
			print_r("entra6");
		if(move_uploaded_file ($_FILES[uploadedfile][tmp_name], $add)){
		echo " Ha sido subido satisfactoriamente";
	}else{
		echo "Error al subir el archivo";}
	}else{
		echo $msg;
	}
}
	
	
	print_r("entra7");
		$insert="INSERT INTO `clientes` (`RazonSocial`, `Comentario`,`imagen_ruta`,`imagen_nombre`) VALUES ( '".$razonSocial."', '".$comentario."','".$archivoRuta."','".$archivoNombre."');";
		//INSERTA
		$result=mysqli_query($db,$insert);

		//obtengo el id ingresado
		$id=mysqli_insert_id($db);
		$entidad->id=$id;
	    print_r(json_encode($entidad));	


} else {
	print_r ("ERROR");	
}

?>
