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

	$("input[name=fecha_nacimiento]").datepicker({
		format:'yyyy-mm-dd',
		endDate: '+0d'
	});

	var num_documento = "";
	$("input[name=num_documento]").blur(function(){
		var input_length = $(this).val().length;
		var input_val = $(this).val();
		if((input_length > 0) && (num_documento !== input_val)){
			num_documento = input_val;
			$.ajax({
				url: inside_url+'user/validate_doc_number_ajax',
				type: 'POST',
				data: { 'document_number' : input_val },
				beforeSend: function(){
					$(".form-group img").show();
				},
				complete: function(){
					$(".form-group img").hide();
				},
				success: function(response){
					if(response.success){
						if(response.person.length > 0){
							$("input[name=nombres]").val(response.person[0].name);
							$("input[name=apellidos]").val(response.person[0].lastname);
							$("input[name=nacionalidad]").val(response.person[0].nacionality);
							$("input[name=telefono]").val(response.person[0].phone);
							$("input[name=email]").val(response.person[0].mail);
							$("input[name=direccion]").val(response.person[0].address);
							$("input[name=fecha_nacimiento]").val(response.person[0].birth_date);
							response.person[0].gender == "M" ? $("input[name=genero][value=M]").prop('checked',true) : $("input[name=genero][value=F]").prop('checked',true)
						}
					}
				},
				error: function(){
					alert('¡Ocurrió un error! No se pudo conectar con el servidor.');
				}
			});
		}
	});

	var delete_selected_users = true;
	$("#delete-selected-users").click(function(e){
		e.preventDefault();
		if(delete_selected_users){
			delete_selected_users = false;
			var selected = [];
			$("input[type=checkbox][name=users_data]:checked").each(function(){
				selected.push($(this).val());
			});
			if(selected.length > 0){
				var confirmation = confirm("¿Está seguro que desea eliminar los usuarios seleccionados? si tienen alguna reserva pendiente, ésta será cancelada");
				if(confirmation){
					if(selected.length > 0){
						$.ajax({
							url: inside_url+'user/delete_user_ajax',
							type: 'POST',
							data: { 'selected_id' : selected },
							beforeSend: function(){
								$("#delete-selected-users").addClass("disabled");
								$("#delete-selected-users").hide();
								$(".loader_container").show();
							},
							complete: function(){
								$(".loader_container").hide();
								$("#delete-selected-users").removeClass("disabled");
								$("#delete-selected-users").show();
								delete_selected_users = true;
							},
							success: function(response){
								if(response.success){
									if(response.users_with_loans.length > 0){
										var str_alert = "Existen usuarios con préstamos pendientes y no se pudieron eliminar, estos son los siguientes:\n";
										for(i=0;i<response.users_with_loans.length;i++){
											str_alert += "- "+response.users_with_loans[i] + "\n";
										}
										alert(str_alert);
									}
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
				delete_selected_users = true;
				alert('Seleccione alguna casilla.');
			}
		}
	});

	var reactivate_user = true;
	$(".reactivate-user").click(function(e){
		e.preventDefault();
		if(reactivate_user){
			reactivate_user = false;
			var user_id = $(this).data('id');
			$.ajax({
				url: inside_url+'user/reactivate_user_ajax',
				type: 'POST',
				data: { 'user_id' : user_id },
				beforeSend: function(){
					/*
					$("#delete-selected-users").addClass("disabled");
					$("#delete-selected-users").hide();
					$(".loader_container").show();
					*/
				},
				complete: function(){
					/*
					$(".loader_container").hide();
					$("#delete-selected-users").removeClass("disabled");
					$("#delete-selected-users").show();
					delete_selected_users = true;
					*/
					reactivate_user = true;
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
	});
});