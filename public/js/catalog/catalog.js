$( document ).ready(function(){

	var material_detail = true;
	$(".material-title").click(function(e){
		e.preventDefault();
		if(material_detail){
			material_detail = false;
			var material_id = $(this).data('id');
			var thematic_area = $(this).parents("tr").children("td.thematic-area-field").html();
			var branch =  $(this).parents("tr").children("td.branches-field").html();
			var total_materials =  $(this).parents("tr").children("td.total-materials-field").html();
			$.ajax({
				url: inside_url+'material_detail_ajax',
				type: 'POST',
				data: { 'material_id' : material_id },
				beforeSend: function(){
					$("#material-title").text("");
					$("#material-author").text("");
					$("#material-editorial").text("");
					$("#material-edition").text("");
					$("#material-thematic-area").text("");
					$("#material-isbn").text("");
					$("#material-publication-year").text("");
					$("#material-num-pages").text("");
					$("#material-aditional").text("");
					$("#material-branch").text("");
					$("#material-total-materials").text("");
					
					$(".modal-header").hide();
					$(".modal-body").hide();
					$(".loader-container").show();
					$("#material-detail").modal("show");
				},
				complete: function(){
					$(".loader-container").hide();
					$(".modal-header").show();
					$(".modal-body").toggle('fast');
					material_detail = true;
				},
				success: function(response){
					if(response.success){
						$("#material-title").text(response.material.title);
						$("#material-author").text(response.material.author);
						$("#material-editorial").text(response.material.editorial);
						$("#material-edition").text(response.material.edition);
						$("#material-thematic-area").text(thematic_area);
						$("#material-isbn").text(response.material.isbn);
						$("#material-publication-year").text(response.material.publication_year);
						$("#material-num-pages").text(response.material.num_pages);
						if(response.material.additional_materials.length > 0){
							$("#material-aditional").text(response.material.additional_materials);
						}else{
							$("#material-aditional").text("Ninguno");
						}
						$("#material-branch").text(branch);
						$("#material-total-materials").text(total_materials);
					}else{
						alert('La petición no se pudo completar, inténtelo de nuevo.');
					}
				},
				error: function(){
					alert('La petición no se pudo completar, inténtelo de nuevo.');
				}
			});
		}
	});

	var material_reservation = true;
	$(".reservation-button").click(function(e){
		e.preventDefault();
		if(material_reservation){
			var material_title = $(this).parents("tr").find("td a.material-title").html();
			var confirmation = confirm("Está a punto de reservar el libro: "+material_title);
			if(confirmation){
				material_reservation = false;
				var material_code = $(this).data('code');
				var material_branch = $(this).data('branch');
				var material_shelf = $(this).data('shelf');
				$.ajax({
					url: inside_url+'reservation/material_reservation_ajax',
					type: 'POST',
					data: { 'material_code' : material_code, 'material_branch' : material_branch, 'material_shelf' : material_shelf },
					beforeSend: function(){
						$(this).addClass('disable');
					},
					complete: function(){
						$(this).removeClass('disable');
						material_reservation = true;
					},
					success: function(response){
						console.log(response);
						if(response.success){
							switch(response.material_available){
								case '1': alert('El material fue reservado exitosamente.');
										break;
								case '2': alert('El material fue reservado exitosamente pero usted está en la cola de espera.\nEsté atento a las notificaciones que le enviaremos a su correo.');
										break;
								case '3': alert('El material fue reservado exitosamente aunque todos los ejemplares están prestados.\nEsté atento a las notificaciones que le enviaremos a su correo.');
										break;
							}
							location.reload();
						}else{
							switch(response.problem){
								case 'max_materials':   alert('Usted alcanzó el límite de préstamos para su perfil.');
														break;
								case 'restricted_user': alert('Su usario está prohibido temporalmente de reservar materiales');
														break;
								case 'material_type_unavailable': alert('Su usario no tiene permiso para reservar este tipo de material');
																  break;
								case 'has_reservation': alert('Usted tiene una reserva vigente de este material');
														break;
								case 'has_loan': alert('Usted tiene un préstamo vigente de este material');
												 break;
							}
						}
					},
					error: function(){
						alert('La petición no se pudo completar, inténtelo de nuevo.');
					}
				});
			}
		}
	});

});