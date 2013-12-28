<div class="top-menu">
	<div class="menu-options">
		<?php if (isLoggedIn()): ?>
			<a href="list-posts.php">All posts</a>
			|
			<a href="edit-post.php">New post</a>
			|
			Hello <?php echo htmlspecialchars(getAuthUser()) ?>.
			<a href="logout.php">Log out</a>
		<?php else: ?>
			<a href="login.php">Log in</a>
		<?php endif ?>
	</div>
</div>