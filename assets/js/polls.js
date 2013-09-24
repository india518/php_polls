$(document).ready(function(){

	//alert("hi");

	//$('.poll_display').submit(function(){
	$(document).on('submit', '.poll_display', function(){
		var this_form = $(this);
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

	//Poll form is loaded at page load and doesn't alter, so we dont need a
	// $(document).on() for this:
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

});