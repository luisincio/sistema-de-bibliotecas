$( document ).ready(function(){

	var delete_selected_reservations = true;
	$("#delete-selected-reservations").click(function(e){
		e.preventDefault();
		if(delete_selected_reservations){
			delete_selected_reservations = false;
			var selected = [];
			$("input[type=checkbox][name=reservations]:checked").each(function(){
				selected.push($(this).val());
			});
			if(selected.length > 0){
				var confirmation = confirm("¿Está seguro que desea anular las reservas seleccionadas?");
				if(confirmation){
					$.ajax({
						url: inside_url+'reservation/delete_material_reservations_ajax',
						type: 'POST',
						data: { 'selected_id' : selected },
						beforeSend: function(){
							$("#delete-selected-reservations").addClass("disabled");
							$("#delete-selected-reservations").hide();
							$(".loader_container").show();
						},
						complete: function(){
							$(".loader_container").hide();
							$("#delete-selected-reservations").removeClass("disabled");
							$("#delete-selected-reservations").show();
							delete_selected_reservations = true;
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
					delete_selected_reservations = true;
				}
			}else{
				delete_selected_reservations = true;
				alert('Seleccione alguna casilla.');
			}
		}
	});

	var submit_search_cubicles = true;
	$("#submit-search-cubicles").click(function(e){
		e.preventDefault();
		if(submit_search_cubicles){
			submit_search_cubicles = false;
			var branch_id = $("select[name=branch_filter]").val();
			var cubicle_type_id = $("select[name=cubicle_type_filter]").val();
			$.ajax({
				url: inside_url+'reservation/search_cubicle_ajax',
				type: 'POST',
				data: { 'branch_id' : branch_id, 'cubicle_type_id' : cubicle_type_id },
				beforeSend: function(){
					$("#submit-search-cubicles").addClass('disabled');
					$("table#cubicle-table").empty();
					$("a#submit-cubicle-reservation").remove();
					$(".big-loader-container").show();
				},
				complete: function(){
					$("#submit-search-cubicles").removeClass('disabled');
					$(".big-loader-container").hide();
					submit_search_cubicles = true;
				},
				success: function(response){
					if(response.success){
						render_cubicle_reservation_table(response);
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

	var submit_cubicle_reservation_form = true;
	$("#submit-cubicle-reservation-form").click(function(e){
		e.preventDefault();
		if(submit_cubicle_reservation_form){
			submit_cubicle_reservation_form = false;
			var cubicle_id_form = $("input[name=cubicle_id]").val();
			var cubicle_reservation_form_num_person = $("input[name=cubicle_reservation_form_num_person]").val();
			var cubicle_reservation_form_hour_in = $("input[name=cubicle_reservation_form_hour_in]").val();
			var cubicle_reservation_form_hour_out = $("input[name=cubicle_reservation_form_hour_out]").val();
			if( cubicle_reservation_form_num_person.length > 0 ){
				if( cubicle_reservation_form_num_person <=selected_cubicle_capacity ){
					$.ajax({
						url: inside_url+'reservation/cubicle_submit_reservation_ajax',
						type: 'POST',
						data: { 'cubicle_id_form' : cubicle_id_form, 'cubicle_reservation_form_num_person' : cubicle_reservation_form_num_person, 'cubicle_reservation_form_hour_in' : cubicle_reservation_form_hour_in, 'cubicle_reservation_form_hour_out' : cubicle_reservation_form_hour_out },
						beforeSend: function(){
							$("a#submit-cubicle-reservation-form").hide();
							$(".loader_container").show();
						},
						complete: function(){
							$(".loader_container").hide();
							$("a#submit-cubicle-reservation-form").show();
							submit_cubicle_reservation_form = true;
							$("div#cubicle-reservation-form").modal('hide');
							$("#submit-search-cubicles").trigger('click');
						},
						success: function(response){
							if(response.success){
								if(response.reservation_done){
									alert('Se reservó correctamente el cubículo.');
								}else{
									switch(response.problem){
										case 'penalize': alert('No se pudo realizar la acción, usted está penalizado.');
														 break;
										case 'has_reservation': alert('No se pudo realizar la acción, usted ya tiene una reserva vigente o el cubículo ya está reservado por otra persona.');
																break;
									}
									
								}
							}else{
								alert('La petición no se pudo completar, inténtelo de nuevo.');
							}
						},
						error: function(){
							alert('La petición no se pudo completar, inténtelo de nuevo.');
						}
					});
				}else{
					submit_cubicle_reservation_form = true;
					alert('La capacidad máxima del cubículo es de '+selected_cubicle_capacity+' personas.');
				}
			}else{
				submit_cubicle_reservation_form = true;
				alert('Ingrese la cantidad de personas que ingresarán al cubículo.');
			}
		}
	});

	var delete_selected_cubicle_reservations = true;
	$("#delete-selected-cubicle-reservations").click(function(e){
		e.preventDefault();
		if(delete_selected_cubicle_reservations){
			delete_selected_cubicle_reservations = false;
			var selected = [];
			$("input[type=checkbox][name=reservacion]:checked").each(function(){
				selected.push($(this).val());
			});
			if(selected.length > 0){
				var confirmation = confirm("¿Está seguro que desea eliminar las reservas seleccionadas?");
				if(confirmation){
					$.ajax({
						url: inside_url+'reservation/delete_cubicle_reservations_ajax',
						type: 'POST',
						data: { 'selected_id' : selected },
						beforeSend: function(){
							$("#delete-selected-cubicle-reservations").addClass("disabled");
							$("#delete-selected-cubicle-reservations").hide();
							$(".loader_container").show();
						},
						complete: function(){
							$(".loader_container").hide();
							$("#delete-selected-cubicle-reservations").removeClass("disabled");
							$("#delete-selected-cubicle-reservations").show();
							delete_selected_cubicle_reservations = true;
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
					delete_selected_cubicle_reservations = true;
				}
			}else{
				delete_selected_cubicle_reservations = true;
				alert('Seleccione alguna casilla.');
			}
		}
	});
});

function render_cubicle_reservation_table(data)
{
	if(data.cubicles.length > 0){
		/* First I get time interval applied to cubicles */
		var hour_ini = data.branch.hour_ini.split(":");
		var hour_end = data.branch.hour_end.split(":");
		var time_interval = hour_end[0] - hour_ini[0];

		var str_table = "<tr class='info'><th>Horas/Cubículos</th>";
		/* This part is for the table header */
		for(i=0;i<data.cubicles.length;i++){
			str_table += "<th>"+data.cubicles[i].code+"</th>";
		}
		str_table += "</tr>";
		/* This part is for the body of the table */
		var hour_ini_reservation;
		var hour_end_reservation;
		var available = true;
		var current_date = new Date();
		var current_hour = current_date.getHours();
		console.log(current_date.getHours());
		for(i=0;i<time_interval;i++){
			str_table += "<tr><td class='info hour-cell'>"+(i+parseInt(hour_ini[0]))+":00</td>";
			for(j=0;j<data.cubicles.length;j++){
				/* Search if the cubicle at that hour is reserved */
				available = true;
				for(k=0;k<data.cubicle_reservations.length;k++){
					if(data.cubicles[j].id == data.cubicle_reservations[k].cubicle_id){
						hour_ini_reservation = data.cubicle_reservations[k].hour_in.split(":");
						hour_ini_reservation = hour_ini_reservation[0];
						hour_end_reservation = data.cubicle_reservations[k].hour_out.split(":");
						hour_end_reservation = hour_end_reservation[0];
						if((i+parseInt(hour_ini[0]))>=hour_ini_reservation && (i+parseInt(hour_ini[0]))<hour_end_reservation){
							str_table += "<td class='bg-danger x-"+j+" y-"+i+"' onclick='cubicle_reservation_detail("+data.cubicle_reservations[k].id+")'></td>";
							available = false;
							break;
						}
					}
				}
				if(available && ( (i+parseInt(hour_ini[0])) > current_hour)){
					str_table += "<td class='bg-success x-"+j+" y-"+i+"' onclick='selecting_cells("+(i+parseInt(hour_ini[0]))+","+j+","+i+","+data.cubicles[j].id+","+data.cubicles[j].capacity+")' onmouseover='paint_cells("+(i+parseInt(hour_ini[0]))+","+j+","+i+")' onmouseout='unpaint_cells("+(i+parseInt(hour_ini[0]))+","+j+","+i+")'></td>";
				}else if( (i+parseInt(hour_ini[0])) <= current_hour ){
					str_table += "<td class='bg-warning x-"+j+" y-"+i+"'></td>";
				}
			}
			str_table += "</tr>";
		}
		/* Append the string generated to the table */
		$("table#cubicle-table").append(str_table);
		var str_submit = "<a href='' id='submit-cubicle-reservation' class='btn btn-info' onclick='open_reservation_modal(event)'>Confirmar la reserva</a>";
		$("div#cubicle-table-container").append(str_submit);
		/* Initializa some variables */
		stack_hours = [];
		stack_axis_x =[];
		stack_axis_y = [];
		start_selection = false;
		selected_cells = 0;
		selected_cubicle_id = -1;
		selected_cubicle_capacity = -1;
	}else{
		alert('Esta sede no presenta cubículos del tipo seleccionado que puedan ser utilizados.');
	}
}

function cubicle_reservation_detail(reservation_id)
{
	$.ajax({
		url: inside_url+'reservation/cubicle_reservation_detail_ajax',
		type: 'POST',
		data: { 'reservation_id' : reservation_id},
		beforeSend: function(){
			$("#cubicle-reservation-user").text("");
			$("#cubicle-reservation-num-person").text("");
			$("#cubicle-reservation-hour-in").text("");
			$("#cubicle-reservation-hour-out").text("");

			$(".modal-header").hide();
			$(".modal-body").hide();
			$(".loader-container").show();
			$("#cubicle-reservation-detail").modal("show");
		},
		complete: function(){
			$(".loader-container").hide();
		},
		success: function(response){
			if(response.success){
				$("#cubicle-reservation-user").text(response.person.lastname+", "+response.person.name);
				$("#cubicle-reservation-num-person").text(response.cubicle_reservation.num_person);
				$("#cubicle-reservation-hour-in").text(response.cubicle_reservation.hour_in);
				$("#cubicle-reservation-hour-out").text(response.cubicle_reservation.hour_out);

				$(".modal-header").show();
				$(".modal-body").show();
			}else{
				alert('La petición no se pudo completar, inténtelo de nuevo.');
			}
		},
		error: function(){
			alert('La petición no se pudo completar, inténtelo de nuevo.');
		}
	});
}

var selected_cubicle_capacity = -1;
function open_reservation_modal(e)
{
	e.preventDefault();
	if(selected_cubicle_id == -1){
		alert('Seleccione el cubículo y las horas que lo desea reservar.');
	}else{
		if(stack_hours.length<1){
			alert('Ha ocurrido un error con la reserva, inténtelo de nuevo.');
		}else{
			var initial_hour;
			var final_hour;
			if(stack_hours[0] > stack_hours[stack_hours.length-1]){
				initial_hour = stack_hours[stack_hours.length-1];
				final_hour = stack_hours[0];
			}else{
				initial_hour = stack_hours[0];
				final_hour = stack_hours[stack_hours.length-1];
			}
			$("p#cubicle-reservation-form-info").html("Capacidad máxima del cubículo: "+selected_cubicle_capacity+" persona(s)");
			$("input[name=cubicle_reservation_form_num_person]").val('');
			$("input[name=cubicle_reservation_form_hour_in]").val(initial_hour+":00:00");
			$("input[name=cubicle_reservation_form_hour_out]").val((parseInt(final_hour)+1)+":00:00");
			$("input[name=cubicle_id]").val(selected_cubicle_id);
			$("div#cubicle-reservation-form").modal('show');
		}
	}
}

var stack_hours = new Array();
var stack_axis_x = new Array();
var stack_axis_y = new Array();

var start_selection = false;
var selected_cells = 0;
var selected_cubicle_id = -1;

function selecting_cells(hour,x,y,cubicle_id,capacity)
{
	if(!start_selection){
		/* The begining of the selection */
		start_selection = true;
		selected_cubicle_id = cubicle_id;
		selected_cubicle_capacity = capacity;
		stack_hours.push(hour);
		stack_axis_x.push(x);
		stack_axis_y.push(y);
		selected_cells = 1;
		var td_class = "td.x-"+x+".y-"+y;
		$(td_class).addClass("drag-cell");
	}else{
		/* If the selection has already started */
		if(x == stack_axis_x[0]){
			if( (x == stack_axis_x[stack_axis_x.length-1]) && (y == stack_axis_y[stack_axis_y.length-1]) ){
				/* This is for deselecting */
				stack_hours.pop();
				stack_axis_x.pop();
				stack_axis_y.pop();
				selected_cells--;
				if(stack_hours.length < 1){
					/* If all cells are deselected */
					selected_cells = 0;
					selected_cubicle_id = -1;
					selected_cubicle_capacity = -1;
					start_selection = false;
					var td_class = "td.x-"+x+".y-"+y;
					$(td_class).removeClass("drag-cell");
				}else{
					var td_class = "td.x-"+x+".y-"+y;
					$(td_class).toggleClass("drag-cell");
				}
			}else{
				if(selected_cells < max_hour_cubicle_loan){
					if( ((y == stack_axis_y[stack_axis_y.length-1]+1) || (y == stack_axis_y[stack_axis_y.length-1]-1)) && (y!=stack_axis_y[0])){
						if( (y > stack_axis_y[stack_axis_y.length-1]) && (y > stack_axis_y[0]) ){
							stack_hours.push(hour);
							stack_axis_x.push(x);
							stack_axis_y.push(y);
							selected_cells++;
							var td_class = "td.x-"+x+".y-"+y;
							$(td_class).toggleClass("drag-cell");
						}else if( (y < stack_axis_y[stack_axis_y.length-1]) && (y < stack_axis_y[0]) ){
							stack_hours.push(hour);
							stack_axis_x.push(x);
							stack_axis_y.push(y);
							selected_cells++;
							var td_class = "td.x-"+x+".y-"+y;
							$(td_class).toggleClass("drag-cell");
						}
					}
				}
			}
		}
	}
}

function paint_cells(hour,x,y)
{
	var td_class = "td.x-"+x+".y-"+y;
	if(!start_selection){
		$(td_class).addClass("drag-cell");
	}else{
		if(x == stack_axis_x[0]){
			//$(td_class).addClass("selecting-cell");
			if(selected_cells < max_hour_cubicle_loan){
				if( ((y <= stack_axis_y[stack_axis_y.length-1]+1) && (y >= stack_axis_y[stack_axis_y.length-1]-1)) && (y!=stack_axis_y[0])){
					if( (y > stack_axis_y[stack_axis_y.length-1]) && (y > stack_axis_y[0]) ){
						$(td_class).addClass("selecting-cell");
					}else if( (y < stack_axis_y[stack_axis_y.length-1]) && (y < stack_axis_y[0]) ){
						$(td_class).addClass("selecting-cell");
					}else if((y == stack_axis_y[stack_axis_y.length-1])){
						$(td_class).addClass("selecting-cell");
					}
				}
			}else{
				if( (y == stack_axis_y[stack_axis_y.length-1]) ){
					$(td_class).addClass("selecting-cell");
				}
			}
		}
	}
}

function unpaint_cells(hour,x,y)
{
	var td_class = "td.x-"+x+".y-"+y;
	if(!start_selection){
		$(td_class).removeClass("drag-cell");
		$(td_class).removeClass("selecting-cell");
	}else{
		if(x == stack_axis_x[0]){
			$(td_class).removeClass("selecting-cell");
		}
	}
}