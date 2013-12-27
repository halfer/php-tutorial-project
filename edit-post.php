<?php
require_once 'lib/common.php';

session_start();

// Don't let non-auth users see this screen
if (!isLoggedIn())
{
	redirectAndExit('index.php');
}

?>
<html>
	<head>
		<title>A blog application | New post</title>
		<?php require 'templates/head.php' ?>
	</head>
	<body>
		<?php require 'templates/title.php' ?>

		<form method="post" class="post-form user-form">
			<div>
				<label for="post-title">Title:</label>
				<input
					id="post-title"
					name="post-title"
					type="text"
				/>
			</div>
			<div>
				<label for="post-body">Body:</label>
				<textarea
					id="post-body"
					name="post-body"
					rows="12"
					cols="70"
				></textarea>
			</div>
			<div>
				<input
					type="submit"
					value="Submit comment"
				/>
			</div>
		</form>
	</body>
</html>