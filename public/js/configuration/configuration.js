$( document ).ready(function(){

	var delete_selected_suppliers = true;
	$("#delete-selected-suppliers").click(function(e){
		e.preventDefault();
		if(delete_selected_suppliers){
			delete_selected_suppliers = false;
			var selected = [];
			$("input[type=checkbox][name=suppliers]:checked").each(function(){
				selected.push($(this).val());
			});
			if(selected.length > 0){
				var confirmation = confirm("¿Está seguro que desea eliminar los registros seleccionados?");
				if(confirmation){
					$.ajax({
						url: inside_url+'config/delete_supplier_ajax',
						type: 'POST',
						data: { 'selected_id' : selected },
						beforeSend: function(){
							$("#delete-selected-suppliers").addClass("disabled");
							$("#delete-selected-suppliers").hide();
							$(".loader_container").show();
						},
						complete: function(){
							$(".loader_container").hide();
							$("#delete-selected-suppliers").removeClass("disabled");
							$("#delete-selected-suppliers").show();
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
			}else{
				delete_selected_suppliers = true;
				alert('Seleccione alguna casilla.');
			}
		}
	});

	var delete_selected_material_types = true;
	$("#delete-selected-material-types").click(function(e){
		e.preventDefault();
		if(delete_selected_material_types){
			delete_selected_material_types = false;
			var selected = [];
			$("input[type=checkbox][name=material_types]:checked").each(function(){
				selected.push($(this).val());
			});
			if(selected.length > 0){
				var confirmation = confirm("¿Está seguro que desea eliminar los registros seleccionados?");
				if(confirmation){
						$.ajax({
							url: inside_url+'config/delete_material_type_ajax',
							type: 'POST',
							data: { 'selected_id' : selected },
							beforeSend: function(){
								$("#delete-selected-material-types").addClass("disabled");
								$("#delete-selected-material-types").hide();
								$(".loader_container").show();
							},
							complete: function(){
								$(".loader_container").hide();
								$("#delete-selected-material-types").removeClass("disabled");
								$("#delete-selected-material-types").show();
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
			}else{
				delete_selected_material_types = true;
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

	var restore_selected_branches = true;
	$("#restore-selected-branches").click(function(e){
		e.preventDefault();
		
		if(restore_selected_branches){
			restore_selected_branches = false;
			var branch_id = $(this).data('id');
			var confirmation = confirm("¿Está seguro que desea restaurar la sede seleccionada?");
			if(confirmation){
				$.ajax({
					url: inside_url+'config/restore_branch_ajax',
					type: 'POST',
					data: { 'branch_id' : branch_id },
					beforeSend: function(){
						$("#restore-selected-branches").addClass("disabled");
					},
					complete: function(){
						$("#restore-selected-branches").removeClass("disabled");
						restore_selected_branches = true;
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
		
	});

	var delete_selected_branches = true;
	$("#delete-selected-branches").click(function(e){
		e.preventDefault();
		
		if(delete_selected_branches){
			delete_selected_branches = false;
			var selected = [];
			$("input[type=checkbox][name=branches]:checked").each(function(){
				selected.push($(this).val());
			});
			if(selected.length > 0){
				var confirmation = confirm("¿Está seguro que desea eliminar los registros seleccionados?");
				if(confirmation){
					$.ajax({
						url: inside_url+'config/delete_branch_ajax',
						type: 'POST',
						data: { 'selected_id' : selected },
						beforeSend: function(){
							$("#delete-selected-branches").addClass("disabled");
							$("#delete-selected-branches").hide();
							$(".loader_container").show();
						},
						complete: function(){
							$(".loader_container").hide();
							$("#delete-selected-branches").removeClass("disabled");
							$("#delete-selected-branches").show();
							delete_selected_branches = true;
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
				delete_selected_branches = true;
				alert('Seleccione alguna casilla.');
			}
		}
		
	});

	var delete_selected_turns = true;
	$("#delete-selected-turns").click(function(e){
		e.preventDefault();
		
		if(delete_selected_turns){
			delete_selected_turns = false;
			var selected = [];
			$("input[type=checkbox][name=turns]:checked").each(function(){
				selected.push($(this).val());
			});
			if(selected.length > 0){
				var confirmation = confirm("¿Está seguro que desea eliminar los registros seleccionados?");
				if(confirmation){
					$.ajax({
						url: inside_url+'config/delete_turn_ajax',
						type: 'POST',
						data: { 'selected_id' : selected },
						beforeSend: function(){
							$("#delete-selected-turns").addClass("disabled");
							$("#delete-selected-turns").hide();
							$(".loader_container").show();
						},
						complete: function(){
							$(".loader_container").hide();
							$("#delete-selected-turns").removeClass("disabled");
							$("#delete-selected-turns").show();
							delete_selected_turns = true;
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
				delete_selected_turns = true;
				alert('Seleccione alguna casilla.');
			}
		}
		
	});

	$("input[name=hora_ini]").timepicker({
		showMeridian: false,
	});


	$("input[name=hora_fin]").timepicker({
		showMeridian: false,
	});
});