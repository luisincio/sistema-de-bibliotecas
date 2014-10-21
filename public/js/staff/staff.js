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
		format:'yyyy-mm-dd'
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

});