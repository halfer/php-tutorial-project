<?php

/**
 * Blog installer function
 * 
 * @return array(count array, error string)
 */
function installBlog(PDO $pdo)
{
	// Get a couple of useful project paths
	$root = getRootPath();
	$database = getDatabasePath();

	$error = '';

	// A security measure, to avoid anyone resetting the database if it already exists
	if (is_readable($database) && filesize($database) > 0)
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