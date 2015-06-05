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
				   
});
