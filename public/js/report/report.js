$( document ).ready(function(){

	$("input[name=date_ini]").datepicker({
		format:'yyyy-mm-dd',
		endDate: '+0d'
	});

	$("input[name=date_end]").datepicker({
		format:'yyyy-mm-dd',
		endDate: '+0d'
	});

	$("input[name=date_ini]").change(function(){
		var date_ini = $(this).val();
		$("input[name=date_ini_excel]").val(date_ini);
	});

	$("input[name=date_end]").change(function(){
		var date_end = $(this).val();
		$("input[name=date_end_excel]").val(date_end);
	});

	$("input[name=num_doc]").change(function(){
		var num_doc = $(this).val();
		$("input[name=num_doc_excel]").val(num_doc);
	});

	$("#toggle-button").click(function(e){
		e.preventDefault();
		if($("form#toggle-form").is(':hidden')){
			$("#toggle-button").html('-');
		}else{
			$("#toggle-button").html('+');
		}
		$("form#toggle-form").toggle('fast');
	});

	$("#submit_top_loans_excel_button").click(function(e){
		e.preventDefault();
		$("form#submit_top_loans_excel").submit();
	});

	$("#submit_most_requested_materials_excel_button").click(function(e){
		e.preventDefault();
		$("form#submit_most_requested_materials_excel").submit();
	});

	$("#submit_restricted_users_excel_button").click(function(e){
		e.preventDefault();
		$("form").submit();
	});

	$("#submit_loans_by_user_excel_button").click(function(e){
		e.preventDefault();
		$("form#submit_loans_by_user_excel").submit();
	});

	$("#submit_last_material_entries_excel_button").click(function(e){
		e.preventDefault();
		$("form#submit_last_material_entries_excel").submit();
	});

	$("#submit_loans_by_material_excel_button").click(function(e){
		e.preventDefault();
		$("form#submit_loans_by_material_excel").submit();
	});

	$("#submit_approved_rejected_purchase_orders_excel_button").click(function(e){
		e.preventDefault();
		$("form#submit_approved_rejected_purchase_orders_excel").submit();
	});

});