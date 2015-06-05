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

    <title>Creacion Plantilla</title>

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
                        <h2 class="form-login-heading">Creacion Plantilla<span></span></h2>
                    </div>

                </div>
                <!--/ .row-->

                <div class="row stage-container">





                    <div class="stage  col-md-3 col-sm-3" id="stage1">
                        <div class="stage-header head-icon head-icon-user"></div>
                        <div class="stage-content">
                            <h3 class="stage-title">Seleccion Idiomas</h3>
                            <div class="stage-info">
                                Elija los idiomas deseados de la encuestas
                            </div>
                        </div>
                    </div>

                    <!--/ .stage-->





                    <div class="stage col-md-3 col-sm-3" id="stage2">
                        <div class="stage-header head-icon head-icon-details"></div>
                        <div class="stage-content">
                            <h3 class="stage-title">Generar Preguntas</h3>
                            <div class="stage-info">
                                Cree las preguntas se su encuesta
                            </div>
                        </div>
                    </div>
                    <!--/ .stage-->

                    <!--/ .stage-->
                    <div class="stage col-md-3 col-sm-3" id="stage3">
                        <div class="stage-header head-icon head-icon-details"></div>
                        <div class="stage-content">
                            <h3 class="stage-title">Confirma la Creacion</h3>
                            <div class="stage-info">
                                Guarda la Nueva Plantilla
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



                    <div class="form-wizard" id="paso1" style="display:block">

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
											<input type="text" id="nombrePlantilla" placeholder="Nombre Plantilla" required="" style="display: block;">
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
                    <div class="form-wizard" id="paso2" style="display:none">

                        <div class="row">

                            <div class="col-md-8 col-sm-7">

                                <div class="row">

                                    <div class="col-md-12 col-sm-12">
                                        <a href="#" id="verPreview" style="
    font-weight: bold;
    font-size: x-large;
">Ver Preview</a>
                                        <div class='fb-main'></div>
                                    </div>

                                </div>
                                <!--/ .row-->


                            </div>

                        </div>
                        <!--/ .row-->

                    </div>
                    <!--/ .form-wizard-->

                    <!--/ .form-wizard-->
                    <div class="form-wizard" id="paso3" style="display:none">

                        <div class="row">

                            <div class="col-md-8 col-sm-7">

                                <div class="row">

                                    <div class="col-md-12 col-sm-12">
                                        <fieldset class="input-block elementosGuardar">

                                            <button type="button" style="color: #146B98;font-size: x-large;" id="guardar">Guardar Plantilla</button>



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
                        <button class="button button-control" type="button" id="anterior"><span class="botonAnteriorTexto">Paso Anterior <b></b></span>
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
        var idPlantilla;

        $(document).ready(function() {


            var pasoNumero = 1;

            var cantidadElementos = 0;
            $(".prev").css("display", "none")
            $(".steps").append("Paso 1 de 3")
			getIdiomas();
			crearFormBuilder();

            $("#proximo").click(function() {
                if (validate(pasoNumero)) {
                    $("#paso" + pasoNumero).css("display", "none")
                    $("#stage" + pasoNumero).removeClass("tmm-current")
                    $("#stage" + pasoNumero).addClass("tmm-success")


                    if (pasoNumero == 1) {
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
                    console.log("ID", idiomas)
                    pasoNumero++;

                    if (pasoNumero == 3) {
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
                $(".steps").append("Paso " + pasoNumero + " de 3 ")
            });
            $("#anterior").click(function() {
                if (!$(".botonAnteriorTexto").hasClass("menu")) {
                    $("#paso" + pasoNumero).css("display", "none")
                    $("#stage" + pasoNumero).removeClass("tmm-current")
                    pasoNumero--;
                    $("#paso" + pasoNumero).css("display", "block")
                    $("#stage" + pasoNumero).addClass("tmm-current")
                    $("#stage" + pasoNumero).removeClass("tmm-success")
                    $(".steps").empty()
                    $(".steps").append("Paso " + pasoNumero + " de 3 ")
                    if (pasoNumero == 1) {
                        $(".prev").css("display", "none")
                    } else {
                        $(".prev").css("display", "block")
                    }
                    if (pasoNumero == 3) {
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


                    }
                });

            };
			function crearFormBuilder(){

			$(function() {
                // console.log("AHAHA",encuesta.json["fields"])
                fb = new Formbuilder({
                    selector: '.fb-main',
                    // bootstrapData: [encuesta.json["fields"]]
                    bootstrapData: []
                });

                fb.on('save', function(payload) {
                    console.log(payload);
                    formInfo = payload;
                })

            });

			}

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
                    $(".form-title").append("Idiomas")
                }

                if (pasoNumero == 2) {
                    $(".form-title").append("Creacion Encuesta")
                }

                if (pasoNumero == 3) {
                    $(".form-title").append("Confirmar")
                }

            }

            $("#guardar").click(function() {
                var datosForm = $("form").serializeArray();

                var objetoPlantilla = {}


                //Recuperar Info Idiomas ,Textos Iniciales y Finales
                objetoPlantilla.idiomas = searchArrays2(datosForm, "idiomas")
                objetoPlantilla.form = formInfo
				objetoPlantilla.nombrePlantilla=$("#nombrePlantilla").val()

                console.log("FORMDE", formInfo)

                $.ajax({
                    url: '/encuestarubra/RubraEncuesta7/clases/guardarPlantilla.php',
                    type: 'post',
                    data: {
                        "info": JSON.stringify(objetoPlantilla)
                    },
                    success: function(msg) {
                        //Acomodo Pantalla
                        $(".stage-container").remove()
                        $(".elementosGuardar").remove()
                        $(".steps").remove()
                        $("#proximo").remove();
                        $(".botonAnteriorTexto").text("Volver al Menu")
						$(".botonAnteriorTexto").addClass("menu")
                        $(".form-title").empty()
                        $(".form-title").append("<b>En hora buena!Plantilla generada!</b>")


                    }
                });
            });



        });



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
                if ($('#idiomasSeleccion :selected').length == 0) {
                    esValido = false;
                    $('#idiomasSeleccion').css("color", "red")
                } else {
                    $('#idiomasSeleccion').css("color", "#b5b5b5")
                }
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
	                 if ($(".subtemplate-wrapper").length ==0){
							esValido = false;
							alert("No puede dejar el Creador de Encuesta vacio!")
						}

	            }

            return esValido;
        };

        function rellenarCampos() {



            //Completo paso 1
            $('#idiomasSeleccion option').each(function(i, selected) {
                var foo = [];
                texto = $(this).val();

                for (var idioma in encuesta.idiomas) {
                    console.log("TEXTO", texto, "Encuesta", encuesta.idiomas[idioma])
                    if (texto == encuesta.idiomas[idioma]) {
                        console.log("siTEXTO", texto, "Encuesta", encuesta.idiomas[idioma])

                        $('#idiomasSeleccion option[value=' + texto + ']').attr('selected', true);
                    }
                }

            });
			$("#nombrePlantilla").val(encuesta.nombre)


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