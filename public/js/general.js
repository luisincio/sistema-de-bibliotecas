$( document ).ready(function(){

	$("#clear-fields").click(function(e){
		e.preventDefault();
		$("input[type=text]").val('');
	});

	$("input[name=select_all]").click(function(){
		if($(this).prop('checked')){
			$("input[type=checkbox]").prop('checked',true);
		}else{
			$("input[type=checkbox]").prop('checked',false);
		}
	});

});