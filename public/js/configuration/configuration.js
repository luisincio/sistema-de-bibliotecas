$( document ).ready(function(){

	var delete_selected_suppliers = true;
	$("#delete-selected-suppliers").click(function(e){
		e.preventDefault();
		if(delete_selected_suppliers){
			delete_selected_suppliers = false;
			var confirmation = confirm("¿Está seguro que desea eliminar los registros seleccionados?");
			var selected = [];
			if(confirmation){
				$("input[type=checkbox]:checked").each(function(){
					selected.push($(this).val());
				});
				if(selected.length > 0){
					$.ajax({
						url: inside_url+'config/delete_supplier_ajax',
						type: 'POST',
						data: { 'selected_id' : selected },
						beforeSend: function(){
							$("#delete-selected-suppliers").addClass("disabled");
							$(".loader_container").show();
						},
						complete: function(){
							$(".loader_container").hide();
							$("#delete-selected-suppliers").removeClass("disabled");
							delete_selected_suppliers = true;
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
		}
	});

	var delete_selected_material_types = true;
	$("#delete-selected-material-types").click(function(e){
		e.preventDefault();
		if(delete_selected_material_types){
			delete_selected_material_types = false;
			var confirmation = confirm("¿Está seguro que desea eliminar los registros seleccionados?");
			var selected = [];
			if(confirmation){
				$("input[type=checkbox]:checked").each(function(){
					selected.push($(this).val());
				});
				if(selected.length > 0){
					$.ajax({
						url: inside_url+'config/delete_material_type_ajax',
						type: 'POST',
						data: { 'selected_id' : selected },
						beforeSend: function(){
							$("#delete-selected-material-types").addClass("disabled");
							$(".loader_container").show();
						},
						complete: function(){
							$(".loader_container").hide();
							$("#delete-selected-material-types").removeClass("disabled");
							delete_selected_material_types = true;
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