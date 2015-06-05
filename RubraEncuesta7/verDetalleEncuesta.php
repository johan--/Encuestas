<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> </title>
  <link rel="stylesheet" href="/css/bootstrap.css">
  <link rel="stylesheet" href="/css/bootstrap-theme.css">
  <link rel="stylesheet" href="/css/style2.css">
  <link rel="stylesheet" href="/css/style.css">
  <script src="js/jquery.min.js"></script>
  <script src="js/jquery.ui.shake.js"></script>



  <!--<script src="js/login.js"></script> -->
  <link href="../css/bootstrapValidator.css" rel="stylesheet" type='text/css'> 
  <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <link rel="stylesheet" href="css/style.css"/> -->
  <link rel="shortcut icon" href="http://www.webinfopedia.com/images/webinfopedia-fav.png"  />


  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
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
  					url: "eliminarEncuesta.php",
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
						   
		});//]]>  
		

  </script>
</head>
<body>

  <div class="row content info-util">
    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1" style="background-color: white;">
      <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <h2>Listado de Encuestas</h2>
            </div>
      </div>
      <div class="row" style="margin-top:80px; margin-bottom:90px">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="contenedor">
              <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1 sigIn"> 
					<div id="dialog-confirm"></div>
				  <a href="verEncuesta.php" class="btn btn-primary" style="margin-bottom:10px; margin-right:10px;">Volver</a>
                  <table class="table table-condensed">
                  <thead>
                  <tr >
                  <th style="">Mail</span></th>
                  <th style="">Fecha Respuesta</span></th>
                  <th style="">Cantidad Respuestas</th>
                  <th style="">% Respuestas</th>
                  <th style=""></th>
                  </tr>	
                  </thead>
                  <tbody>
                  <?php 
                  //include("getEncuesta.php");
                  //foreach ($encuestas as $encuesta): ?>
                  <tr>
                  <td>kaloye_ale@hotmail.com</td>
                  <td>26.02.2014</td>
                  <td>8</td>
                  <td>76%</td>
                  <td>
                    <span class="delete" style="color:red" value="<?php echo "1" ?>">Borrar</span>
                  </td>
                  </tr>                                

                  <?php //endforeach; ?>

                  </tbody>
                  </table>

              </div>
          </div>
      </div>
    </div>
  </div>


</body>
</html>
