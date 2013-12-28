<?php
require_once 'lib/common.php';
require_once 'lib/view-post.php';

session_start();

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
$pdo = getPDO();
$row = getPostRow($pdo, $postId);
$commentCount = $row['comment_count'];

// If the post does not exist, let's deal with that here
if (!$row)
{
	redirectAndExit('index.php?not-found=1');
}

$errors = null;
if ($_POST)
{
	switch ($_GET['action'])
	{
		case 'add-comment':
			$commentData = array(
				'name' => $_POST['comment-name'],
				'website' => $_POST['comment-website'],
				'text' => $_POST['comment-text'],
			);
			$errors = handleAddComment($pdo, $postId, $commentData);
			break;
		case 'delete-comment':
			$deleteResponse = $_POST['delete-comment'];
			handleDeleteComment($pdo, $postId, $deleteResponse);
			break;
	}
}
else
{
	$commentData = array(
		'name' => '',
		'website' => '',
		'text' => '',
	);
}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			A blog application |
			<?php echo htmlEscape($row['title']) ?>
		</title>
		<?php require 'templates/head.php' ?>
	</head>
	<body>
		<?php require 'templates/title.php' ?>

		<div class="post">
			<h2>
				<?php echo htmlEscape($row['title']) ?>
			</h2>
			<div class="date">
				<?php echo convertSqlDate($row['created_at']) ?>
			</div>

			<?php // This is already escaped, so doesn't need further escaping ?>
			<?php echo convertNewlinesToParagraphs($row['body']) ?>
		</div>

		<?php require 'templates/list-comments.php' ?>

		<?php // We use $commentData in this HTML fragment ?>
		<?php require 'templates/comment-form.php' ?>
	</body>
</html>
