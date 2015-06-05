<!DOCTYPE html>
<!--[if lte IE 8]>              <html class="ie8 no-js" lang="en">     <![endif]-->
<!--[if IE 9]>					<html class="ie9 no-js" lang="en-US">  <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="not-ie no-js" lang="en">  <!--<![endif]-->
	<head>
		<!-- Google Web Fonts
		================================================== -->
		<link href='http://fonts.googleapis.com/css?family=Roboto:300,300italic,400,500,700%7cCourgette%7cRaleway:400,700,500%7cCourgette%7cLato:700' rel='stylesheet' type='text/css'>

		<!-- Basic Page Needs
		================================================== -->
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<title>Forms</title>

		<meta name="description" content="">
		<meta name="author" content="">

		<!-- Mobile Specific Metas
		================================================== -->
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

		<!-- CSS
		================================================== -->
		<link rel="stylesheet" href="../wizard/css/tmm_form_wizard_style_demo.css" />
		<link rel="stylesheet" href="../wizard/css/grid.css" />
		<link rel="stylesheet" href="../wizard/css/tmm_form_wizard_layout.css" />
		<link rel="stylesheet" href="../wizard/css/fontello.css" />
		<link rel="stylesheet" href="../vendor/css/vendor.css" />
  <link rel="stylesheet" href="../dist/formbuilder.css" />
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">

  		<script src="../vendor/js/vendor.js"></script>
  <script src="../dist/formbuilder.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	<script src="http://code.jquery.com/ui/1.11.3/jquery-ui.js"></script>

		



		<!--[if lt IE 9]>
				<script src="js/respond.min.js"></script>
		<![endif]-->

		<script src="js/tmm_form_wizard_custom.js"></script>

	</head>
	<body>


		<!-- - - - - - - - - - - - - Content - - - - - - - - - - - - -  -->


		<div id="content">

			<div class="form-container" style="
			    width: 2000x";>

				<div id="tmm-form-wizard" class="container substrate" style="
				    width: 2000px";>

					<div class="row">

						<div class="col-xs-12">
							<h2 class="form-login-heading">Generador de Encuestas<span></span></h2>
						</div>

					</div><!--/ .row-->

					<div class="row stage-container">
							<div class="stage tmm-current col-md-3 col-sm-3"  id="stage1">
								<div class="stage-header head-icon head-icon-lock"></div>
								<div class="stage-content">
										<h3 class="stage-title">Informacion General</h3>
										<div class="stage-info">
											Ingrese informacion general de la encuesta
									</div>
								</div>
							</div><!--/ .stage-->





							<div class="stage  col-md-3 col-sm-3" id="stage2">
								<div class="stage-header head-icon head-icon-user"></div>
								<div class="stage-content">
									<h3 class="stage-title">Seleccion Idiomas</h3>
									<div class="stage-info">
										Elija los idiomas deseados de la encuestas
									</div>
								</div>
							</div><!--/ .stage-->
								<div class="stage  col-md-3 col-sm-3" id="stage3">
									<div class="stage-header head-icon head-icon-payment"></div>
									<div class="stage-content">
										<h3 class="stage-title">Texto Introduccion</h3>
										<div class="stage-info">
											Ingrese el texto introductorio
										</div>
									</div>
								</div><!--/ .stage-->





								<div class="stage col-md-3 col-sm-3" id="stage4">
									<div class="stage-header head-icon head-icon-details"></div>
									<div class="stage-content">
										<h3 class="stage-title">Generar Preguntas</h3>
										<div class="stage-info">
											Cree las preguntas se su encuesta
										</div>
									</div>
								</div><!--/ .stage-->
									<div class="stage  col-md-3 col-sm-3" id="stage5">
										<div class="stage-header head-icon head-icon-payment"></div>
										<div class="stage-content">
											<h3 class="stage-title">Texto Finalizacion</h3>
											<div class="stage-info">
												Ingrese el texto Final
											</div>
										</div>
									</div><!--/ .stage-->
										<div class="stage col-md-3 col-sm-3" id="stage6">
											<div class="stage-header head-icon head-icon-details"></div>
											<div class="stage-content">
												<h3 class="stage-title">Confirma la encuesta</h3>
												<div class="stage-info">
													Guarda la encuesta
												</div>
											</div>
										</div><!--/ .stage-->


					</div><!--/ .row-->

					<div class="row">

						<div class="col-xs-12">

							<div class="form-header">

								<div class="form-title form-icon title-icon-user">
									<b>Informacion</b> General
								</div>
								<div class="steps">
									Paso 1 - 6
								</div>

							</div><!--/ .form-header-->

						</div>

					</div><!--/ .row-->

					<form action="/" role="form" >

						<div class="form-wizard" id="paso1">

							<div class="row">

								<div class="col-md-8 col-sm-7">

									<div class="row">

										<div class="col-md-4 col-sm-4">




											<div class="input-block">
												<label>Cliente</label>
												<input name="clientes" type="text" id="clientes" placeholder="" required />
												</div><!--/ .dropdown-->
												
											</div><!--/ .input-role-->
<div class="col-md-4 col-sm-4">




											<div class="input-block">
												<label>Evento</label>
																								<input name="eventos" type="text" id="eventos" placeholder="" required />

												</div><!--/ .dropdown-->
												
											</div><!--/ .input-role-->
										</div>

										</div><div class="col-md-4 col-sm-4">




											<div class="input-block">
												<div>
												<button class="button button-" type="button" id="nuevoEvento" style="
    margin-top: 27px;
"><span id="textoEvento"  >Agregar Evento<b></b></span></button>
												</div><!--/ .dropdown-->
												
												
											</div><!--/ .input-role-->

										</div>
										<div class="col-md-4 col-sm-4" style="display:none" id="formEvento">

<img id="uploadPreview" style="width: 200px; height: 200px;" />
<input id="uploadImage" type="file" name="myPhoto" onchange="PreviewImage();" />



										</div>

										

									</div>

									<div class="row">

										<div class="col-md-6 col-sm-6">
											<fieldset class="input-block">
												<label for="first-name">Objetivo</label>
												<input name="objetivo" id="objetivo" type="text" id="first-name" placeholder="Objetivo" required />
												
											</fieldset><!--/ .input-first-name-->
										</div>

										<div class="col-md-6 col-sm-6">
											<fieldset class="input-block">
												<label for="last-name">Multiples respuestas por usuario</label>
												<input name="multiples" type="checkbox" id="last-name" placeholder="Surname" required />
									
											</fieldset><!--/ .input-first-name-->
										</div>

									</div><!--/ .row-->




									<div class="row">

										<div class="col-md-4 col-sm-4">
											<fieldset class="input-block">
				
												<label for="zip-code">Fecha Inicio</label>
												<input name="fechaInicio" type="text" id="fechaInicio" class="datepicker "placeholder="Inicio en.." required />
											
											</fieldset><!--/ .code-->
										</div>

										<div class="col-md-4 col-sm-4">
											<fieldset class="input-block">
												<label for="zip-code">Fecha Fin</label>
												<input name="fechaFinal" type="text" id="fechaFin" class="datepicker "placeholder="Finaliza en.." required />
											
											</fieldset><!--/ .code-->
										</div>

									</div><!--/ .row-->



								</div>

							
						<div class="form-wizard" id="paso2" style="display:none">

							<div class="row">

								<div class="col-md-8 col-sm-7">

									<div class="row">

										<div class="col-md-12 col-sm-12">
											<fieldset class="input-block">
												<label>Idiomas</label>
												<div class="dropdown">
													<select id="idiomasSeleccion" name="idiomas" class="dropdown-select" multiple="true" style="
    height: 100%;
">
														<option value="1">Español</option>
														<option value="2">Ingles</option>
														<option value="3">Aleman</option>
														<option value="4">Ruso</option>
													</select>
												</div><!--/ .input-dropdown-->
											</fieldset><!--/ .input-card-type-->
										</div>

									</div><!--/ .row-->


								</div>

							</div><!--/ .row-->

						</div><!--/ .form-wizard-->
						<div class="form-wizard" id="paso3" style="display:none">

							<div class="row">

								<div class="col-md-8 col-sm-7">

									<div class="row">

										<div class="col-md-12 col-sm-12">
											<fieldset class="input-block" id="textoInicio">
												
											</fieldset><!--/ .input-card-type-->
										</div>

									</div><!--/ .row-->


								</div>

							</div><!--/ .row-->

						</div><!--/ .form-wizard-->
	<div class="form-wizard" id="paso4" style="display:none">

							<div class="row">

								<div class="col-md-8 col-sm-7">

									<div class="row">

										<div class="col-md-12 col-sm-12">
										<a href="#" id="verPreview">Ver Preview Encuestas</a>
											<div class='fb-main'></div>
										</div>

									</div><!--/ .row-->


								</div>

							</div><!--/ .row-->

						</div><!--/ .form-wizard-->
							<div class="form-wizard" id="paso5" style="display:none">

							<div class="row">

								<div class="col-md-8 col-sm-7">

									<div class="row">

										<div class="col-md-12 col-sm-12">
											<fieldset class="input-block" id="textoFinal">
												
											</fieldset><!--/ .input-card-type-->
										</div>

									</div><!--/ .row-->


								</div>

							</div><!--/ .row-->

						</div><!--/ .form-wizard-->
								<div class="form-wizard"  id="paso6" style="display:none">

							<div class="row">

								<div class="col-md-8 col-sm-7">

									<div class="row">

										<div class="col-md-12 col-sm-12">
											<fieldset class="input-block">

												<button type="button" style="color: #146B98;" id="guardar">Guardar</button>

											<label for="plantilla">Guardar como plantilla</label>
											<input type="checkbox" id="plantilla" placeholder="Surname" required />

											</fieldset><!--/ .input-card-type-->
										</div>

									</div><!--/ .row-->


								</div>

							</div><!--/ .row-->

						</div><!--/ .form-wizard-->

					<div class="prev">
							<button class="button button-control" type="button" id="anterior"><span>Anterior Paso <b></b></span></button>
							<div class="button-divider"></div>
						</div>
						<div class="next">
							<button class="button button-control" type="button" id="proximo"><span>Proximo Paso <b></b></span></button>
							<div class="button-divider"></div>
						</div>

					</form><!--/ form-->
			

				</div><!--/ .container-->

			</div><!--/ .form-container-->

		</div><!--/ #content-->


		<!-- - - - - - - - - - - - end Content - - - - - - - - - - - - - -->


	
		<script>
		 var idiomas=[];
    $( document ).ready(function() {
	
	     //
	     rellenarCampos()
		var pasoNumero=1;
		
		 		var cantidadElementos=0;

  
        $( "#proximo" ).click(function() {
		 if ( validate(pasoNumero)){
			$( "#paso"+pasoNumero).css("display","none")
			$( "#stage"+pasoNumero).removeClass("tmm-current")
			$( "#stage"+pasoNumero).addClass("tmm-success")
		   
		
			if (pasoNumero==2){
			 idiomas=[]
				$('#idiomasSeleccion :selected').each(function(i, selected){ 
				var foo = []; 
				foo[i] = $(selected).text();
				if (cantidadElementos==0){
					idiomas.push(foo[i])
					cantidadElementos++
				}else{
					idiomas.push(foo[i])
				}
			
	
		});
		
		}
			console.log("ID",idiomas)
		    pasoNumero++;	
			if (pasoNumero==3){
			$("#textoInicio").empty()
						for(var i in idiomas)
				{
					$("#textoInicio").append('<label>Texto Introduccion ('+idiomas[i]+')</label><input name="textoIntroduccion" type="text" id="zip-code" placeholder="Texto" required />')
              }
          }
		  	if (pasoNumero==5){
			$("#textoFinal").empty()
						for(var i in idiomas)
				{
					$("#textoFinal").append('<label>Texto Final ('+idiomas[i]+')</label><input name="textoFinal" type="text" id="zip-code" placeholder="Texto" required />')
              }
          }

			$( "#paso"+pasoNumero).css("display","block")
			$( "#stage"+pasoNumero).addClass("tmm-current")
			}
		});
		 $( "#anterior" ).click(function() {
			$( "#paso"+pasoNumero).css("display","none")
			$( "#stage"+pasoNumero).removeClass("tmm-current")
			pasoNumero--;	
			$( "#paso"+pasoNumero).css("display","block")
			$( "#stage"+pasoNumero).addClass("tmm-current")
			$( "#stage"+pasoNumero).removeClass("tmm-success")
			
		});
		
    
   
	$("#verPreview").click(function() {
	window.open("http://belasoft.com.ar/encuestarubra/render/examples/index.html?json="+formInfo);
	//
		
	});
		function search_array(array,valuetofind) {
    for (i = 0; i < array.length; i++) {
        if (array[i]['name'] === valuetofind) {
            return array[i]['value'];
        }
    }
	}
	function searchArrays2(array,valuetofind) {
	var datos=[]
	console.log("valueTOfind",valuetofind)
    for (i = 0; i < array.length; i++) {
        if (array[i]['name'] === valuetofind) {
		console.log("ENCONTRO")
            datos.push(array[i]['value']);
        }
    }
	return datos
    //return -1;
}
function getTextoInicial(){
   var datos=[]
	$('[name="textoIntroduccion"]').each(function () {
	  datos.push({"valor":$(this).val(),"idioma":$(this).attr("idioma")});
		
	
	});
	console.log("DATOS",datos)
	return datos
	}
function getTextoFinal(){
	var datos=[]
	$('[name="textoFinal"]').each(function () {
 datos.push({"valor":$(this).val(),"idioma":$(this).attr("idioma")});
		
	
	});
	console.log("DATOS",datos)
	return datos
	}
$("#guardar").click(function() {
	  console.log("ANTES",getTextoInicial())
	  var datosForm=$("form").serializeArray();
	  //le agrego datos del FormBuilder
	  var objetoPrueba={}
	  objetoPrueba.cliente=search_array(datosForm,"clientes")
      objetoPrueba.evento=search_array(datosForm,"eventos")
	  objetoPrueba.objetivo=search_array(datosForm,"objetivo")
	  objetoPrueba.fechaInicio=search_array(datosForm,"fechaInicio")
	  objetoPrueba.fechaFinal=search_array(datosForm,"fechaFinal")
	  objetoPrueba.textoFinal=getTextoFinal()
	  objetoPrueba.textoInicial=getTextoInicial()
	  objetoPrueba.id="2"
	  //Recuperar Info Idiomas ,Textos Iniciales y Finales
	  objetoPrueba.idiomas=searchArrays2(datosForm,"idiomas")
	 // objetoPrueba.idiomas.push("1")
	 console.log("FORMAjt",formInfo)
	  objetoPrueba.form=formInfo
	  console.log("prueba",objetoPrueba)
	  //datosForm.push(JSON.parse(formInfo))
//console.log("datpsFPr,",datosForm
console.log("FORMDE",formInfo)
	
		  $.ajax({
    url: '../RubraEncuesta7/guardarEncuesta2.php',
    type: 'post',
    //data: JSON.stringify(datosForm),
	data: {"info" : JSON.stringify(objetoPrueba)},
    //contentType: 'application/json; charset=utf-8',
//dataType: 'json',
    //async: false,
    success: function(msg) {
        alert(msg);
    }
});
	});
	
	$("#nuevoEvento").click(function() {
	if ($( "#formEvento").hasClass("visible")){
		$( "#formEvento").css("display","none")
	  $( "#formEvento").removeClass("visible")
	  $('#comboEventos').attr('disabled',false);
	  $( "#textoEvento").text("Agregar Evento" )
	}else{
	$( "#formEvento").css("display","block")
	$('#comboEventos').attr('disabled',true);
	  $( "#formEvento").addClass("visible")
	  $( "#textoEvento").text("Remover Evento" )
	}
	  
		
	});
	
	   $('.datepicker').datepicker({format: 'mm/dd/yyyy'})
	   
	   var clientes = [
      "ActionScript",
      "AppleScript",
      "Asp",
      "BASIC",
      "C",
      "C++",
      "Clojure",
      "COBOL",
      "ColdFusion",
      "Erlang",
      "Fortran",
      "Groovy",
      "Haskell",
      "Java",
      "JavaScript",
      "Lisp",
      "Perl",
      "PHP",
      "Python",
      "Ruby",
      "Scala",
      "Scheme"
    ];
    $( "#clientes" ).autocomplete({
      source: clientes
    });
	 $( "#eventos" ).autocomplete({
      source: clientes
    });
	   
    });
	  function PreviewImage() {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("uploadImage").files[0]);

        oFReader.onload = function (oFREvent) {
            document.getElementById("uploadPreview").src = oFREvent.target.result;
        };
    };
	  function validate(step) {
	  var esValido=true
      if (step==1){
		$('#paso1').find("input").each(function () {
			if ($(this).val()=="" && $(this).attr('id')!="uploadImage"){
				$(this).css("border-color","red")
				esValido=false;
			}else{
			   $(this).css("border-color","#c4cdcf")
			}
	  
		});
	  }
	  if (step==2){
	  if ($('#idiomasSeleccion :selected').length==0){
	  esValido=false;
	  $('#idiomasSeleccion').css("color","red")
	  }else{
	   $('#idiomasSeleccion').css("color","#b5b5b5")
	  }
	  
		
	  }
	  if (step==3){
		$('#paso3').find("input").each(function () {
			if ($(this).val()==""){
				$(this).css("border-color","red")
				esValido=false;
			}else{
			   $(this).css("border-color","#c4cdcf")
			}
	  
		});
		
	  }
	   if (step==5){
		$('#paso5').find("input").each(function () {
			if ($(this).val()==""){
				$(this).css("border-color","red")
				esValido=false;
			}else{
			   $(this).css("border-color","#c4cdcf")
			}
	  
		});
		
	  }
	  return esValido;
    };
     function rellenarCampos(){
	 
	 
	 //ACA RECUPERAR LA DATA POSTA,Lo siguiente es a modo ejemplo
	 var encuesta = new Object();
		 encuesta.json= [{
    "label": "Please enter your clearance number",
    "field_type": "text",
    "required": true,
    "field_options": {},
    "cid": "c6"
}, {
    "label": "Security personnel #82?",
    "field_type": "radio",
    "required": true,
    "field_options": {
        "options": [{
            "label": "Yes",
            "checked": false
        }, {
            "label": "No",
            "checked": false
        }],
        "include_other_option": true
    },
    "cid": "c10"
}, {
    "label": "Medical history",
    "field_type": "file",
    "required": true,
    "field_options": {},
    "cid": "c14"
}];
	
	
		 
		 
		 
		 
		 
		 
		 
		encuesta.cliente="Roche";
	     encuesta.evento="Beneicio";
		 encuesta.objetivo="Plata";
		encuesta.eventoImg="logo.png"
		encuesta.fechaIni="12-04-2015";
		encuesta.fechaFin="12-05-2015";
		encuesta.id="222"
		encuesta.idiomas=["1","2"]
		
	  idiomas=encuesta.idiomas;
	  //Completo paso 1
	 $('#fechaInicio').val(encuesta.fechaIni)
	 $('#fechaFin').val(encuesta.fechaFin)
	 $('#clientes').val(encuesta.cliente)
	 $('#eventos').val(encuesta.evento)
	 $('#objetivo').val( encuesta.objetivo)
	 
	 //Completo paso 2
	 $('#idiomasSeleccion option').each(function(i, selected){ 
				var foo = []; 
				texto = $(this).val();
				
				for (var idioma in encuesta.idiomas) {
				console.log("TEXTO",texto, "Encuesta", encuesta.idiomas[idioma])
	               if (texto ==encuesta.idiomas[idioma]){
				   				console.log("siTEXTO",texto, "Encuesta" ,encuesta.idiomas[idioma])

				   $('#idiomasSeleccion option[value=' + texto + ']').attr('selected', true);
				   }
				}
	
		});
	 
	 //Completo paso 4
	 formInfo=encuesta.json["fields"]
	 
	 
	 
	 
	 
	 
	 
	 
	 
	  $(function(){
	  console.log("AHAHA",encuesta.json["fields"])
      fb = new Formbuilder({
        selector: '.fb-main',
       // bootstrapData: [encuesta.json["fields"]]
	   bootstrapData:[{
            "label": "Do you have a websiteaaa?",
            "field_type": "website",
            "required": false,
            "field_options": {},
			"language":"Jamaica",
            "cid": "c1"
          },{
		   "label": "Do you have a website?",
            "field_type": "website",
            "required": false,
            "field_options": {},
			"language":"Cha",
            "cid": "c1"
          }]
      });

      fb.on('save', function(payload){
        console.log(payload);
		formInfo=payload;
      })
	  
    });
	
	 
	 
	 
	 
	 
	 
	 
	 }
    
    </script>

	</body>
</html>