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
					var user_id = $("input[name=user_id]").val();
					$.ajax({
						url: inside_url+'loan/return_register_ajax',
						type: 'POST',
						data: { 'selected_id' : selected ,'user_id' : user_id},
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
								alert('La petición no se pudo completar, inténtelo de nuevo.');
							}
						},
						error: function(){
							alert('La petición no se pudo completar, inténtelo de nuevo.');
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


	var nr_num_doc_usuario = "";
	$("input[name=nr_num_doc_usuario]").blur(function(){
		var input_length = $(this).val().length;
		var input_val = $(this).val();
		if((input_length > 0) && (nr_num_doc_usuario !== input_val)){
			nr_num_doc_usuario = input_val;
			$.ajax({
				url: inside_url+'loan/validate_doc_number_loans_ajax',
				type: 'POST',
				data: { 'document_number' : input_val },
				beforeSend: function(){
					$("input[name=nr_id_usuario]").val("0");
					$(".form-group-num-doc img").show();
				},
				complete: function(){
					$(".form-group-num-doc img").hide();
				},
				success: function(response){
					if(response.success){
						if(response.user.length > 0){
							$("input[name=nr_id_usuario]").val(response.user[0].id);
							$("input[name=nr_nombre_usuario]").val((response.user[0].name+" "+response.user[0].lastname));
							$("input[name=nr_perfil_usuario]").val(response.user[0].profile_name);
							$("input[name=nr_email_usuario]").val(response.user[0].email);
							if(response.user[0].restricted_until){
								$("input[name=nr_id_usuario]").val("0");
								$("input[name=nr_estado_usuario]").val("Penalizado hasta "+response.user[0].restricted_until);
							}else{
								$("input[name=nr_estado_usuario]").val("Activo");
							}
						}else{
							alert('No se ha encontrado un usuario con el número de documento solicitado.');
						}
					}
				},
				error: function(){
					alert('La petición no se pudo completar, inténtelo de nuevo.');
				}
			});
		}
	});

	var nr_codigo_libro = "";
	$("input[name=nr_codigo_libro]").blur(function(){
		var input_length = $(this).val().length;
		var input_val = $(this).val();
		if((input_length > 0) && (nr_codigo_libro !== input_val)){
			nr_codigo_libro = input_val;
			$.ajax({
				url: inside_url+'loan/validate_material_code_ajax',
				type: 'POST',
				data: { 'material_code' : input_val },
				beforeSend: function(){
					$("input[name=nr_id_libro]").val("0");
					$(".form-group-material-code img").show();
				},
				complete: function(){
					$(".form-group-material-code img").hide();
				},
				success: function(response){
					if(response.success){
						if(response.material.length > 0){
							$("input[name=nr_base_cod_libro]").val(response.material[0].base_cod);
							$("input[name=nr_titulo_libro]").val(response.material[0].title);
							$("input[name=nr_autor_libro]").val(response.material[0].author);							
						}else{
							alert('No se ha encontrado un material con el código solicitado en esta sede.');
						}
					}
				},
				error: function(){
					alert('La petición no se pudo completar, inténtelo de nuevo.');
				}
			});
		}
	});

	var nr_submit_loan_register = true;
	$("#nr-submit-loan-register").click(function(e){
		e.preventDefault();
		if(nr_submit_loan_register){
			nr_submit_loan_register = false;
			var id_usuario = $("input[name=nr_id_usuario]").val();
			var base_cod_libro = $("input[name=nr_base_cod_libro]").val();
			if( (id_usuario != "0") && (base_cod_libro != "0")){
				$.ajax({
					url: inside_url+'loan/register_loan_ajax',
					type: 'POST',
					data: { 'user_id' : id_usuario, 'base_cod_libro' : base_cod_libro, 'branch_id' : current_staff_branch_id },
					beforeSend: function(){
					},
					complete: function(){
						nr_submit_loan_register = true;
					},
					success: function(response){
						if(response.success){
							if(response.problem){
								switch(response.problem){
									case 'no_available': alert('No hay ejemplares disponibles con este título en esta sede.');
														 break;
									case 'max_reservations': alert('El usuario ha alcanzado el límite de sus reservas.');
														 	 break;
									case 'has_loans': alert('El usuario tiene un préstamo vigente con este título.');
													  break;
									case 'has_reservations': alert('El usuario tiene una reserva vigente con este título.');
														 	 break;
								}
							}else{
								alert('Se registró correctamente el préstamo.');
								location.reload();
							}
						}
					},
					error: function(){
						alert('La petición no se pudo completar, inténtelo de nuevo.');
					}
				});
			}else{
				alert('No se puede realizar la reserva, verifique que el usuario no esté penalizado.');
				nr_submit_loan_register = true;
			}
		}
	});

	var search_user_loans = true;
	$("#search-user-loans").click(function(e){
		e.preventDefault();
		if(search_user_loans){
			search_user_loans = false;
			var document_number = $("input[name=r_num_doc_usuario]").val();
			var regexNum = /^\s*\d+\s*$/;
			if( (document_number.length > 0) && (regexNum.test(document_number)) ){
				$.ajax({
					url: inside_url+'loan/get_user_reservation_ajax',
					type: 'POST',
					data: { 'document_number' : document_number },
					beforeSend: function(){
						$("table#user-active-loans").empty();
					},
					complete: function(){
						search_user_loans = true;
					},
					success: function(response){
						if(response.success){
							if(response.problem){
								switch(response.problem){
									case 'user_no_exist': 	alert('No se encontró un usuario con dicho número de documento.');
															break;
								}
							}else{
								render_user_reservations_table(response.material_reservations);
							}
						}
					},
					error: function(){
						alert('La petición no se pudo completar, inténtelo de nuevo.');
					}
				});
			}else{
				search_user_loans = true;
				$(".form-group-r-num-doc").addClass('has-error');
			}
		}
	});


	var damage_register = true;
	$("#delete-damage-loans").click(function(e){
		e.preventDefault();
		if(damage_register){
			damage_register = false;
			var selected = [];
			$("input[type=checkbox][name=loans]:checked").each(function(){
				selected.push($(this).val());
			});
			if(selected.length > 0){
				var confirmation = confirm("¿Está seguro que desea registrar el daño o pérdida de los materiales seleccionados?");
				if(confirmation){
					var user_id = $("input[name=user_id]").val();
					$.ajax({
						url: inside_url+'loan/damage_register_ajax',
						type: 'POST',
						data: { 'selected_id' : selected ,'user_id' : user_id},
						beforeSend: function(){
							$("#delete-damage-loans").addClass("disabled");
							$("#delete-damage-loans").hide();
							$(".loader_container").show();
						},
						complete: function(){
							$(".loader_container").hide();
							$("#delete-damage-loans").removeClass("disabled");
							$("#delete-damage-loans").show();
							damage_register = true;
						},
						success: function(response){
							if(response.success){
								location.reload();
							}else{
								alert('La petición no se pudo completar, inténtelo de nuevo.');
							}
						},
						error: function(){
							alert('La petición no se pudo completar, inténtelo de nuevo.');
						}
					});
				}else{
					damage_register = true;
				}
			}else{
				damage_register = true;
				alert('Seleccione alguna casilla.');
			}
		}
	});

	var renew_button = true;
	$(".renew-button").click(function(e){
		e.preventDefault();
		if(renew_button){
			renew_button = false;
			var confirmation = confirm("¿Está seguro que desea renovar el préstamo?");
			if(confirmation){
				var loan_id = $(this).data('loan');
				var material_id = $(this).data('material');
				var user_id = $(this).data('user');
				console.log(loan_id);
				console.log(material_id);
				console.log(user_id);
				$.ajax({
					url: inside_url+'loan/renew_ajax',
					type: 'POST',
					data: { 'loan_id' : loan_id ,'material_id' : material_id, 'user_id' : user_id},
					beforeSend: function(){
						$(this).addClass("disabled");
					},
					complete: function(){
						$(this).removeClass("disabled");
						renew_button = true;
					},
					success: function(response){
						console.log(response);
						if(response.success){
							if(response.error){
								switch(response.error){
									case 'is_reserved': 	alert('Ya existe una reserva pendiente sobre este ejemplar.');
															break;
									case 'not_home': 	alert('Este material es sólo para casa, no se puede renovar préstamo.');
															break;
								}
							}
							location.reload();
						}else{
							alert('La petición no se pudo completar, inténtelo de nuevo.');
						}
					},
					error: function(){
						alert('La petición no se pudo completar, inténtelo de nuevo.');
					}
				});
			}else{
				renew_button = true;
			}
		}
	});

});

function render_user_reservations_table(reservations)
{
	var str_table = "<tr class='info'><th>Código</th><th>Título</th><th>Autor</th><th>Seleccione</th></tr>";
	for(i=0;i<reservations.length;i++){
		str_table += "<tr><th>"+reservations[i].auto_cod+"</th><th>"+reservations[i].title+"</th><th>"+reservations[i].author+"</th><th><a href='' class='btn btn-success' onclick='loan_register(event,"+reservations[i].id+")'>Prestar</a></th></tr>";
	}
	$("table#user-active-loans").append(str_table);
}

function loan_register(e,reservation_id)
{
	e.preventDefault();
	console.log(reservation_id);
	$.ajax({
		url: inside_url+'loan/register_loan_with_reservation_ajax',
		type: 'POST',
		data: { 'reservation_id' : reservation_id },
		beforeSend: function(){
		},
		complete: function(){
		},
		success: function(response){
			if(response.success){
				alert('Se registró correctamente el préstamo.');
				$("input#search-user-loans").trigger("click");
			}else{
				alert('La petición no se pudo completar, inténtelo de nuevo.');
			}
		},
		error: function(){
			alert('La petición no se pudo completar, inténtelo de nuevo.');
		}
	});
}