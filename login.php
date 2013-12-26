<!DOCTYPE html>
<html>
	<head>
		<title>
			A blog application | Login
		</title>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	</head>
	<body>
		<?php require 'templates/title.php' ?>

		<p>Login here:</p>
		
		<form
			method="post"
		>
			<p>
				Username:
				<input type="text" name="username" />
			</p>
			<p>
				Password:
				<input type="password" name="password" />
			</p>
			<input type="submit" name="submit" value="Login" />
		</form>
	</body>
</html>