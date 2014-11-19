$( document ).ready(function(){

	
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
							$("input[name=email]").val(response.person[0].email);
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


var delete_selected_staffs = true;
	$("#delete-selected-staffs").click(function(e){
		e.preventDefault();
		if(delete_selected_staffs){
			delete_selected_staffs = false;
			var selected = [];
			$("input[type=checkbox][name=staffs_data]:checked").each(function(){
				selected.push($(this).val());
			});
			if(selected.length > 0){
				var confirmation = confirm("¿Está seguro que desea eliminar los registros seleccionados?");
				if(confirmation){
					if(selected.length > 0){
						$.ajax({
							url: inside_url+'staff/delete_staff_ajax',
							type: 'POST',
							data: { 'selected_id' : selected },
							beforeSend: function(){
								$("#delete-selected-staffs").addClass("disabled");
								$("#delete-selected-staffs").hide();
								$(".loader_container").show();
							},
							complete: function(){
								$(".loader_container").hide();
								$("#delete-selected-staffs").removeClass("disabled");
								$("#delete-selected-staffs").show();
								delete_selected_staffs = true;
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
				delete_selected_staffs = true;
				alert('Seleccione alguna casilla.');
			}
		}
	});

	var reactivate_staff = true;
	$(".reactivate-staff").click(function(e){
		e.preventDefault();
		if(reactivate_staff){
			reactivate_staff = false;
			var staff_id = $(this).data('id');
			$.ajax({
				url: inside_url+'staff/reactivate_staff_ajax',
				type: 'POST',
				data: { 'staff_id' : staff_id },
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
					reactivate_staff = true;
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

	if(window.location.href.indexOf("create_staff") > -1) {
		$("select[name=turno]").prop('disabled', 'disabled');
	}

	$("select[name=sede]").change(function(){
		var branch_id = $(this).val();

		if(branch_id == 0){
			$("select[name=turno]").empty();
			var str = '<option value="0">Seleccione primero una sede</option>';
			$("select[name=turno]").append(str);
			$("select[name=turno]").prop('disabled', 'disabled');
		}else{
			$.ajax({
				url: inside_url+'staff/get_turns_by_branch_ajax',
				type: 'POST',
				data: { 'branch_id' : branch_id },
				beforeSend: function(){
					$("select[name=turno]").empty();
					var str = '<option value="0">Seleccione un turno</option>';
					$("select[name=turno]").append(str);
				},
				complete: function(){
				},
				success: function(response){
					if(response.success){
						console.log(response);
						var str_turns = "";
						for(i=0;i<response.turns.length;i++){
							str_turns += "<option value='"+response.turns[i].id+"'>"+response.turns[i].name+"("+response.turns[i].hour_ini+" - "+response.turns[i].hour_end+")</option>";
						}
						$("select[name=turno]").prop('disabled', false);
						$("select[name=turno]").append(str_turns);
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