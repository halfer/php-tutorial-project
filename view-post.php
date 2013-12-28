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
			// Don't do anything if the user is not authorised
			if (isLoggedIn())
			{
				$deleteResponse = $_POST['delete-comment'];
				$keys = array_keys($deleteResponse);
				$deleteCommentId = $keys[0];
				deleteComment($pdo, $postId, $deleteCommentId);
				redirectAndExit('view-post.php?post_id=' . $postId);
			}
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
			<?php echo htmlspecialchars($row['title']) ?>
		</title>
		<?php require 'templates/head.php' ?>
	</head>
	<body>
		<?php require 'templates/title.php' ?>

		<div class="post">
			<h2>
				<?php echo htmlspecialchars($row['title']) ?>
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
