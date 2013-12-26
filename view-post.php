<?php
require_once 'lib/common.php';
require_once 'lib/view-post.php';

session_start();

// Get a sanitised post ID
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
	$commentData = array(
		'name' => $_POST['comment-name'],
		'website' => $_POST['comment-website'],
		'text' => $_POST['comment-text'],
	);
	$errors = addCommentToPost(
		$pdo,
		$postId,
		$commentData
	);

	// If there are no errors, redirect back to self and redisplay
	if (!$errors)
	{
		redirectAndExit('view-post.php?post_id=' . $postId);
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
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	</head>
	<body>
		<?php require 'templates/title.php' ?>

		<h2>
			<?php echo htmlspecialchars($row['title']) ?>
		</h2>
		<div>
			<?php echo convertSqlDate($row['created_at']) ?>
		</div>

		<?php // This is already escaped, so doesn't need further escaping ?>
		<?php echo convertNewlinesToParagraphs($row['body']) ?>

		<h3><?php echo countCommentsForPost($postId) ?> comments</h3>

		<?php foreach (getCommentsForPost($postId) as $comment): ?>
			<?php // For now, we'll use a horizontal rule-off to split it up a bit ?>
			<hr />
			<div class="comment">
				<div class="comment-meta">
					Comment from
					<?php echo htmlspecialchars($comment['name']) ?>
					on
					<?php echo convertSqlDate($comment['created_at']) ?>
				</div>
				<div class="comment-body">
					<?php // This is already escaped ?>
					<?php echo convertNewlinesToParagraphs($comment['text']) ?>
				</div>
			</div>
		<?php endforeach ?>

		<?php require 'templates/comment-form.php' ?>
	</body>
</html>
