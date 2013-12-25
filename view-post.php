<?php
// Work out the path to the database, so SQLite/PDO can connect
$root = __DIR__;
$database = $root . '/data/data.sqlite';
$dsn = 'sqlite:' . $database;

// Get the post ID
if (isset($_GET['post_id']))
{
	$postId = $_GET['post_id'];
}
else
{
	// So we always have a post ID var defined
	$postId = 0;
}

// Connect to the database, run a query, handle errors
$pdo = new PDO($dsn);
$stmt = $pdo->prepare(
	'SELECT
		title, created_at, body
	FROM
		post
	WHERE
		id = :id'
);
if ($stmt === false)
{
	throw new Exception('There was a problem preparing this query');
}
$result = $stmt->execute(
	array('id' => $postId, )
);
if ($result === false)
{
	throw new Exception('There was a problem running this query');	
}

// Let's get a row
$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			A blog application |
			<?php echo htmlspecialchars($row['title']) ?>
		</title>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	</head>
	<body>
		<?php require 'templates/title.php' ?>

		<h2>
			<?php echo htmlspecialchars($row['title']) ?>
		</h2>
		<div>
			<?php echo $row['created_at'] ?>
		</div>
		<p>
			<?php echo htmlspecialchars($row['body']) ?>
		</p>
	</body>
</html>
