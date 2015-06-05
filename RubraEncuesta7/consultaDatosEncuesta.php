<!DOCTYPE html>
<!--[if lte IE 8]>              <html class="ie8 no-js" lang="en">     <![endif]-->
<!--[if IE 9]>					<html class="ie9 no-js" lang="en-US">  <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html class="not-ie no-js" lang="en">
<!--<![endif]-->

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

     <!-- <script src="../vendor/js/vendor.js"></script>
    <script src="../dist/formbuilder.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script src="http://code.jquery.com/ui/1.11.3/jquery-ui.js"></script>-->




		<script src="../vendor/js/vendor.js"></script>
	<script src="../dist/formbuilder.js"></script>
	<script src="../wizard/ui/core.js"></script>
	<script src="../wizard/ui/widget.js"></script>
	<script src="../wizard/ui/position.js"></script>
	<script src="../wizard/ui/menu.js"></script>
	<script src="../wizard/ui/autocomplete.js"></script>
	<script src="../wizard/ui/datepicker.js"></script>
	 <script src="../wizard/dateSpanish.js"></script>



    <!--[if lt IE 9]>
				<script src="js/respond.min.js"></script>
		<![endif]-->

    <script src="js/tmm_form_wizard_custom.js"></script>

</head>

<body>


    <!-- - - - - - - - - - - - - Content - - - - - - - - - - - - -  -->


    <div id="content">

        <div class="form-container" style="
			    width: 2000x" ;>

            <div id="tmm-form-wizard" class="container substrate" style="
				    width: 2000px" ;>

                <div class="row">

                    <div class="col-xs-12">
                        <h2 class="form-login-heading">Generador de Encuestas<span></span></h2>
                    </div>

                </div>
                <!--/ .row-->

                <div class="row stage-container">
                    <div class="stage tmm-current col-md-3 col-sm-3" id="stage1">
                        <div class="stage-header head-icon head-icon-lock"></div>
                        <div class="stage-content">
                            <h3 class="stage-title">Informacion General</h3>
                            <div class="stage-info">
                                Ingrese informacion general de la encuesta
                            </div>
                        </div>
                    </div>
                    <!--/ .stage-->





                    <div class="stage  col-md-3 col-sm-3" id="stage2">
                        <div class="stage-header head-icon head-icon-user"></div>
                        <div class="stage-content">
                            <h3 class="stage-title">Seleccion Idiomas</h3>
                            <div class="stage-info">
                                Elija los idiomas deseados de la encuestas
                            </div>
                        </div>
                    </div>
                    <!--/ .stage-->
                    <div class="stage  col-md-3 col-sm-3" id="stage3">
                        <div class="stage-header head-icon head-icon-payment"></div>
                        <div class="stage-content">
                            <h3 class="stage-title">Texto Introduccion</h3>
                            <div class="stage-info">
                                Ingrese el texto introductorio
                            </div>
                        </div>
                    </div>
                    <!--/ .stage-->





                    <div class="stage col-md-3 col-sm-3" id="stage4">
                        <div class="stage-header head-icon head-icon-details"></div>
                        <div class="stage-content">
                            <h3 class="stage-title">Generar Preguntas</h3>
                            <div class="stage-info">
                                Cree las preguntas se su encuesta
                            </div>
                        </div>
                    </div>
                    <!--/ .stage-->
                    <div class="stage  col-md-3 col-sm-3" id="stage5">
                        <div class="stage-header head-icon head-icon-payment"></div>
                        <div class="stage-content">
                            <h3 class="stage-title">Texto Finalizacion</h3>
                            <div class="stage-info">
                                Ingrese el texto Final
                            </div>
                        </div>
                    </div>
                    <!--/ .stage-->
                    <div class="stage col-md-3 col-sm-3" id="stage6">
                        <div class="stage-header head-icon head-icon-details"></div>
                        <div class="stage-content">
                            <h3 class="stage-title">Confirma la encuesta</h3>
                            <div class="stage-info">
                                Guarda la encuesta
                            </div>
                        </div>
                    </div>
                    <!--/ .stage-->


                </div>
                <!--/ .row-->

                <div class="row">

                    <div class="col-xs-12">

                        <div class="form-header">

                            <div class="form-title form-icon title-icon-user">
                                <b>Informacion</b> General
                            </div>
                            <div class="steps">

                            </div>

                        </div>
                        <!--/ .form-header-->

                    </div>

                </div>
                <!--/ .row-->

                <form action="/" role="form">

                    <div class="form-wizard" id="paso1">

                        <div class="row">

                            <div class="col-md-8 col-sm-7">

                                <div class="row">

                                    <div class="col-md-4 col-sm-4">




                                        <div class="input-block">
                                            <label>Cliente</label>
                                            <input name="clientes" type="text" id="clientes" placeholder="" required disabled />
                                        </div>
                                        <!--/ .dropdown-->

                                    </div>
                                    <!--/ .input-role-->
                                    <div class="col-md-4 col-sm-4">




                                        <div class="input-block">
                                            <label>Evento</label>
                                            <input name="eventos" type="text" id="eventos" placeholder="" required disabled/>

                                        </div>
                                        <!--/ .dropdown-->

                                    </div>
                                    <!--/ .input-role-->
                                </div>

                            </div>
                            <div class="col-md-4 col-sm-4">



                                <!--/ .input-role-->

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

                                </fieldset>
                                <!--/ .input-first-name-->
                            </div>



                        </div>
                        <!--/ .row-->




                        <div class="row">

                            <div class="col-md-4 col-sm-4">
                                <fieldset class="input-block">

                                    <label for="zip-code">Fecha Inicio</label>
                                    <input name="fechaInicio" type="text" id="fechaInicio" class="datepicker " placeholder="Inicio en.." required readonly='true'/>

                                </fieldset>
                                <!--/ .code-->
                            </div>

                            <div class="col-md-4 col-sm-4">
                                <fieldset class="input-block">
                                    <label for="zip-code">Fecha Fin</label>
                                    <input name="fechaFinal" type="text" id="fechaFinal" class="datepicker " placeholder="Finaliza en.." required readonly='true'/>

                                </fieldset>
                                <!--/ .code-->
                            </div>

                        </div>
                        <!--/ .row-->



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

                                                </select>
                                            </div>
                                            <!--/ .input-dropdown-->
                                        </fieldset>
                                        <!--/ .input-card-type-->
                                    </div>

                                </div>
                                <!--/ .row-->


                            </div>

                        </div>
                        <!--/ .row-->

                    </div>
                    <!--/ .form-wizard-->
                    <div class="form-wizard" id="paso3" style="display:none">

                        <div class="row">

                            <div class="col-md-8 col-sm-7">

                                <div class="row">

                                    <div class="col-md-12 col-sm-12">
                                        <fieldset class="input-block" id="textoInicio">

                                        </fieldset>
                                        <!--/ .input-card-type-->
                                    </div>

                                </div>
                                <!--/ .row-->


                            </div>

                        </div>
                        <!--/ .row-->

                    </div>
                    <!--/ .form-wizard-->
                    <div class="form-wizard" id="paso4" style="display:none">

                        <div class="row">

                            <div class="col-md-8 col-sm-7">

                                <div class="row">

                                    <div class="col-md-12 col-sm-12">
                                        <a href="#" id="verPreview">Ver Preview Encuestas</a>
                                        <div class='fb-main'></div>
                                    </div>

                                </div>
                                <!--/ .row-->


                            </div>

                        </div>
                        <!--/ .row-->

                    </div>
                    <!--/ .form-wizard-->
                    <div class="form-wizard" id="paso5" style="display:none">

                        <div class="row">

                            <div class="col-md-8 col-sm-7">

                                <div class="row">

                                    <div class="col-md-12 col-sm-12">
                                        <fieldset class="input-block" id="textoFinal">

                                        </fieldset>
                                        <!--/ .input-card-type-->
                                    </div>

                                </div>
                                <!--/ .row-->


                            </div>

                        </div>
                        <!--/ .row-->

                    </div>
                    <!--/ .form-wizard-->
                    <div class="form-wizard" id="paso6" style="display:none">

                        <div class="row">

                            <div class="col-md-8 col-sm-7">

                                <div class="row">

                                    <div class="col-md-12 col-sm-12">
                                        <fieldset class="input-block elementosGuardar">

                                            <button type="button" style="color: #146B98;font-size: x-large;" id="guardar">Guardar</button>
<img id="imagenCarga" src="http://www.csplglobal.com/images1/ux/bkg-loading-wheel.gif" alt="Smiley face" height="21" width="21" style="display: none;">
                                            <p>
                                                <label for="plantilla" style="
    font-size: 24px;">Guardar como plantilla</label>
                                                <input type="checkbox" id="plantilla" class="deseleccionado" placeholder="Surname" required="">
                                            </p>


                                            <input type="text" id="nombrePlantilla" placeholder="Nombre Plantilla" required="" style="display: none;">


                                        </fieldset>
                                    </div>

                                </div>
                                <!--/ .row-->


                            </div>

                        </div>
                        <!--/ .row-->

                    </div>
                    <!--/ .form-wizard-->

                    <div class="prev">
                        <button class="button button-control" type="button" id="anterior"><span class="botonAnteriorTexto" >Paso Anterior<b></b></span>
                        </button>
                        <div class="button-divider"></div>
                    </div>
						<div class="next" style="
						    position: inherit;
						">
	                        <button class="button button-control" type="button" id="cancelarEncuesta" style="
							    margin-left: 50px;
							"><span>Cancelar <b></b></span>
	                        </button>
	                        <div class="button-divider"></div>
	                    </div>
                    <div class="next">
                        <button class="button button-control" type="button" id="proximo"><span>Proximo Paso <b></b></span>
                        </button>
                        <div class="button-divider"></div>
                    </div>

                </form>
                <!--/ form-->


            </div>
            <!--/ .container-->

        </div>
        <!--/ .form-container-->

    </div>
    <!--/ #content-->


    <!-- - - - - - - - - - - - end Content - - - - - - - - - - - - - -->



    <script>
        var idiomas = [];
        var idiomasID = [];
        var encuesta;
		var idiomasSeleccionados=0

        var idEncuesta;

        $(document).ready(function() {
            //
console.log("EMMM")
            var objetoEditar = {}

            objetoEditar.id = getParameterByName("id");

            $.ajax({
                url: '../RubraEncuesta7/clases/getEncuestaById.php',
                type: 'post',
                data: {
                    "info": JSON.stringify(objetoEditar)
                },
                success: function(msg) {
                    encuesta = JSON.parse(msg);
                    console.log("Resultado", JSON.parse(msg))
                    console.log("Encuesta", encuesta)
					getIdiomas();


                }
            });





            //rellenarCampos()
            var pasoNumero = 1;

            var cantidadElementos = 0;
            $(".prev").css("display", "none")
            $(".steps").append("Paso 1 de 6")
            $("#plantilla").click(function() {
                if ($(this).hasClass("deseleccionado")) {
                    $(this).removeClass("deseleccionado")
                    $("#nombrePlantilla").css("display", "block")
                } else {
                    $(this).addClass("deseleccionado")
                    $("#nombrePlantilla").css("display", "none")
                }
            });
$("#idiomasSeleccion").change(function(){
    console.log("SELESELE!",idiomasID)
	setearIdiomas()
	console.log("SELESELE!",idiomasID)
});

			$("#cancelarEncuesta").click(function() {
					window.location.href="http://belasoft.com.ar/encuestarubra/RubraEncuesta7/verEncuesta.php"
				})
            $("#proximo").click(function() {
                if (validate(pasoNumero)) {
                    $("#paso" + pasoNumero).css("display", "none")
                    $("#stage" + pasoNumero).removeClass("tmm-current")
                    $("#stage" + pasoNumero).addClass("tmm-success")


                    if (pasoNumero == 2) {
                        idiomas = []
                        idiomasID = [];
                        $('#idiomasSeleccion :selected').each(function(i, selected) {
                            var foo = [];
                            foo[i] = $(selected).text();
                            val = $(selected).val();
                            if (cantidadElementos == 0) {
                                idiomas.push(foo[i])
                                idiomasID.push(val)
                                cantidadElementos++
                            } else {
                                idiomas.push(foo[i])
                                idiomasID.push(val)
                            }


                        });
getControlesNuevos()
                    }
                    console.log("ID", idiomas)
                    pasoNumero++;
                    if (pasoNumero == 3) {
                        //$("#textoInicio").empty()
                        $(".noBorrar").removeClass("noBorrar")
                        for (var i in idiomas) {
                            if ($('input[name="textoIntroduccion"][idioma=' + idiomasID[i] + ']').length == 0) {
                                console.log("ENTRA PARA", idiomasID[i])
                                console.log("Selector", $('input[idioma=' + idiomasID[i] + ']'))
                                $("#textoInicio").append('<label>Texto Introduccion (' + idiomas[i] + ')</label><input name="textoIntroduccion" type="text"  placeholder="Texto" required idioma=' + idiomasID[i] + ' class="noBorrar"/>')
                            } else {
                                $('input[name="textoIntroduccion"][idioma=' + idiomasID[i] + ']').addClass("noBorrar")
                            }
                        }
                        //Ahora borro todos los elementos que no tengan la clase borrar,junto con sus padres,que son los Labels.Elementos de texto
                        //de cierto Idioma que fueron borrados
                        $('input[name="textoIntroduccion"]').not('.noBorrar').prev().remove();
                        $('input[name="textoIntroduccion"]').not('.noBorrar').remove();



                    }
                    if (pasoNumero == 5) {
                        //$("#textoFinal").empty()
                        $(".noBorrarFinal").removeClass("noBorrarFinal")
                        for (var i in idiomas) {
                            if ($('input[name="textoFinal"][idioma=' + idiomasID[i] + ']').length == 0) {
                                $("#textoFinal").append('<label>Texto Final (' + idiomas[i] + ')</label><input name="textoFinal" type="text" placeholder="Texto" required idioma=' + idiomasID[i] + ' class="noBorrarFinal"/ />')
                            } else {
                                $('input[name="textoFinal"][idioma=' + idiomasID[i] + ']').addClass("noBorrarFinal")
                            }
                        }


                        //Ahora borro todos los elementos que no tengan la clase borrar,junto con sus padres,que son los Labels.Elementos de texto
                        //de cierto Idioma que fueron borrados
                        $('input[name="textoFinal"]').not('.noBorrarFinal').prev().remove();
                        $('input[name="textoFinal"]').not('.noBorrarFinal').remove();
                    }
                    if (pasoNumero == 6) {
                        $(".next").css("display", "none")
                    } else {
                        $(".next").css("display", "block")
                    }

                    if (pasoNumero == 1) {
                        $(".prev").css("display", "none")
                    } else {
                        $(".prev").css("display", "block")
                    }
                    cambiarTextosTitulo()

                    $("#paso" + pasoNumero).css("display", "block")
                    $("#stage" + pasoNumero).addClass("tmm-current")
                }
                $(".steps").empty()
                $(".steps").append("Paso " + pasoNumero + " de 6 ")
            });
            $("#anterior").click(function() {
               if (!$(".botonAnteriorTexto").hasClass("menu") ) {
                    $("#paso" + pasoNumero).css("display", "none")
                    $("#stage" + pasoNumero).removeClass("tmm-current")
                    pasoNumero--;
                    $("#paso" + pasoNumero).css("display", "block")
                    $("#stage" + pasoNumero).addClass("tmm-current")
                    $("#stage" + pasoNumero).removeClass("tmm-success")
                    $(".steps").empty()
                    $(".steps").append("Paso " + pasoNumero + " de 6 ")
                    if (pasoNumero == 1) {
                        $(".prev").css("display", "none")
                    } else {
                        $(".prev").css("display", "block")
                    }
                    if (pasoNumero == 6) {
                        $(".next").css("display", "none")
                    } else {
                        $(".next").css("display", "block")
                    }

                    cambiarTextosTitulo()

                } else {
                    window.location.href = "http://belasoft.com.ar/encuestarubra/RubraEncuesta7/";
                }
            });




            $("#verPreview").click(function() {
                window.open("http://belasoft.com.ar/encuestarubra/render/examples/index.html?json=" + formInfo);
                //

            });


            function getIdiomas() {

                $.ajax({
                    url: '../RubraEncuesta7/clases/getIdiomas.php',
                    type: 'get',

                    success: function(msg) {
                        console.log("idiomas", msg)
                        var valorParseado = JSON.parse(msg);
                        for (var i in valorParseado["idiomas"]) {
                            $("#idiomasSeleccion").append('<option value=' + valorParseado["idiomas"][i]["id"] + '>' + valorParseado["idiomas"][i]["nombre"] + '</option>')
                        }
                        rellenarCampos()


                        //  var valorParseado=JSON.parse(msg);


                    }
                });

            };
			function getControlesNuevos() {
				var objetoPrueba = {}

                objetoPrueba.idEncuesta = idEncuesta
                objetoPrueba.idiomas = idiomasID

         		$.ajax({
                    url: '/encuestarubra/RubraEncuesta7/clases/getControlesNuevoByPlantilla.php',
                    type: 'post',
                    data: {
                        "info": JSON.stringify(objetoPrueba)
                    },
                    //contentType: 'application/json; charset=utf-8',
                    //dataType: 'json',
                    //async: false,
                    success: function(msg) {
                        console.log("MSg",msg)
                    }
                });

            };

            function search_array(array, valuetofind) {
                for (i = 0; i < array.length; i++) {
                    if (array[i]['name'] === valuetofind) {
                        return array[i]['value'];
                    }
                }
            }

            function searchArrays2(array, valuetofind) {
                var datos = []
                console.log("valueTOfind", valuetofind)
                for (i = 0; i < array.length; i++) {
                    if (array[i]['name'] === valuetofind) {
                        console.log("ENCONTRO")
                        datos.push(array[i]['value']);
                    }
                }
                return datos
                    //return -1;
            }



            function cambiarTextosTitulo() {
                $(".form-title").empty()
                if (pasoNumero == 1) {
                    $(".form-title").append("Informacion General")
                }
                if (pasoNumero == 2) {
                    $(".form-title").append("Idiomas")
                }
                if (pasoNumero == 3) {
                    $(".form-title").append("Textos Iniciales")
                }
                if (pasoNumero == 4) {
                    $(".form-title").append("Creacion Encuesta")
                }
                if (pasoNumero == 5) {
                    $(".form-title").append("Textos Finales")
                }
                if (pasoNumero == 6) {
                    $(".form-title").append("Confirmar")
                }

            }
  function setearIdiomas(){
    idiomas = []
                        idiomasID = [];
                        $('#idiomasSeleccion :selected').each(function(i, selected) {
                            var foo = [];
                            foo[i] = $(selected).text();
                            val = $(selected).val();
                            if (cantidadElementos == 0) {
                                idiomas.push(foo[i])
                                idiomasID.push(val)
                                cantidadElementos++
                            } else {
                                idiomas.push(foo[i])
                                idiomasID.push(val)
                            }


                        });











  }
            function getTextoInicial() {
                var datos = []
                $('[name="textoIntroduccion"]').each(function() {
                    datos.push({
                        "valor": $(this).val(),
                        "idioma": $(this).attr("idioma")
                    });


                });
                console.log("DATOS", datos)
                return datos
            }

            function getTextoFinal() {
                var datos = []
                $('[name="textoFinal"]').each(function() {
                    datos.push({
                        "valor": $(this).val(),
                        "idioma": $(this).attr("idioma")
                    });


                });
                console.log("DATOS", datos)
                return datos
            }
            $("#guardar").click(function() {
                console.log("ANTES", getTextoInicial())
                var datosForm = $("form").serializeArray();
                //le agrego datos del FormBuilder
                var objetoPrueba = {}

                objetoPrueba.objetivo = search_array(datosForm, "objetivo")
                objetoPrueba.fechaInicio = search_array(datosForm, "fechaInicio")
                objetoPrueba.fechaFinal = search_array(datosForm, "fechaFinal")
                objetoPrueba.textoFinal = getTextoFinal()
				objetoPrueba.nombrePlantilla = $("#nombrePlantilla").val()
                objetoPrueba.textoInicial = getTextoInicial()
                objetoPrueba.id = idEncuesta;
                //Recuperar Info Idiomas ,Textos Iniciales y Finales
                objetoPrueba.idiomas = searchArrays2(datosForm, "idiomas")

                objetoPrueba.form = formInfo
           $("#imagenCarga").css("display", "block")
                console.log("FORMDE", formInfo)

                $.ajax({
                    url: '/encuestarubra/RubraEncuesta7/clases/updateEncuesta.php',
                    type: 'post',
                    data: {
                        "info": JSON.stringify(objetoPrueba)
                    },
                    //contentType: 'application/json; charset=utf-8',
                    //dataType: 'json',
                    //async: false,
                    success: function(msg) {
                        //Acomodo Pantalla
                        $(".stage-container").remove()
                        $(".elementosGuardar").remove()
                        $(".steps").remove()
                        $("#proximo").remove();
                        $(".botonAnteriorTexto").text("Volver al Menu")
						 $(".botonAnteriorTexto").addClass("menu")
                        $(".form-title").empty()
                        $(".form-title").append("<b>En hora buena!Encuesta generada!</b>")


                        console.log("SDADA2", JSON.parse(msg))
                        var valores = JSON.parse(msg);
                        $(".linksFinal").append("A continuacion ,las encuestas generadas:")
                        for (var i in valores) {
                            $(".linksFinal").append('<p><a href=' + valores[i]["link"] + '>Encuesta ' + valores[i]["idiomaNombre"] + '</a></p>')
                        }
                        //console.log("MENSA",msg)
                    }
                });
            });



            $('#fechaInicio').datepicker({
                format: 'dd-mm-yyyy',
                onSelect: function(selected) {
                    $("#fechaFinal").datepicker("option", "minDate", selected)
					console.log("SELECCINA")
                }
            })
console.log("ENTRAINICIO")

            $('#fechaFinal').datepicker({
                format: 'dd/mm/yyyy',
                onSelect: function(selected) {
                    $("#fechaInicio").datepicker("option", "maxDate", selected)

                }
            })



        });

        function getParameterByName(name) {
            name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
            var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
                results = regex.exec(location.search);
            return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
        }

        function PreviewImage() {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("uploadImage").files[0]);

            oFReader.onload = function(oFREvent) {
                document.getElementById("uploadPreview").src = oFREvent.target.result;
            };
        };

        function validate(step) {
            var esValido = true
            if (step == 1) {
                $('#paso1').find("input").each(function() {
                    if ($(this).val() == "" && $(this).attr('id') != "uploadImage") {
                        $(this).css("border-color", "red")
                        esValido = false;
                    } else {
                        $(this).css("border-color", "#c4cdcf")
                    }

                });
            }
            if (step == 2) {
                if ($('#idiomasSeleccion :selected').length == 0) {
                    esValido = false;
                    $('#idiomasSeleccion').css("color", "red")
                } else {
                    $('#idiomasSeleccion').css("color", "#b5b5b5")
                }


            }
            if (step == 3) {
                $('#paso3').find("input").each(function() {
                    if ($(this).val() == "") {
                        $(this).css("border-color", "red")
                        esValido = false;
                    } else {
                        $(this).css("border-color", "#c4cdcf")
                    }

                });

            }
			if (step == 4) {
                 if ($(".subtemplate-wrapper").length ==0){
						esValido = false;
						alert("No puede dejar el Creador de Encuesta vacio!")
					}

            }
            if (step == 5) {
                $('#paso5').find("input").each(function() {
                    if ($(this).val() == "") {
                        $(this).css("border-color", "red")
                        esValido = false;
                    } else {
                        $(this).css("border-color", "#c4cdcf")
                    }

                });

            }
            return esValido;
        };

        function rellenarCampos() {

  //var myDate = new Date(2014,2,11)
  //var myDateInicio = new Date(encuesta.fechaInicio)
	 // var myDateFinal = new Date(encuesta.fechaFinal)
	var from = encuesta.fechaInicio.split("-");
	myDateInicio = new Date(from[2], from[1] - 1, from[0]);
	var to = encuesta.fechaFinal.split("-");
	myDateFinal = new Date(to[2], to[1] - 1, to[0]);

    $('#fechaInicio').datepicker({ dateFormat: 'dd/mm/yyyy' });
    $('#fechaInicio').datepicker('setDate', myDateInicio);
    $('#fechaFinal').datepicker({ dateFormat: 'dd/mm/yyyy' });
	$('#fechaFinal').datepicker('setDate', myDateFinal);

	idiomasSeleccionados=0;
console.log("ENTRARELLENOoo")
            //$('#fechaInicio').val(encuesta.fechaIni)
            //$('#fechaFin').val(encuesta.fechaFin)
            $('#clientes').val(encuesta.clienteNombre)
            $('#eventos').val(encuesta.eventoNombre)
            $('#objetivo').val(encuesta.objetivo)
                //eventoSeleccionado=encuesta.evento;
                //clienteSeleccionado=encuesta.clienteId;
            idEncuesta = encuesta.id

            //Completo paso 2
            $('#idiomasSeleccion option').each(function(i, selected) {
                var foo = [];
                texto = $(this).val();

                for (var idioma in encuesta.idiomas) {
                    console.log("TEXTO", texto, "Encuesta", encuesta.idiomas[idioma])
                    if (texto == encuesta.idiomas[idioma]) {
                        console.log("siTEXTO", texto, "Encuesta", encuesta.idiomas[idioma])
						idiomasSeleccionados++;
                        $('#idiomasSeleccion option[value=' + texto + ']').attr('selected', true);
                    }
                }

            });

            //Completo Paso 3

            for (var i in encuesta.textoInicial) {
                $("#textoInicio").append('<label>Texto Introduccion (' + encuesta.textoInicial[i]["idiomaNombre"] + ')</label><input name="textoIntroduccion" type="text" value=' + encuesta.textoInicial[i]["valor"] + '  placeholder="Texto" required idioma=' + encuesta.textoInicial[i]["idioma"] + ' class="noBorrar"/>')

            }


            //Completo paso 5
            for (var i in encuesta.textoFinal) {
                $("#textoFinal").append('<label>Texto Final (' + encuesta.textoFinal[i]["idiomaNombre"] + ')</label><input name="textoFinal" type="text" placeholder="Texto" required value=' + encuesta.textoFinal[i]["valor"] + ' idioma=' + encuesta.textoFinal[i]["idioma"] + ' class="noBorrarFinal"/ />')

            }


            //Completo paso 4
            test = new Object()
            var pruebas = [{
                "label": "Do you have a websiteaaa?",
                "field_type": "website",
                "required": false,
                "field_options": {},
                "language": "Jamaica",
                "cid": "c1"
            }, {
                "label": "Do you have a website?",
                "field_type": "website",
                "required": false,
                "field_options": {},
                "language": "Cha",
                "cid": "c1"
            }]
            var prueba = encuesta["form"]["fields"]

            console.log("pruebaaa", prueba)
            test["fields"] = encuesta["form"]["fields"]
                //formInfo=JSON.stringify(encuesta["form"]["fields"])
            formInfo = JSON.stringify(test)




            $(function() {
                // console.log("AHAHA",encuesta.json["fields"])
                fb = new Formbuilder({
                    selector: '.fb-main',
                    // bootstrapData: [encuesta.json["fields"]]
                    bootstrapData: prueba
                });

                fb.on('save', function(payload) {
                    console.log(payload);
                    formInfo = payload;
                })

            });




        }
    </script>

</body>

</html>