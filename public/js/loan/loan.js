$( document ).ready(function(){

	var return_register = true;
	$("#delete-selected-loans").click(function(e){
		e.preventDefault();
		if(return_register){
			return_register = false;
			var selected = [];
			$("input[type=checkbox][name=loans]:checked").each(function(){
				selected.push($(this).val());
			});
			if(selected.length > 0){
				var confirmation = confirm("¿Está seguro que desea registrar la devolución de los materiales seleccionados?");
				if(confirmation){
					$.ajax({
						url: inside_url+'loan/return_register_ajax',
						type: 'POST',
						data: { 'selected_id' : selected },
						beforeSend: function(){
							$("#delete-selected-loans").addClass("disabled");
							$("#delete-selected-loans").hide();
							$(".loader_container").show();
						},
						complete: function(){
							$(".loader_container").hide();
							$("#delete-selected-loans").removeClass("disabled");
							$("#delete-selected-loans").show();
							return_register = true;
						},
						success: function(response){
							if(response.success){
								location.reload();
							}else{
								alert('¡Ocurrió un error! Inténtelo de nuevo.');
							}
						},
						error: function(){
							alert('¡Ocurrió un error! Inténtelo de nuevo.');
						}
					});
				}
			}else{
				return_register = true;
				alert('Seleccione alguna casilla.');
			}
		}
	});

	$("input[type=submit]#submit-search-form").click(function(e){
		e.preventDefault();
		var search_criteria_length = $(this).siblings("input[type=text]").val().length;
		if(search_criteria_length > 0){
			$("form#search-form").submit();
		}else{
			$("div.search_bar").addClass("has-error");
		}
	});
});