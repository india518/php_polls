<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Create a Poll</title>
	<link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="../assets/css/mycss.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div id="wrapper" class="container">
<?php 		
		if ($this->session->userdata("error_messages"))
		{	
			$error_messages = $this->session->userdata("error_messages");
?>
			<div id="display_messages" class="alert alert-block alert-error">
				<p><?= $error_messages["new_poll"] ?></p>
			</div><!-- closes the alert block -->
<?php		
			//We've displayed them, now unset them
			$this->session->unset_userdata("error_messages");
		}	
		else
		{
			$error_messages = FALSE;
		}
?>
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
					<input class="span3" type="text" name="option1" id="option1" />
				</div>
				<div class="controls">
					<input class="span3" type="text" name="option2" id="option2" />
				</div>
				<div class="controls">
					<input class="span3" type="text" name="option3" id="option3" />
				</div>
				<div class="controls">
					<input class="span3" type="text" name="option4" id="option4" />
				</div>
			</div>
			<!-- TODO: Insert link (class="btn btn-danger") to cancel poll -->
			<div class="control-group">
				<div class="controls">
					<!-- href links to the function inside the controller
					we want. TODO: better to use base_url for this? -->
					<a href="index" class="btn btn-danger">Cancel</a>
					<button type="submit" class="btn btn-primary pull-right">Add Poll</button>
				</div>
			</div>
		</form> <!-- End of new poll form -->
	</div>
</body>
</html>