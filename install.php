<?php
require_once 'lib/common.php';

function installBlog()
{
	// Get the PDO DSN string
	$root = getRootPath();
	$database = getDatabasePath();

	$error = '';

	// A security measure, to avoid anyone resetting the database if it already exists
	if (is_readable($database))
	{
		$error = 'Please delete the existing database manually before installing it afresh';
	}

	// Create an empty file for the database
	if (!$error)
	{
		$createdOk = @touch($database);
		if (!$createdOk)
		{
			$error = sprintf(
				'Could not create the database, please allow the server to create new files in \'%s\'',
				dirname($database)
			);
		}
	}

	// Grab the SQL commands we want to run on the database
	if (!$error)
	{
		$sql = file_get_contents($root . '/data/init.sql');

		if ($sql === false)
		{
			$error = 'Cannot find SQL file';
		}
	}

	// Connect to the new database and try to run the SQL commands
	if (!$error)
	{
		$pdo = getPDO();
		$result = $pdo->exec($sql);
		if ($result === false)
		{
			$error = 'Could not run SQL: ' . print_r($pdo->errorInfo(), true);
		}
	}

	// See how many rows we created, if any
	$count = array();

	foreach(array('post', 'comment') as $tableName)
	{
		if (!$error)
		{
			$sql = "SELECT COUNT(*) AS c FROM " . $tableName;
			$stmt = $pdo->query($sql);
			if ($stmt)
			{
				// We store each count in an associative array
				$count[$tableName] = $stmt->fetchColumn();
			}
		}
	}

	return array($count, $error);
}

// We store stuff in the session, to survive the redirect to self
session_start();

// Only run the installer when we're responding to the form
if ($_POST)
{
	// Here's the install
	list($_SESSION['count'], $_SESSION['error']) = installBlog();

	// ... and here we redirect from POST to GET
	redirectAndExit('install.php');
}

// Let's see if we've just installed
$attempted = false;
if ($_SESSION)
{
	$attempted = true;
	$count = $_SESSION['count'];
	$error = $_SESSION['error'];

	// Unset session variables, so we only report the install/failure once
	unset($_SESSION['count']);
	unset($_SESSION['error']);
}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Blog installer</title>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		<style type="text/css">
			.box {
				border: 1px dotted silver;
				border-radius: 5px;
				padding: 4px;
			}
			.error {
				background-color: #ff6666;
			}
			.success {
				background-color: #88ff88;
			}
		</style>
	</head>
	<body>
		<?php if ($attempted): ?>

			<?php if ($error): ?>
				<div class="error box">
					<?php echo $error ?>
				</div>
			<?php else: ?>
				<div class="success box">
					The database and demo data was created OK.

					<?php foreach (array('post', 'comment') as $tableName): ?>
						<?php if (isset($count[$tableName])): ?>
							<?php // Prints the count ?>
							<?php echo $count[$tableName] ?> new
							<?php // Prints the name of the thing ?>
							<?php echo $tableName ?>s
							were created.
						<?php endif ?>
					<?php endforeach ?>
				</div>

				<p>
					<a href="index.php">View the blog</a>,
					or <a href="install.php">install again</a>.
				</p>
			<?php endif ?>

		<?php else: ?>

			<p>Click the install button to reset the database.</p>

			<form method="post">
				<input
					name="install"
					type="submit"
					value="Install"
				/>
			</form>

		<?php endif ?>
	</body>
</html>