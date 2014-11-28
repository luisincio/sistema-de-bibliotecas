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
								alert('Algunos materiales no pudieron ser eliminados ya que existen préstamos o reservas pendientes.');
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

	$("input[name=date_ini]").datepicker({
		format:'yyyy-mm-dd'
	});

	$("input[name=date_end]").datepicker({
		format:'yyyy-mm-dd'
	});

	$("input[name=fecha_emision]").datepicker({
		format:'yyyy-mm-dd'
	});

	$("input[name=fecha_vencimiento]").datepicker({
		format:'yyyy-mm-dd'
	});

	$("#add-list").click(function(e){
		e.preventDefault();
		var code = $("input[name=codigo]").val();
		var title = $("input[name=titulo]").val();
		var author = $("input[name=autor]").val();
		var quantity = $("input[name=cantidad_ordenes]").val();
		var unit_price = $("input[name=precio]").val();

		
		
		if(code.length < 1 || title.length < 1 || author.length < 1 || quantity.length < 1 || unit_price.length < 1){
			return alert("No deje ningún campo del detalle vacío.");
		}
		if(code.length > 45){
			return alert("El código no puede ser mayor a 45 caracteres.");
		}
		if(title.length > 255){
			return alert("El título no puede ser mayor a 255 caracteres.");
		}
		if(author.length < 2){
			return alert("El autor no puede ser menor a 2 caracteres.");
		}
		if(author.length > 255){
			return alert("El autor no puede ser mayor a 255 caracteres.");
		}
		var regex = /^[A-Za-z0-9]+$/;
		if (!regex.test(code)) {
			return alert("El código del detalle debe ser alfa-numérico.");
		}
		var regexNum = /^[0-9]+$/;
		if(!regexNum.test(quantity)){
			return alert("La cantidad del detalle debe ser un número entero.");
		}
		var regexPattern = /^\d{1,8}(\.\d{1,2})?$/;
		if(!regexPattern.test(unit_price)){
			return alert("El precio unitario del detalle debe contener una parte entera y dos decimales despues del punto.");
		}

		var str = "<tr><td><input name='details_code[]' value='"+code+"' readonly/></td>";
		str += "<td><input name='details_title[]' value='"+title+"' readonly/></td>";
		str += "<td><input name='details_author[]' value='"+author+"' readonly/></td>";
		str += "<td><input name='details_quantity[]' value='"+quantity+"' readonly/></td>";
		str += "<td><input name='details_unit_price[]' value='"+unit_price+"' readonly/></td>";
		str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRow(event,this)'>X</a></td></tr>";
		$("table").append(str);
		
		$("input[name=codigo]").val('');
		$("input[name=titulo]").val('');
		$("input[name=autor]").val('');
		$("input[name=cantidad_ordenes]").val('');
		$("input[name=precio]").val('');
		
	});



	var submit_reject = true;
	$("#submit-reject").click(function(e){
		e.preventDefault();
		if(submit_reject){
			submit_reject = false;			
			
			var confirmation = confirm("¿Está seguro que desea rechazar la orden de compra?");		
			if(confirmation){	
				var id = $(this).data('id');	
				console.log(id);
				
				$.ajax({
					url: inside_url+'material/submit_reject_purchase_order_ajax',
					type: 'POST',
					data: { 'id' : id },
					beforeSend: function(){
					},
					complete: function(){
						submit_reject = true;
					},
					success: function(response){
						if(response.success){
							window.location.replace(inside_url+'material/list_purchase_order');
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


	$("#clear-fields-purchase-order").click(function(e){
		e.preventDefault();
		$("input[name=codigo]").val('');
		$("input[name=titulo]").val('');
		$("input[name=autor]").val('');
		$("input[name=cantidad_ordenes]").val('');
		$("input[name=precio]").val('');
		
	});

	$("input[type=checkbox][name=suscripcion]").change(function(){
		if($(this).is(":checked")){
			$("#toggle-suscripcion").show();
		}else{
			$("#toggle-suscripcion").hide();
		}
	});

	$("input[type=checkbox][name=donacion]").change(function(){
		if($(this).is(":checked")){
			$("#toggle-donador").show();
			$("#toggle-orden-de-compra").hide();
		}else{
			$("#toggle-orden-de-compra").show();
			$("#toggle-donador").hide();
		}
	});

	$("input[name=fecha_ini]").datepicker({
		format:'yyyy-mm-dd',
	});

	$("input[name=fecha_fin]").datepicker({
		format:'yyyy-mm-dd',
	});

	var codigo = "";
	$("input[name=codigo]").blur(function(){
		var input_length = $(this).val().length;
		var input_val = $(this).val();
		if((input_length > 0) && (codigo !== input_val)){
			codigo = input_val;
			$.ajax({
				url: inside_url+'loan/validate_material_code_ajax',
				type: 'POST',
				data: { 'material_code' : input_val },
				beforeSend: function(){
					$(".form-group-material-code img").show();
				},
				complete: function(){
					$(".form-group-material-code img").hide();
				},
				success: function(response){
					if(response.success){
						if(response.material.length > 0){
							$("select[name=tipo_material]").val(response.material[0].material_type);
							$("select[name=area_tematica]").val(response.material[0].thematic_area);
							$("input[name=titulo]").val(response.material[0].title);
							$("input[name=autor]").val(response.material[0].author);
							$("input[name=editorial]").val(response.material[0].editorial);
							$("input[name=isbn]").val(response.material[0].isbn);
							$("input[name=anio_publicacion]").val(response.material[0].publication_year);
							$("input[name=num_edicion]").val(response.material[0].edition);
							$("input[name=num_paginas]").val(response.material[0].num_pages);
							$("input[name=materiales_adicionales]").val(response.material[0].additional_materials);
						}
					}
				},
				error: function(){
					alert('¡Ocurrió un error! No se pudo conectar con el servidor.');
				}
			});
		}
	});
	
});

function deleteRow(event,el)
{
	event.preventDefault();
	console.log(el);
	var parent = el.parentNode;
	parent = parent.parentNode;
	parent.parentNode.removeChild(parent);
}