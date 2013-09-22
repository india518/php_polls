<?php
	require('application/helpers/html_helpers.php');
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Poll List</title>
	<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/mycss.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div id="wrapper" class="container">
<?php 	if($this->session->flashdata('error_messages') != NULL)
		{	?>
		<div id="display_messages" class="alert alert-block alert-error">
			<p><?= $this->session->flashdata('error_messages') ?></p>
		</div><!-- closes the alert block -->
<?php	}	?>
		<a href="poll/add" class="btn" id="add_redirect">Add a Poll</a>
<?php
		foreach ($polls as $poll)
		{	?>
			<div class="container">
				<p class="pull-right">ID: <?= $poll->id ?></p>
				<div class="well">
					<h4><?= $poll->title ?></h4>
					<p><?= $poll->description ?></p>
					<form id="poll_<?= $poll->id ?>" class="poll_display" action="poll/process_vote" method="post">
						<div class="radio_buttons">
							<!-- TODO: Can we improve the CSS styling on this? -->
							<!-- Look into bootstrap docs on radio buttons! -->
<?php 						foreach($options[$poll->id] as $option)
							{	?>
								<input type="radio" name="option_id" value="<?= $option->id ?>" />
								<label for="vote"><?= $option->name ?></label>
<?php						}	?>
						</div>
						<!-- this tells us which poll is being voted on -->
						<input type="hidden" name="poll_id" value="<?= $poll->id ?>" />
						<button type="submit" class="btn btn-primary pull-right">submit</button>
					</form>
				</div>
				<div id="results_poll_<?= $poll->id ?>">
					<?=	print_results_table($options[$poll->id]) ?>
				</div>
			</div>
<?php	}	?>
	</div>
</body>
</html>