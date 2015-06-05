<?php
include("../../RubraEncuesta7/clases/mostrarEncuestaValida.php");

$time = time();
$fechaActual = date("Y-m-d", $time);

$fechaFin = $lista['fechaFin'];
$estado = $lista['estado'];

if ($estado == "A" && $fechaFin >= $fechaActual  ){
	

?>

<!doctype html>
<html>
<head>
  <title>Rubra - Encuestas </title>
  <link rel="stylesheet" href="../dist/formrenderer.uncompressed.css">
  <link rel="stylesheet" href="https://api.tiles.mapbox.com/mapbox.js/v2.1.4/mapbox.css" />
  <style>
  * {
    box-sizing: border-box;
  }

  body {
  /*  background-color: #eee;*/
    background-image: url('/encuestarubra/RubraEncuesta7/images/trama_fondo.png'); 
background-repeat: repeat; 
background-size: 50%; 


	
  }

  form {
    margin: 0;
  }

  #container {
    opacity: 0.9;
    width: 90%;
    max-width: 1200px;
	min-width: 480px;
/*    background-color: #fff;*/
    padding: 1rem;
    margin: 1rem auto;
    border: 1px solid #ccc;
  }
  *, *:before, *:after {
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
}

body {
  font-family: 'Nunito', sans-serif;
  color: #0E0708;
}

form {
  max-width: 800px;
  margin: 10px auto;
  padding: 10px 20px;
/*  background: #f4f7f8; */
  border-radius: 8px;
}


#textoInicial {
	background:none;
	border: 0px;
/*    color: #EAE9E9; */
	color: #C7D9FF;
    font-size: 25px;	
}

input[type="text"],
input[type="password"] {
   color: #EAE9E9;
}

h1 {
  margin: 0 0 30px 0;
  text-align: center;
  color: #D2D3D1 !important;
}

input[type="text"],
input[type="password"],
input[type="date"],
input[type="datetime"],
input[type="email"],
input[type="number"],
input[type="search"],
input[type="tel"],
input[type="time"],
input[type="url"],
textarea,
select {
  background: rgba(255,255,255,0.7);
  border: none;
  border-radius: 5px;
  font-size: 16px;
  height: auto;
  margin: 0;
  outline: 0;
  padding: 15px;
  width: 100%;
/*  background-color: #e8eeef;*/
/*  opacity:0.7; */
  color: #0D1C27;
  box-shadow: 0 1px 0 rgba(0,0,0,0.03) inset;
  margin-bottom: 30px;
}

.control {
  padding-top: 10px;
  color: #3D3737;	
  padding-left: 25px;
}

input[type="radio"],
input[type="checkbox"] {
  margin: 0 4px 8px 0;
}

select {
  padding: 6px;
  height: 32px;
  border-radius: 2px;
}

button {
  padding: 19px 39px 18px 39px;
  color: #FFF;
  background-color: rgba(172, 165, 162, 0.67);
  font-size: 18px;
  text-align: center;
  font-style: normal;
  border-radius: 5px;
  width: 100%;
  border: 1px solid #F5F0F1;
  border-width: 1px 1px 3px;
  box-shadow: 0 -1px 0 rgba(255,255,255,0.1) inset;
  margin-bottom: 10px;
}

fieldset {
  margin-bottom: 30px;
  border: none;
}

legend {
  font-size: 1.4em;
  margin-bottom: 10px;
}

label {
  display: block;
  margin-bottom: 8px;
}

label.light {
  font-weight: 300;
  display: inline;
}

.number {
  background-color: #5fcf80;
  color: #fff;
  height: 30px;
  width: 30px;
  display: inline-block;
  font-size: 0.8em;
  margin-right: 4px;
  line-height: 30px;
  text-align: center;
  text-shadow: 0 1px 0 rgba(255,255,255,0.2);
  border-radius: 100%;
}

textarea {  
  width: 100%px !important;
  height: 150px !important;
 } 

@media screen and (min-width: 480px) {

  form {
    max-width: 800px;
	min-width: 480px;
  }

}

  </style>
</head>
<body>
 
 


  <script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
  <script src="../dist/formrenderer.js"></script>
  <script src="../test/support/fixtures.js"></script>

  <script>
var json;
var test;
var textoFinal;
    $(function(){

      FormRenderer.BUTTON_CLASS = 'button button-primary'

      FormRenderer.prototype.save = function(options){
	   
        console.log("AHORA",this.getValue(),options);
		
		$("#textoInicial").remove();
        this.state.set({
          hasChanges: false
        });
        if (options && options.success) {
		console.log ("ENTRACAM")
		
		  guardarDatosEncuesta();
          options.success();
        }
      };



    });
	 function guardarDatosEncuesta(){
	  var respuesta=[];
	  console.log("GUARRRDA")
	  //GUARDO PARRAFOS
	  $('.fr_response_field_paragraph').find("textarea").each(function () {
	  
	   respuesta.push('{"cid":"'+$(this).attr('id')+'","val":"'+$(this).val()+'","tipo":"parrafo"}');
	  })
	  //Guardo Textos
	  $('.fr_response_field_text, .fr_response_field_number, .fr_response_field_website, .fr_response_field_email').find("input:text").each(function () {
	  
	   respuesta.push('{"cid":"'+$(this).attr("id")+'","val":"'+$(this).val()+'"}');
	  })
	  //Guardo Combos
	  $('.fr_response_field_dropdown').find("select").each(function () {
        console.log("DALEID",$(this).attr("id"))
	   respuesta.push('{"cid":"'+$(this).attr("id")+'","val":"'+$(this).find("option:selected").val()+'","tipo":"combo"}')
	  })
	  console.log("SELECIONA",$('.fr_response_field_radio').find("input:checked"))
	  
	  
	  $('.fr_response_field_radio').each(function () {
	  
		if ($(this).find("input:checked").length>0){
			respuesta.push('{"cid":"'+$('.fr_response_field_radio').find("input:checked").attr("id")+'","val":"'+$('.fr_response_field_radio').find("input:checked").val()+'","tipo":"radio"}')
			
	  }
        //console.log("DALEID",$(this).attr("id"))
	   //respuesta.push("{"cid":"+$(this).attr("id")+",val:"+$(this).find("option:selected").val()+"}")
	  })
	   $('.fr_response_field_checkboxes').find("input:checked").each(function () {
	      var id=$(this).parent().parent().find("label:first-child").attr("for")
		  var value=  $(this).parent().text();
		//if ($(this).find("input:checked").length>0){
			respuesta.push('{"cid":"'+id+'","val":"'+value.replace(/\s+/g, '')+'","tipo":"check"}')
			
	 // }
        //console.log("DALEID",$(this).attr("id"))
	   //respuesta.push("{"cid":"+$(this).attr("id")+",val:"+$(this).find("option:selected").val()+"}")
	  })
	  
	  
	  
	  //Guardo Hora
	   $('.fr_response_field_time').each(function (){ 
	   var horarioFinal="";
	   var cid;
	          $(this).find("input").each(function () {
			        horarioFinal+= $(this).val();
					 if ($(this).attr("id")){
						cid=$(this).attr("id")
					 }
			  	     console.log("Valor",$(this).val())

			  })
	   respuesta.push('{"cid":"'+cid+'","val":"'+horarioFinal+'"}');
	  })
	  
	  
	  
		console.log("RESPUESTA",respuesta)
	   enviarRespuesta(respuesta)
	 }
	     function mostrarEncuesta(){
        $('.choose').hide()
        var id = $(this).data('form');
		//console.log("ID ES",id)
//if (id == 'short') {
		var campos=Fixtures.FormRendererOptions.SHORT()
		//.log("otra Ocpn",Fixtures.FormRendererOptions.KITCHEN_SINK())
	//console.log("!",test)
		//campos["response_fields"]=json2["fields"]
		campos["response_fields"]=test["form"]["fields"]
          new FormRenderer(_.extend(campos, {
            "afterSubmit": { method: 'page', html: textoFinal }
          }))
     
      }
	  	function getParameterByName(name) {
	    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
	    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
	        results = regex.exec(location.search);
	    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	}
	
	 	function enviarRespuesta(respuesta) {
		var objetoFinal={}
		objetoFinal["ehIdi"]=getParameterByName("ehIdi");
		objetoFinal["ideNC"]=getParameterByName("ideNC");
		objetoFinal["respuestas"]=respuesta;
		$.ajax({
		    url: '../../RubraEncuesta7/clases/guardarRespuesta.php',
		    type: 'post',
		   
			data: {"info" : JSON.stringify(objetoFinal)},
		    success: function(msg) {
		

		    }
		});
	   }
	
	
	$( document ).ready(function() {
	    var datosEncuesta={}
	  datosEncuesta.ehIdi=getParameterByName("ehIdi")
     datosEncuesta.ideNC=getParameterByName("ideNC")
 //datosEncuesta.eNcIdi=getParameterByName("eNcIdi")
	//datosEncuesta.id=getParameterByName("ehIdi");
				  $.ajax({
		    url: '../../RubraEncuesta7/clases/getEncuestaByIdEidioma.php',
			//url: '../../RubraEncuesta7/clases/getEncuestaById.php',
		    type: 'post',
		    //data: JSON.stringify(datosForm),
		    //contentType: 'application/json; charset=utf-8',
		//dataType: 'json',
		    //async: false,
			data: {"info" : JSON.stringify(datosEncuesta)},
		    success: function(msg) {
			encuesta=JSON.parse(msg);
			//console.log("Resultado",JSON.parse(msg))
//console.log("Encuesta",msg)
	         test=JSON.parse(msg)
			 $('#cliente').val("Cliente: " + test["clienteNombre"])
			 $('#evento').val("Evento: " +test["eventoNombre"])
			  $('#textoInicial').val(test["txtIni"])
			  //$('#textoInicial').val("Bienvenido a la Encuesta!")
			 textoFinal=test["txtFin"]
//textoFinal="Muchas Gracias por participar"
			 mostrarEncuesta()

		    }
		});
	
	
	
	
	
	
	
	
	
	
	});
	function getParameterByName(name) {
	    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
	    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
	        results = regex.exec(location.search);
	    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	}
  </script>
      <div id='container'>
<!-- <input name="cliente" type="text" id="cliente" style="width: 50%;" disabled /> -->
<!-- 	<input name="evento" type="text" id="evento"  style="width: 49%;" disabled /> -->
	<div style="width:100%">
	 <img src="http://belasoft.com.ar/encuestarubra/RubraEncuesta7/images/rubralogo3.png" alt="Smiley face" height="220px" width="220px" style="margin-left: 20%;   opacity: 0.9;">	
 	 <img src="http://belasoft.com.ar/encuestarubra/RubraEncuesta7/images_sys/takeda.png" alt="Smiley face" height="200px" width="200px" style="margin-left: 10%; vertical-align: top;">
	</div>
    <hr />
    <form ><h1>Bienvenido / Welcome </h1><input name="textoInicial" type="text" id="textoInicial"  value="Cargando..."  disabled /></form>
 
<form data-formrenderer action="index.html" method="post">
      
   
      </form>
	   </div>
</body>
</html>

<?php

} else {
	
?>
<!doctype html>
<html>
<head>
  <title>Rubra - Encuestas </title>
  <style>

  body {
  /*  background-color: #eee;*/
    background-image: url('/encuestarubra/RubraEncuesta7/images/trama_fondo.png'); 
	background-repeat: repeat; 
	background-size: 50%; 

  }
  
  .contenedor {
  margin-left: 25%;
  margin-top: 10%;
  border-radius: 20px;
  background-color: #D5D5D5;
  width: 50%;
  height: 100px;	  
  }
  
  .texto {
	color: #9B9B9B;
 	margin-left: 30%;
  	padding-top: 20px;
  	height: 100px;   
  }
  </style>  
</head>
<body>
<div class="contenedor">
		<h1 class="texto">Encuesta fuera de Servicio</h1>
</div>
</body>
</html>



<?php		
}
?>