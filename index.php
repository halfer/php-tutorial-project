<?php

// Work out the path to the database, so SQLite/PDO can connect
$root = __DIR__;
$database = $root . '/data/data.sqlite';
$dsn = 'sqlite:' . $database;

// Connect to the database, run a query, handle errors
$pdo = new PDO($dsn);
$stmt = $pdo->query(
	'SELECT
		id, title, created_at, body
	FROM
		post
	ORDER BY
		created_at DESC'
);
if ($stmt === false)
{
	throw new Exception('There was a problem running this query');
}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>A blog application</title>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	</head>
	<body>
		<h1>Blog title</h1>
		<p>This paragraph summarises what the blog is about.</p>

		<?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
			<h2>
				<?php echo htmlspecialchars($row['title']) ?>
			</h2>
			<div>
				<?php echo $row['created_at'] ?>
			</div>
			<p>
				<?php echo htmlspecialchars($row['body']) ?>
			</p>
			<p>
				<a
					href="view-post.php?post_id=<?php echo $row['id'] ?>"
				>Read more...</a>
			</p>
		<?php endwhile ?>

	</body>
</html>
