<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Poll List</title>
	</head>
	<body>
		<!-- button to add poll -->
		<a href="#">Add a Poll</a>
		<!-- id number of poll -->
		<?php
			foreach ($polls as $poll)
			{
				// echo "<pre>";
				// var_dump($user);
				// echo "</pre>";

		?>
				<h2>ID: <?= $poll->id ?></h2>
		<?php	}
		?>
	</body>
</html>