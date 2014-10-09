$( document ).ready(function(){

	var delete_selected_profiles = true;
	$("#delete-selected-profiles").click(function(e){
		e.preventDefault();
		if(delete_selected_profiles){
			delete_selected_profiles = false;
			var selected = [];
			$("input[type=checkbox][name=profiles]:checked").each(function(){
				selected.push($(this).val());
			});
			if(selected.length > 0){
				var confirmation = confirm("¿Está seguro que desea eliminar los registros seleccionados?");
				if(confirmation){
					if(selected.length > 0){
						$.ajax({
							url: inside_url+'user/delete_profile_ajax',
							type: 'POST',
							data: { 'selected_id' : selected },
							beforeSend: function(){
								$("#delete-selected-profiles").addClass("disabled");
								$("#delete-selected-profiles").hide();
								$(".loader_container").show();
							},
							complete: function(){
								$(".loader_container").hide();
								$("#delete-selected-profiles").removeClass("disabled");
								$("#delete-selected-profiles").show();
								delete_selected_profiles = true;
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
				}
			}else{
				delete_selected_profiles = true;
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