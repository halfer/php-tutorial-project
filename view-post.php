<?php
require_once 'lib/common.php';
require_once 'lib/view-post.php';

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

// Swap carriage returns for paragraph breaks
$bodyText = htmlspecialchars($row['body']);
$paraText = str_replace("\n", "</p><p>", $bodyText);
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
		<p>
			<?php // This is already escaped, so doesn't need further escaping ?>
			<?php echo $paraText ?>
		</p>

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
					<?php echo htmlspecialchars($comment['text']) ?>
				</div>
			</div>
		<?php endforeach ?>
	</body>
</html>