$(document).ready(function(){

	//alert("hi");

	//all polls are displayed when page is loaded
	$('.poll_display').submit(function(){

		var this_form = $(this);
		var result_div = "#results_" + this_form.attr("id");
		// alert(this_form.attr("id"));
		// alert(result_div);
		$.post(
			this_form.attr("action"),
			this_form.serialize(),
			function(data){
				console.log("We're in the function!");
				$(result_div).html(data['html']);
			},
			"json"
		);
		console.log("after definition of $.post");
		return false;
	});

});