<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Create a Poll</title>
		<link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div id="wrapper" class="container">
			<form id="add_poll" class="form-horizontal" action="/poll/process_new_poll" method="post">
				<div class="control-group">
					<div class="controls">
						<legend>Add Poll</legend>
					</div>
				</div>
				<div "class=control-group">
					<label class="control-label" for="title">Title:</label>
					<div class="controls">
						<input class="span3" type="text" name="title" id="title" placeholder="Poll Title" />
					</div>
				</div>
				<div "class=control-group">
					<label class="control-label" for="description">Description:</label>
					<div class="controls">
						<textarea class="span3" rows="5" name="description" id="description"></textarea>
					</div>
				</div>
				<div "class=control-group">
					<label class="control-label" for="option1">Options</label>
					<div class="controls">
						<input class="span3" type="text" name="option1" id="option1" />
					</div>
				</div>
					<div class="controls">
						<input class="span3" type="text" name="option2" id="option2" />
					</div>
					<div class="controls">
						<input class="span3" type="text" name="option3" id="option2" />
					</div>
					<div class="controls">
						<input class="span3" type="text" name="option4" id="option2" />
					</div>
				<!-- TODO: Insert link (class="btn btn-danger") to cancel poll -->
				<div class="control-group">
					<div class="controls">
						<input type="hidden" name="action" value="register" />
						<button type="submit" class="btn btn-primary">Add Poll</button>
					</div>
				</div>
			</form> <!-- End of new poll form -->
		</div>
	</body>
</html>