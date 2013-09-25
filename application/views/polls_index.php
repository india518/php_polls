<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Poll List</title>
	<script type="text/javascript" src="assets/js/jquery.1_10_2.js"></script>
	<script type="text/javascript" src="assets/js/polls.js"></script>
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

		<form id="add_poll" class="form-horizontal span5" action="/poll/process_poll_form" method="post">
			<div class="control-group">
				<div class="controls">
					<legend class="span3">Add Poll</legend>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="title">Title:</label>
				<div class="controls">
					<input class="span3" type="text" name="title" id="title" placeholder="Poll Title" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="description">Description:</label>
				<div class="controls">
					<textarea class="span3" rows="5" name="description" id="description"></textarea>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="option1">Options</label>
				<div class="controls">
					<input class="span3" type="text" name="options[]" id="option1" />
				</div>
				<div class="controls">
					<input class="span3" type="text" name="options[]" id="option2" />
				</div>
				<div class="controls">
					<input class="span3" type="text" name="options[]" id="option3" />
				</div>
				<div class="controls">
					<input class="span3" type="text" name="options[]" id="option4" />
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<a href="<?= base_url() ?>" class="btn btn-danger">Cancel</a>
					<button type="submit" value="test_value" class="btn btn-primary pull-right">Add Poll</button>
				</div>
			</div>
		</form> <!-- End of new poll form -->
		<div class="clearfix"></div>
		<div id="poll_list">	
<?php 		foreach ($polls as $poll)
			{	?>
				<div class="container">
					<p class="pull-right">ID: <?= $poll['id'] ?></p>
					<div class="well">
						<h4><?= $poll['title'] ?></h4>
						<p><?= $poll['description'] ?></p>
						<form id="poll_<?= $poll['id'] ?>" class="poll_display" action="poll/process_vote" method="post">
							<div class="radio_buttons">
							<!-- TODO: Can we improve the CSS styling on this? -->
							<!-- Look into bootstrap docs on radio buttons! -->
<?php 							foreach($options[$poll['id']] as $option)
								{	?>
									<input type="radio" name="option_id" value="<?= $option['id'] ?>" />
									<label for="vote"><?= $option['name'] ?></label>
<?php							}	?>
							</div>
							<!-- this tells us which poll is being voted on -->
							<input type="hidden" name="poll_id" value="<?= $poll['id'] ?>" />
							<button type="submit" class="btn btn-primary pull-right">submit</button>
						</form>
						<div id="results_poll_<?= $poll['id'] ?>" class="results">
							<?=	print_results_table($options[$poll['id']]) ?>
						</div>
					</div>
				</div>
<?php		}	?>
		</div><!-- End div id="poll_list" -->
	</div>
</body>
</html>