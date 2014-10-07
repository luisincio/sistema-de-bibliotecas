$( document ).ready(function(){

	$("#clear-fields").click(function(e){
		e.preventDefault();
		$("input[type=text]").val('');
	});

});