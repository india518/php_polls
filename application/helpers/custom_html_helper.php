<?php

function print_results_table($options)
{
	//Takes array of poll options and prints out a table
	// No header for table, so no <thead></thead>
	$html = "
	<table class='table table-hover table-condensed'>
		<caption class='text-left'>Results:</caption>
		<tbody>";
	foreach($options as $option)
	{
		$html .= "<tr>";
		$html .= "<td>{$option['percentage']}%</td>";
		$html .= "<td>{$option['name']}</td>";
		$html .= "</tr>";
	}
	$html .= "
		</tbody>
	</table>";
	return $html;
}

function print_poll_display($poll, $options)
{
	//Given a poll and the options that belong to that poll, this function
	// generates the div to display the new poll, the voting form, and
	// the voting results
	$html = "
	<div class='container'>
		<p class=pull-right>ID: {$poll['id']}</p>
		<div class='well'>
			<h4>{$poll['title']}</h4>
			<p>{$poll['description']}</p>
			<form id='poll_{$poll['id']}' class='poll_display' action='poll/process_vote' method='post'>
				<div class='radio_buttons'>";
 	foreach($options as $option)
	{
		$html .= "<input type='radio' name='option_id' value='{$option['id']}' />";
		$html .= "<label for='vote'>{$option['name']}</label>";
	}
	$html .= "
				</div>
				<input type='hidden' name='poll_id' value='{$poll['id']}' />
				<button type='submit' class='btn btn-primary pull-right'>submit</button>
			</form>
			<div id='results_poll_{$poll['id']}' class='results'>";
	$html .= print_results_table($options);
	$html .= "
			</div>
		</div>
	</div>";
	return $html;
}

//end of file