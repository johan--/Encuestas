<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Listado de Encuestas </title>
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/bootstrap-theme.css">
  <link rel="stylesheet" href="css/style2.css">
  <link rel="stylesheet" href="css/style.css">
  <script src="js/jquery.min.js"></script>
  <script src="js/jquery.ui.shake.js"></script>



  <!--<script src="js/login.js"></script> -->
  <link href="css/bootstrapValidator.css" rel="stylesheet" type='text/css'> 
  <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <link rel="stylesheet" href="css/style.css"/> -->
  <link rel="shortcut icon" href="http://www.webinfopedia.com/images/webinfopedia-fav.png"  />


  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
  <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>  
  
  
  <script language="javascript">
		//<![CDATA[ 
		$(window).load(function(){
		function yesnodialog(button1, button2, element){
		  var btns = {};
		  btns[button1] = function(){ 

			  $(this).dialog("close");
					//oculta la fila
				  element.parents('tr').hide();
				//Aviso que id deseo borrar  
				var elObjeto = new Object();
				elObjeto.id=element.attr( "value" );

				$.ajax({
					type: "POST",
					dataType: 'json',
  					url: "clases/eliminarEncuesta.php",
  					data: elObjeto,
				}).done(function(respuesta){
				});
		  };
		  btns[button2] = function(){ 
			  // Do nothing
			  $(this).dialog("close");
		  };
		  $("<div></div>").dialog({
			autoOpen: true,
			title: '¿Desea Eliminar la encuesta seleccionada?',
			modal:true,
			buttons:btns
		  });
		}
		$('.delete').click(function(){
			yesnodialog('SI', 'No', $(this));
		})

//activa
		function activaDialog(button1, button2, element){
		  var btns = {};
		  btns[button1] = function(){ 
			alert("alla");
			  $(this).dialog("close");
					//oculta la fila
				 //element.parents('tr').hide();
				//Aviso que id deseo borrar  
				var elObjeto = new Object();
				elObjeto.id=element.attr( "value" );

				$.ajax({
					type: "POST",
					dataType: 'json',
  					url: "clases/activaEncuesta.php",
  					data: elObjeto,
				}).done(function(respuesta){
				});
		  };
		  btns[button2] = function(){ 
			  // Do nothing
			  $(this).dialog("close");
		  };
		  $("<div></div>").dialog({
			autoOpen: true,
			title: '¿Desea activar la encuesta seleccionada?',
			modal:true,
			buttons:btns
		  });
		}
		$('.activar').click(function(){
			activaDialog('SI', 'No', $(this));
		})

//desactiva
		function desactivaDialog(button1, button2, element){
		  var btns = {};
		  btns[button1] = function(){ 
			alert("aca");
			  $(this).dialog("close");
					//oculta la fila
//				  element.parents('tr').hide();
				//Aviso que id deseo borrar  
				var elObjeto = new Object();
				elObjeto.id=element.attr( "value" );
				element.removeAttr( "class");
				element.attr( "class" , "activar");

				$.ajax({
					type: "POST",
					dataType: 'json',
  					url: "clases/desactivaEncuesta.php",
  					data: elObjeto,
				}).done(function(respuesta){
				});
		  };
		  btns[button2] = function(){ 
			  // Do nothing
			  $(this).dialog("close");
		  };
		  $("<div></div>").dialog({
			autoOpen: true,
			title: '¿Desea Desactivar la encuesta seleccionada?',
			modal:true,
			buttons:btns
		  });
		}
		$('.desactivar').click(function(){
			desactivaDialog('SI', 'No', $(this));
		})

						   
		});//]]>  
		

  </script>
</head>
<body>

  <div class="row content info-util">
    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1" style="background-color: white;">
      <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <h2 style="  margin-top: 50px;">Listado de Encuestas</h2>
            </div>
      </div>
      <div class="row" style="margin-top:50px; margin-bottom:90px; ">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="contenedor">
              <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1 sigIn" style="background-color: #C7D2D2; border-radius:20px;"> 
					<div id="dialog-confirm"></div>
                  <a href="http://belasoft.com.ar/encuestarubra/wizard/form-wizard-with-icon1.html" class="btn btn-primary" style="margin-bottom:10px;  margin-top: 25px;">Nueva Encuesta</a>
				  <a href="index.php" class="btn btn-primary" style="margin-bottom:10px; margin-right:10px;  margin-top: 25px;">Ir a Menu</a>
                  <table class="table table-condensed">
                  <thead>
                  <tr >
                  <th style="">Código</span></th>
                  <th style="">Cliente</span></th>
                  <th style="">Evento</th>
                  <th style="">Apertura</span></th>
                  <th style="">Cierre</span></th>
                  <th style="">Estado</span></th>
                  <th style="">Idiomas</span></th>
                  <th style="">Total Encuestados</span></th>
                  <th style=""></th>
                  </tr>	
                  </thead>
                  <tbody>
                  <?php 
                  include("clases/getListadoEncuesta.php");
				  $colorLinea="#F9EFEF;";
				  $ultimoId=0;
				  
                  foreach ($lista as $item): ?>
						<?php if ($item["id"] == $ultimoId) { ?>
							<tr style="background-color:<?php echo $colorLinea; ?>">
	                            <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>  	
                      			<td><a href="<?php echo $item["encuestaLink"]; ?>" style="color:rgb(51, 122, 183)"> <?php echo $item["idiomaNombre"]; ?></a></td>  	
                                <td></td>
                                <td></td>
                            </tr>    
						<?php } else { 
								$ultimoId = $item["id"] ;
								if ($colorLinea=="#F9EFEF;"){
									$colorLinea="#F3F4EF;";	
								} else {
									$colorLinea="#F9EFEF;";
								}
						
						?>
                          <tr style="background-color:<?php echo $colorLinea; ?>">
                              <td><?php echo $item["id"]; ?></td>
                              <td><?php echo $item["razonSocial"]; ?></td>
                              <td><?php echo $item["eventoNombre"]; ?></td>
                              <td><?php echo $item["fechaInicio"]; ?></td>
                              <td><?php echo $item["fechaFin"]; ?></td>
                              <td><?php if ( $item["estado"] == 'A') { echo "Activa"; } else { echo "Inactiva"; }  ?></td>
                              <td><a href="<?php echo $item["encuestaLink"]; ?>" style="color:rgb(51, 122, 183)"> <?php echo $item["idiomaNombre"]; ?></a></td>
                              <td><?php echo $item["totaEncuestados"]; ?></td>
                              <td>
                                <span class="glyphicon glyphicon-pencil" style="color:#265a88"></span> <a href="consultaDatosEncuesta.php?id=<?php echo $item["id"]; ?>" style="color:#265a88"> Editar</a> <span class="glyphicon glyphicon-remove" style="color:red"></span>
                                <span class="delete" style="color:red" value="<?php echo $item["id"]; ?>">Borrar</span>
                                <span id"activEstado<?php echo $item["id"]; ?>" onClick="<?php if ( $item["estado"] == 'A') { echo "desactivar();"; } else { echo "activar();"; }  ?>" style="color:blue" value="<?php echo $item["id"]; ?>">
                                <?php if ( $item["estado"] == 'A') { echo "Desactivar"; } else { echo "Activar"; }  ?>
                                
                                </span>
                                <span class="glyphicon glyphicon-plus" style="color:#00F"></span> <a href="verPlantillas.php?id=<?php '1' ?>" style="color:#265a88"> Reporte</a>
                              </td>				
                          </tr>                                
						<?php }?>
                  <?php endforeach; ?>

                  </tbody>
                  </table>

              </div>
          </div>
      </div>
    </div>
  </div>


</body>
</html>
