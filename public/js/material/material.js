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

		
		
		if(code.length < 1 || title.length < 1 || author.length < 1 || quantity.length < 1 || unit_price < 1){
			return alert("Datos del detalle inválidos.1");
		}
		var regex = /^[A-Za-z0-9]+$/;
		if (!regex.test(code)) {
			return alert("Datos del detalle inválidos.2");
		}
		var regexNum = /^[A-Za-z0-9]+$/;
		if(!regexNum.test(quantity)){
			return alert("Datos del detalle inválidos.3");
		}
		var regexPattern = /^\d{0,8}(\.\d{1,2})?$/;
		if(!regexPattern.test(unit_price)){
			return alert("Datos del detalle inválidos.4");
		}

		var str = "<tr><td><input name='details_code[]' value='"+code+"' readonly/></td>";
		str += "<td><input name='details_title[]' value='"+title+"' readonly/></td>";
		str += "<td><input name='details_author[]' value='"+author+"' readonly/></td>";
		str += "<td><input name='details_quantity[]' value='"+quantity+"' readonly/></td>";
		str += "<td><input name='details_unit_price[]' value='"+unit_price+"' readonly/></td>";
		str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRow(event,this)'>X</a></td></tr>";
		$("table").append(str);
		
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

	
});

function deleteRow(event,el)
{
	event.preventDefault();
	console.log(el);
	var parent = el.parentNode;
	parent = parent.parentNode;
	parent.parentNode.removeChild(parent);
}