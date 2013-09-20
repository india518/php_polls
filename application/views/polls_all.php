<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Poll List</title>
	<link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="../assets/css/mycss.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div id="wrapper" class="container">
		<!-- TODO: Add some top/left margin around Add button! -->
		<a href="poll/add" class="btn" id="add_redirect">Add a Poll</a>
<?php
		foreach ($polls as $poll)
		{
			// echo "<pre>";
			// var_dump($poll);
			// echo "</pre>";
?>
			<div class="container">
				<p class="pull-right">ID: <?= $poll->id ?></p>
				<div class="well">
					<h4><?= $poll->title ?></h4>
					<p><?= $poll->description ?></p>
					<form id="poll_<?= $poll->id ?>" action="poll/process_vote" method="post">
						<!-- radio buttons for options -->
<?php
						foreach($options[$poll->id] as $option)
    					{
            				echo $option->name;
     					}
?>
						<button type="submit" class="btn btn-primary pull-right">submit</button>
					</form>
				</div>
				<div id="results_poll_<?= $poll->id ?>">
					<!-- call function to calc vote results -->
				</div>
			</div>
<?php	}?>
	</div>
</body>
</html>