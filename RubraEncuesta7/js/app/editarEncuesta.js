$(window).load(function(){
			/* PRIMERO DEBERIA CONSULTAR LA INFO DE LA ENCUESTA*/
			
			/* Cargo la INFO*/
			//Alex esta bien q te mande algo así?
			var encuesta = new Object();
			encuesta.json={"fields":[{"label":"Name","language":"(undefined)","field_type":"text","required":true,"field_options":{"size":"small","description":"Name"},"cid":"c2"}]};
			encuesta.cliente="Roche";
			encuesta.evento="Value";
			encuesta.eventoImg="logo.png"
			encuesta.fechaIni="12-04-2015";
			encuesta.fechaFin="12-05-2015";
			$.ajax({
				type: "POST",
				dataType: 'json',
				url: "xxx.php",
				data: elObjeto,
			}).done(function(respuesta){
				window.location.assign("http://belasoft.com.ar/encuestarubra/wizard/form-wizard-with-icon1.html")
			});
				   
});
