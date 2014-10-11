$( document ).ready(function(){

	$("#clear-fields").click(function(e){
		e.preventDefault();
		$("input[type=text]").val('');
		$("input[type=checkbox]").prop('checked',false);
	});

	$("#cancel").click(function(e){
		e.preventDefault();
		var can_return = true;
		$("input[type=text]").each(function(){
			var input_length = $(this).val().length;
			if(input_length > 0){
				can_return = false;
				return false;
			}
		});
		if(can_return){
			history.go(-1);
		}else{
			var confirmation = confirm("¿Está seguro que desea salir de esta pantalla?\nTiene algunos campos llenos que no han sido guardados.");
			if(confirmation){
				if(history.length > 0){
					history.go(-1);
				}else{
					alert("No hay a dónde regresar.");
				}
			}
		}
	});

	$("input[name=select_all]").click(function(){
		if($(this).prop('checked')){
			$("input[type=checkbox]").prop('checked',true);
		}else{
			$("input[type=checkbox]").prop('checked',false);
		}
	});

});