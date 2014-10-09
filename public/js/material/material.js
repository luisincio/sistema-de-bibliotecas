$( document ).ready(function(){

	var delete_selected_materials = true;
	$("#delete-selected-materials").click(function(e){
		e.preventDefault();
		if(delete_selected_materials){
			delete_selected_materials = false;
			var selected = [];
			$("input[type=checkbox][name=material]:checked").each(function(){
				selected.push($(this).val());
			});
			if(selected.length > 0){
				var confirmation = confirm("¿Está seguro que desea eliminar los registros seleccionados?");
				if(confirmation){
					$.ajax({
						url: inside_url+'material/delete_material_ajax',
						type: 'POST',
						data: { 'selected_id' : selected },
						beforeSend: function(){
							$("#delete-selected-materials").addClass("disabled");
							$("#delete-selected-materials").hide();
							$(".loader_container").show();
						},
						complete: function(){
							$(".loader_container").hide();
							$("#delete-selected-materials").removeClass("disabled");
							$("#delete-selected-materials").show();
							delete_selected_materials = true;
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
				delete_selected_materials = true;
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