$(document).ready(function(){

	$('#add_poll').submit(function(){
		var this_form = $(this);

		$.post(
			this_form.attr("action"),
			this_form.serialize(),
			function(data){
				$("#poll_list").prepend(data['html']);
			},
			"json"
		);

		return false;
	});

	//When a form belong to class '.poll_display' is submitted, that means a vote
	// on a poll has been submitted:
	$(document).on('submit', '.poll_display', function(){
		var this_form = $(this);

		//Every poll voting form has an id that is '#poll_<number>'
		//The corresponding div to display the voting results has an id that is
		// '#results_poll_<number>', so we can use the id of the submitted form 
		// to tell us which results div to update:
		var result_div = "#results_" + this_form.attr("id");
		
		$.post(
			this_form.attr("action"),
			this_form.serialize(),
			function(data){
				$(result_div).html(data['html']);
			},
			"json"
		);

		return false;
	});

});