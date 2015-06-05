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
  					url: "clases/eliminarPlantilla.php",
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
			title: '¿Desea Eliminar la plantilla seleccionada?',
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
              <h2>Plantillas</h2>
            </div>
      </div>
      <div class="row" style="margin-top:80px; margin-bottom:90px">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="contenedor">
              <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1 sigIn"> 
					<div id="dialog-confirm"></div>
				  <a href="index.php" class="btn btn-primary" style="margin-bottom:10px; margin-right:10px;">Ir a Menu</a>
                  <table class="table table-condensed">
                  <thead>
                  <tr >
				  <th style="">Código</span></th>
                  <th style="">Objetivo (descripción)</span></th>
                  <th style="">Idiomas</th>
                  <th style="">Cantidad Preguntas</span></th>
                  <th style="">Estado</th>
                  <th style=""></th>
                  </tr>	
                  </thead>
                  <tbody>
					  <?php 
                      include("clases/getListadoPlantilla.php");
                      foreach ($lista as $item): ?>
                          <tr>
                              <td><?php echo $item["id"]; ?></td>
                              <td><?php echo $item["nombre"]; ?></td>
                              <td><?php echo $item["cantIdiomas"]; ?></td>
                              <td><?php echo $item["cantPreguntas"]; ?></td>
                              <td><?php if ( $item["estado"] == 'A') { echo "Activa"; } else { echo "Inactiva"; }  ?></td>
                              <td>
                                <span class="glyphicon glyphicon-pencil" style="color:#265a88"></span> <a href="editarPlantilla.php?id=<?php echo $item["id"]; ?>" style="color:#265a88"> Editar</a> <span class="glyphicon glyphicon-remove" style="color:red"></span>
                                <span class="delete" style="color:red" value="<?php echo $item["id"]; ?>">Borrar</span>
                                <span class="<?php if ( $item["estado"] == 'A') { echo "Activar"; } else { echo "desactivar"; }  ?>" style="color:blue" value="<?php echo "1" ?>">
                                <?php if ( $item["estado"] == 'A') { echo "Desactivar"; } else { echo "Activar"; }  ?>
                                </span>
                              </td>				
                          </tr>                                
    
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
