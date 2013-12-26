<?php
/**
 * @var $errors string
 * @var $commentData array
 */
?>

<?php // Report any errors in a bullet-point list ?>
<?php if ($errors): ?>
	<div class="error box comment-margin">
		<ul>
			<?php foreach ($errors as $error): ?>
				<li><?php echo $error ?></li>
			<?php endforeach ?>
		</ul>
	</div>
<?php endif ?>

<h3>Add your comment</h3>

<form method="post" class="comment-form">
	<div>
		<label for="comment-name">
			Name:
		</label>
		<input
			type="text"
			id="comment-name"
			name="comment-name"
			value="<?php echo htmlspecialchars($commentData['name']) ?>"
		/>
	</div>
	<div>
		<label for="comment-website">
			Website:
		</label>
		<input
			type="text"
			id="comment-website"
			name="comment-website"
			value="<?php echo htmlspecialchars($commentData['website']) ?>"
		/>
	</div>
	<div>
		<label for="comment-text">
			Comment:
		</label>
		<textarea
			id="comment-text"
			name="comment-text"
			rows="8"
			cols="70"
		><?php echo htmlspecialchars($commentData['text']) ?></textarea>
	</div>

	<div>
		<input type="submit" value="Submit comment" />
	</div>
</form>
