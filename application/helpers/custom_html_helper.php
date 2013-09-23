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
		//TODO: result percentage should go below: 
		$html .= "<td>{$option->percentage}%</td>";
		$html .= "<td>{$option->name}</td>";
		$html .= "</tr>";
	}
	$html .= "
		</tbody>
	</table>";
	return $html;
}

//end of file