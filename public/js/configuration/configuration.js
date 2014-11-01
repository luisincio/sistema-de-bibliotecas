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
				var confirmation = confirm("Las sedes que contengan materiales o usuarios activos no serán inhabilitadas.\n¿Desea continuar?");
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

	$("input[name=fecha_ini]").datepicker({
		format:'yyyy-mm-dd'
	});

	$("input[name=fecha_fin]").datepicker({
		format:'yyyy-mm-dd'
	}); 

	var delete_selected_devolution_periods = true;
	$("#delete-selected-devolution_periods").click(function(e){
		e.preventDefault();
  
		if(delete_selected_devolution_periods){
			delete_selected_devolution_periods = false;
			var selected = [];
			$("input[type=checkbox][name=devolution_periods]:checked").each(function(){
				selected.push($(this).val());
			});
			if(selected.length > 0){
				var confirmation = confirm("¿Está seguro que desea eliminar los registros seleccionados?");
				if(confirmation){
					$.ajax({
						url: inside_url+'config/delete_devolution_period_ajax',
						type: 'POST',
						data: { 'selected_id' : selected },
						beforeSend: function(){
							$("#delete-selected-devolution_periods").addClass("disabled");
							$("#delete-selected-devolution_periods").hide();
							$(".loader_container").show();
						},
						complete: function(){
							$(".loader_container").hide();
							$("#delete-selected-devolution_periods").removeClass("disabled");
							$("#delete-selected-devolution_periods").show();
							delete_selected_devolution_periods = true;
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
				delete_selected_devolution_periods = true;
				alert('Seleccione alguna casilla.');
			}
		}
	});

	/* Physical Elements */
	var submit_search_physical_elements_form = true;
	$("#submit-search-physical-elements-form").click(function(e){
		e.preventDefault();
		if(submit_search_physical_elements_form){
			submit_search_physical_elements_form = false;
			var branch_id = $("select[name=branch_filter]").val();
			if(branch_id > 0){
				$.ajax({
					url: inside_url+'config/get_physical_elements_by_branch',
					type: 'POST',
					data: { 'branch_id' : branch_id },
					beforeSend: function(){
						$("#cubicle-table").empty();
						$("#shelves-table").empty();
						$("#physical-elements-table").empty();
						$(".big-loader-container").show();

						$("#submit-search-physical-elements-form").addClass("disabled");
					},
					complete: function(){
						$("#submit-search-physical-elements-form").removeClass("disabled");
						$(".big-loader-container").hide();
						submit_search_physical_elements_form = true;
					},
					success: function(response){
						if(response.success){
							render_physical_elements(response.branch_cubicles,response.cubicle_types,response.branch_physical_elements,response.branch_shelves);
						}else{
							alert('¡Ocurrió un error! Inténtelo de nuevo.');
						}
					},
					error: function(){
						alert('¡Ocurrió un error! Inténtelo de nuevo.');
					}
				});
			}else{
				submit_search_physical_elements_form = true;
				alert("Seleccione una sede.");
			}
		}
	});

	$("#submit-edit-physical-element").click(function(e){
		e.preventDefault();
		var id_elemento_fisico = $("input[name=id_elemento_fisico]").val();
		var nombre_elemento_fisico = $("input[name=nombre_elemento_fisico]").val();
		var cantidad_elemento_fisico = $("input[name=cantidad_elemento_fisico]").val();
		var id_sede = $("select[name=branch_filter]").val();

		if(id_sede > 0){
			if(nombre_elemento_fisico.length < 1 || cantidad_elemento_fisico.length < 1){
				return alert('No deje campos vacíos.');
			}
			if(nombre_elemento_fisico.length > 128){
				return alert('El nombre no debe tener más de 128 caracteres.');
			}
			var regexNum = /^\s*\d+\s*$/;
			if(!regexNum.test(cantidad_elemento_fisico)){
				return alert('La cantidad debe ser numérico.');
			}
			if(cantidad_elemento_fisico < 0){
				return alert('La cantidad debe ser positiva.');
			}

			$.ajax({
				url: inside_url+'config/submit_edit_physical_elements',
				type: 'POST',
				data: { 'id' : id_elemento_fisico, 'name' : nombre_elemento_fisico, 'quantity' : cantidad_elemento_fisico, 'branch_id' : id_sede },
				beforeSend: function(){
					$("#submit-edit-physical-element").addClass("disabled");
					$("#submit-edit-physical-element").hide();
					$(".edit_physical_element_loader_container").show();

				},
				complete: function(){
					$("#submit-edit-physical-element").removeClass("disabled");
					$("#submit-edit-physical-element").show();
					$(".edit_physical_element_loader_container").hide();
				},
				success: function(response){
					if(response.success){
						if(response.problem){
							switch(response.problem){
								case 'name_exists': alert('Existe otro elemento físico con el mismo nombre.');
													break;
							}
						}else{
							alert('Se modificó correctamente el elemento físico.');
							$("#submit-search-physical-elements-form").trigger('click');
							$("#edit-physical-element").modal("hide");
						}
					}else{
						alert('¡Ocurrió un error! Inténtelo de nuevo.');
					}
				},
				error: function(){
					alert('¡Ocurrió un error! Inténtelo de nuevo.');
				}
			});
		}else{
			alert('Seleccione una sede.');
		}
	});

	$("#submit-edit-shelf").click(function(e){
		e.preventDefault();
		var id_estante = $("input[name=id_estante]").val();
		var codigo_estante = $("input[name=codigo_estante]").val();
		var descripcion_estante = $("textarea[name=descripcion_estante]").val();
		
		if(codigo_estante.length < 1 || descripcion_estante.length < 1){
			return alert('No deje campos vacíos.');
		}
		if(codigo_estante.length > 45){
			return alert('El código no debe tener más de 45 caracteres.');
		}
		if(descripcion_estante > 255){
			return alert('La descripción no debe tener más de 255 caracteres.');
		}

		$.ajax({
			url: inside_url+'config/submit_edit_shelves',
			type: 'POST',
			data: { 'id' : id_estante, 'code' : codigo_estante, 'description' : descripcion_estante },
			beforeSend: function(){
				$("#submit-edit-shelf").addClass("disabled");
				$("#submit-edit-shelf").hide();
				$(".edit_shelf_loader_container").show();

			},
			complete: function(){
				$("#submit-edit-shelf").removeClass("disabled");
				$("#submit-edit-shelf").show();
				$(".edit_shelf_loader_container").hide();
			},
			success: function(response){
				if(response.success){
					if(response.problem){
						switch(response.problem){
							case 'code_exists': alert('Existe otro estante con el mismo código.');
												break;
						}
					}else{
						alert('Se modificó correctamente el estante.');
						$("#submit-search-physical-elements-form").trigger('click');
						$("#edit-shelf").modal("hide");
					}
				}else{
					alert('¡Ocurrió un error! Inténtelo de nuevo.');
				}
			},
			error: function(){
				alert('¡Ocurrió un error! Inténtelo de nuevo.');
			}
		});
		
	});

	$("#submit-edit-cubicle").click(function(e){
		e.preventDefault();
		var id_cubiculo = $("input[name=id_cubiculo]").val();
		var codigo_cubiculo = $("input[name=codigo_cubiculo]").val();
		var capacidad_cubiculo = $("input[name=capacidad_cubiculo]").val();
		var tipo_cubiculo = $("select[name=tipo_cubiculo]").val();

		if(codigo_cubiculo.length < 1 || capacidad_cubiculo.length < 1){
			return alert('No deje campos vacíos.');
		}
		if(codigo_cubiculo.length > 45){
			return alert('El código no debe tener más de 45 caracteres.');
		}
		var regexNum = /^\s*\d+\s*$/;
		if(!regexNum.test(capacidad_cubiculo)){
			return alert('La capacidad debe ser numérico.');
		}
		if(capacidad_cubiculo < 0){
			return alert('La capacidad debe ser positiva.');
		}
		if(capacidad_cubiculo > 99){
			return alert('La capacidad debe ser menor que 99.');
		}

		$.ajax({
			url: inside_url+'config/submit_edit_cubicles',
			type: 'POST',
			data: { 'id' : id_cubiculo, 'code' : codigo_cubiculo, 'capacity' : capacidad_cubiculo, 'cubicle_type' : tipo_cubiculo },
			beforeSend: function(){
				$("#submit-edit-cubicle").addClass("disabled");
				$("#submit-edit-cubicle").hide();
				$(".edit_cubicle_loader_container").show();

			},
			complete: function(){
				$("#submit-edit-cubicle").removeClass("disabled");
				$("#submit-edit-cubicle").show();
				$(".edit_cubicle_loader_container").hide();
			},
			success: function(response){
				if(response.success){
					if(response.problem){
						switch(response.problem){
							case 'code_exists': alert('Existe otro cubículo con el mismo código.');
												break;
						}
					}else{
						alert('Se modificó correctamente el cubículo.');
						$("#submit-search-physical-elements-form").trigger('click');
						$("#edit-cubicle").modal("hide");
					}
				}else{
					alert('¡Ocurrió un error! Inténtelo de nuevo.');
				}
			},
			error: function(){
				alert('¡Ocurrió un error! Inténtelo de nuevo.');
			}
		});
	});
	
	var submit_create_cubicle = true;
	$("#submit-create-cubicle").click(function(e){
		e.preventDefault();
		if(submit_create_cubicle){
			submit_create_cubicle = false;
			var codigo = $("input[name=codigo_cubiculo_crear]").val();
			var capacidad = $("input[name=capacidad_cubiculo_crear]").val();
			var tipo_cubiculo = $("select[name=tipo_cubiculo_crear]").val();
			var branch_id = $("select[name=branch_filter]").val();

			if(branch_id > 0){

				if(codigo.length < 1 || capacidad.length < 1){
					submit_create_cubicle = true;
					return alert('No deje campos vacíos.');
				}
				if(codigo.length > 45){
					submit_create_cubicle = true;
					return alert('El código no debe tener más de 45 caracteres.');
				}
				var regexCode = /^[a-zA-Z]*\d*[a-zA-Z]*$/;
				if(!regexCode.test(codigo)){
					submit_create_cubicle = true;
					return alert('El código debe ser alfanumérico.');
				}

				var regexNum = /^\s*\d+\s*$/;
				if(!regexNum.test(capacidad)){
					submit_create_cubicle = true;
					return alert('La capacidad debe ser numérico.');
				}
				if(capacidad <= 0){
					submit_create_cubicle = true;
					return alert('La capacidad debe ser positiva.');
				}
				if(capacidad > 99){
					submit_create_cubicle = true;
					return alert('La capacidad debe ser menor que 99.');
				}

				if(tipo_cubiculo == '0'){
					submit_create_cubicle = true;
					return alert('Seleccione un tipo de cubículo.');
				}

				$.ajax({
					url: inside_url+'config/submit_create_cubicles',
					type: 'POST',
					data: { 'code' : codigo, 'capacity' : capacidad, 'cubicle_type' : tipo_cubiculo, 'branch_id' : branch_id },
					beforeSend: function(){
						$("#submit-create-cubicle").addClass("disabled");
						$("#submit-create-cubicle").hide();

					},
					complete: function(){
						$("#submit-create-cubicle").removeClass("disabled");
						$("#submit-create-cubicle").show();
						submit_create_cubicle = true;
					},
					success: function(response){
						if(response.success){
							if(response.problem){
								switch(response.problem){
									case 'code_exists': alert('Existe otro cubículo con el mismo código.');
														break;
								}
							}else{

								$("input[name=codigo_cubiculo_crear]").val("");
								$("input[name=capacidad_cubiculo_crear]").val("");
								$("select[name=tipo_cubiculo_crear]").val("0");
								alert('Se registró correctamente el cubículo.');
								$("#submit-search-physical-elements-form").trigger('click');
							}
						}else{
							alert('¡Ocurrió un error! Inténtelo de nuevo.');
						}
					},
					error: function(){
						alert('¡Ocurrió un error! Inténtelo de nuevo.');
					}
				});
			}else{
				alert('Seleccione una sede.');
				submit_create_cubicle = true;
			}
		}
	});

	var submit_create_shelf = true;
	$("#submit-create-shelf").click(function(e){
		e.preventDefault();
		if(submit_create_shelf){
			submit_create_shelf = false;
			var codigo = $("input[name=codigo_estante_crear]").val();
			var descripcion = $("textarea[name=descripcion_estante_crear]").val();
			var branch_id = $("select[name=branch_filter]").val();

			if(branch_id > 0){

				var regexCode = /^[a-zA-Z]*\d*[a-zA-Z]*$/;
				if(!regexCode.test(codigo)){
					submit_create_cubicle = true;
					return alert('El código debe ser alfanumérico.');
				}
				if(codigo.length < 1 || descripcion.length < 1){
					submit_create_shelf = true;
					return alert('No deje campos vacíos.');
				}
				if(codigo.length > 45){
					submit_create_shelf = true;
					return alert('El código no debe tener más de 45 caracteres.');
				}
				if(codigo.length > 255){
					submit_create_shelf = true;
					return alert('La descripción no debe tener más de 255 caracteres.');
				}

				$.ajax({
					url: inside_url+'config/submit_create_shelves',
					type: 'POST',
					data: { 'code' : codigo, 'description' : descripcion, 'branch_id' : branch_id },
					beforeSend: function(){
						$("#submit-create-shelf").addClass("disabled");
						$("#submit-create-shelf").hide();

					},
					complete: function(){
						$("#submit-create-shelf").removeClass("disabled");
						$("#submit-create-shelf").show();
						submit_create_shelf = true;
					},
					success: function(response){
						if(response.success){
							if(response.problem){
								switch(response.problem){
									case 'code_exists': alert('Existe otro estante con el mismo código.');
														break;
								}
							}else{

								$("input[name=codigo_estante_crear]").val("");
								$("textarea[name=descripcion_estante_crear]").val("");
								alert('Se registró correctamente el estante.');
								$("#submit-search-physical-elements-form").trigger('click');
							}
						}else{
							alert('¡Ocurrió un error! Inténtelo de nuevo.');
						}
					},
					error: function(){
						alert('¡Ocurrió un error! Inténtelo de nuevo.');
					}
				});
			}else{
				alert('Seleccione una sede.');
				submit_create_shelf = true;
			}
		}
	});

	var submit_create_physical_element = true;
	$("#submit-create-physical-element").click(function(e){
		e.preventDefault();
		if(submit_create_physical_element){
			submit_create_physical_element = false;
			var nombre = $("input[name=nombre_elemento_fisico_crear]").val();
			var cantidad = $("input[name=cantidad_elemento_fisico_crear]").val();
			var branch_id = $("select[name=branch_filter]").val();
			if(branch_id > 0){

				if(nombre.length < 1 || cantidad.length < 1){
					submit_create_physical_element = true;
					return alert('No deje campos vacíos.');
				}
				if(nombre.length > 128){
					submit_create_physical_element = true;
					return alert('El código no debe tener más de 128 caracteres.');
				}

				var regexName = /^[a-zA-Z]*$/;
				if(!regexName.test(nombre)){
					submit_create_cubicle = true;
					return alert('El nombre debe contener solamente letras.');
				}
				var regexNum = /^\s*\d+\s*$/;
				if(!regexNum.test(cantidad)){
					submit_create_physical_element = true;
					return alert('La cantidad debe ser numérico.');
				}
				if(cantidad <= 0){
					submit_create_physical_element = true;
					return alert('La cantidad debe ser positiva.');
				}
				if(cantidad > 9999){
					submit_create_physical_element = true;
					return alert('La cantidad debe ser menor que 9999.');
				}

				$.ajax({
					url: inside_url+'config/submit_create_physical_elements',
					type: 'POST',
					data: { 'name' : nombre, 'quantity' : cantidad, 'branch_id' : branch_id },
					beforeSend: function(){
						$("#submit-create-physical-element").addClass("disabled");
						$("#submit-create-physical-element").hide();

					},
					complete: function(){
						$("#submit-create-physical-element").removeClass("disabled");
						$("#submit-create-physical-element").show();
						submit_create_physical_element = true;
					},
					success: function(response){
						if(response.success){
							if(response.problem){
								switch(response.problem){
									case 'name_exists': alert('Existe otro elemento físico con el mismo nombre.');
														break;
								}
							}else{

								$("input[name=nombre_elemento_fisico_crear]").val("");
								$("input[name=cantidad_elemento_fisico_crear]").val("");
								alert('Se registró correctamente el elemento físico.');
								$("#submit-search-physical-elements-form").trigger('click');
							}
						}else{
							alert('¡Ocurrió un error! Inténtelo de nuevo.');
						}
					},
					error: function(){
						alert('¡Ocurrió un error! Inténtelo de nuevo.');
					}
				});
			}else{
				alert('Seleccione una sede.');
				submit_create_physical_element = true;
			}
		}
	});

	$("select[name=branch_filter]").change(function(){
		$("#submit-search-physical-elements-form").trigger('click');
	});
});

function render_physical_elements(branch_cubicles,cubicle_types,branch_physical_elements,branch_shelves)
{
	var str_physical_elements = "";
	str_physical_elements += "<tr class='info'>";
	str_physical_elements += "<th>Nombre</th><th>Cantidad</th><th class='text-center'>Eliminar</th></tr>";
	if(branch_physical_elements.length>0){
		for(i=0;i<branch_physical_elements.length;i++){
			str_physical_elements += "<tr><td><a href='' onclick='edit_physical_element_modal(event,"+branch_physical_elements[i].id+",\""+branch_physical_elements[i].name+"\","+branch_physical_elements[i].quantity+")'> "+branch_physical_elements[i].name+"</a></td>";
			str_physical_elements += "<td>"+branch_physical_elements[i].quantity+"</td>";
			str_physical_elements += "<td class='text-center'><a href='' class='btn btn-danger' onclick='delete_physical_element(event,"+branch_physical_elements[i].id+")'>Eliminar</a></td></tr>";
		}
	}
	$("#physical-elements-table").append(str_physical_elements);

	var str_shelves = "";
	str_shelves += "<tr class='info'>";
	str_shelves += "<th>Código</th><th>Descripción</th><th class='text-center'>Eliminar</th></tr>";
	if(branch_shelves.length>0){
		for(i=0;i<branch_shelves.length;i++){
			str_shelves += "<tr><td><a href='' onclick='edit_shelf_modal(event,"+branch_shelves[i].id+",\""+branch_shelves[i].code+"\",\""+branch_shelves[i].description+"\")'> "+branch_shelves[i].code+"</a></td>";
			str_shelves += "<td>"+branch_shelves[i].description+"</td>";
			str_shelves += "<td class='text-center'><a href='' class='btn btn-danger' onclick='delete_shelf(event,"+branch_shelves[i].id+")'>Eliminar</a></td></tr>";
		}
	}
	$("#shelves-table").append(str_shelves);

	var str_cubicles = "";
	str_cubicles += "<tr class='info'>";
	str_cubicles += "<th>Código</th><th>Capacidad de personas</th><th>Tipo de cubículo</th><th class='text-center'>Eliminar</th></tr>";
	if(branch_cubicles.length>0){
		for(i=0;i<branch_cubicles.length;i++){
			str_cubicles += "<tr><td><a href='' onclick='edit_cubicle_modal(event,"+branch_cubicles[i].id+",\""+branch_cubicles[i].code+"\","+branch_cubicles[i].capacity+","+branch_cubicles[i].cubicle_type_id+")'> "+branch_cubicles[i].code+"</a></td>";
			str_cubicles += "<td>"+branch_cubicles[i].capacity+"</td>";
			for(j=0;j<cubicle_types.length;j++){
				if(cubicle_types[j].id == branch_cubicles[i].cubicle_type_id){
					str_cubicles += "<td>"+cubicle_types[j].name+"</td>";
				}
			}
			str_cubicles += "<td class='text-center'><a href='' class='btn btn-danger' onclick='delete_cubicle(event,"+branch_cubicles[i].id+")'>Eliminar</a></td></tr>";
		}
	}
	$("#cubicle-table").append(str_cubicles);
}

function delete_physical_element(e,id)
{
	e.preventDefault();
	$.ajax({
		url: inside_url+'config/delete_physical_elements',
		type: 'POST',
		data: { 'id' : id },
		beforeSend: function(){
		},
		complete: function(){
		},
		success: function(response){
			if(response.success){
				$("#submit-search-physical-elements-form").trigger('click');
				alert('Se eliminó correctamente el elemento físico.');
			}else{
				alert('¡Ocurrió un error! Inténtelo de nuevo.');
			}
		},
		error: function(){
			alert('¡Ocurrió un error! Inténtelo de nuevo.');
		}
	});
}

function delete_shelf(e,id)
{
	e.preventDefault();
	$.ajax({
		url: inside_url+'config/delete_shelves',
		type: 'POST',
		data: { 'id' : id },
		beforeSend: function(){
		},
		complete: function(){
		},
		success: function(response){
			if(response.success){
				if(response.problem){
					switch(response.problem){
						case 'exist_material' : alert('No se pudo eliminar el estante seleccionado ya que hay materiales asociados a este.');
												break;
					}
				}else{
					$("#submit-search-physical-elements-form").trigger('click');
					alert('Se eliminó correctamente el estante.');
				}
			}else{
				alert('¡Ocurrió un error! Inténtelo de nuevo.');
			}
		},
		error: function(){
			alert('¡Ocurrió un error! Inténtelo de nuevo.');
		}
	});
}

function delete_cubicle(e,id)
{
	e.preventDefault();
	$.ajax({
		url: inside_url+'config/delete_cubicle',
		type: 'POST',
		data: { 'id' : id },
		beforeSend: function(){
		},
		complete: function(){
		},
		success: function(response){
			if(response.success){
				if(response.problem){
					switch(response.problem){
						case 'exist_reservation' : alert('No se pudo eliminar el cubículo seleccionado ya que existe una reserva asociada a este.');
												break;
					}
				}else{
					$("#submit-search-physical-elements-form").trigger('click');
					alert('Se eliminó correctamente el cubículo.');
				}
			}else{
				alert('¡Ocurrió un error! Inténtelo de nuevo.');
			}
		},
		error: function(){
			alert('¡Ocurrió un error! Inténtelo de nuevo.');
		}
	});
}

function edit_physical_element_modal(e,id,name,quantity)
{
	e.preventDefault();
	$("input[name=id_elemento_fisico]").val(id);
	$("input[name=nombre_elemento_fisico]").val(name);
	$("input[name=cantidad_elemento_fisico]").val(quantity);
	$("#edit-physical-element").modal("show");
}

function edit_shelf_modal(e,id,code,description)
{
	e.preventDefault();
	$("input[name=id_estante]").val(id);
	$("input[name=codigo_estante]").val(code);
	$("input[name=descripcion_estante]").val(description);
	$("#edit-shelf").modal("show");
}

function edit_cubicle_modal(e,id,code,capacity,cubicle_type)
{
	e.preventDefault();
	console.log(cubicle_types);
	$("input[name=id_cubiculo]").val(id);
	$("input[name=codigo_cubiculo]").val(code);
	$("input[name=capacidad_cubiculo]").val(capacity);
	$("select[name=tipo_cubiculo]").empty();
	var str_cubicle_types = "";
	for(i=0;i<cubicle_types.length;i++){
		if(cubicle_types[i].id == cubicle_type){
			str_cubicle_types += "<option value="+cubicle_types[i].id+" selected>"+cubicle_types[i].name+"</option>";
		}else{
			str_cubicle_types += "<option value="+cubicle_types[i].id+">"+cubicle_types[i].name+"</option>";
		}
	}
	$("select[name=tipo_cubiculo]").append(str_cubicle_types);
	$("#edit-cubicle").modal("show");
}