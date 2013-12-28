<?php
/**
 * @var $pdo PDO
 * @var $postId integer
 */
?>
<div class="comment-list">
	<h3><?php echo countCommentsForPost($pdo, $postId) ?> comments</h3>

	<?php foreach (getCommentsForPost($pdo, $postId) as $comment): ?>
		<div class="comment">
			<div class="comment-meta">
				Comment from
				<?php echo htmlEscape($comment['name']) ?>
				on
				<?php echo convertSqlDate($comment['created_at']) ?>
				<?php if (isLoggedIn()): ?>
					<input
						type="submit"
						name="delete-comment[<?php echo $comment['id'] ?>]"
						value="Delete"
					/>
				<?php endif ?>
			</div>
			<div class="comment-body">
				<?php // This is already escaped ?>
				<?php echo convertNewlinesToParagraphs($comment['text']) ?>
			</div>
		</div>
	<?php endforeach ?>
</div>
