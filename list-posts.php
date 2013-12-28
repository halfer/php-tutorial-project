<?php
require_once 'lib/common.php';

session_start();

// Don't let non-auth users see this screen
if (!isLoggedIn())
{
	redirectAndExit('index.php');
}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>A blog application | Blog posts</title>
		<?php require 'templates/head.php' ?>
	</head>
	<body>
		<?php require 'templates/top-menu.php' ?>

		<h1>Post list</h1>

		<form method="post">
			<table id="post-list">
				<tbody>
					<tr>
						<td>Title of the first post</td>
						<td>
							<a href="edit-post.php?post_id=1">Edit</a>
						</td>
						<td>
							<input
								type="submit"
								name="post[X]"
								value="Delete"
							/>
						</td>
					</tr>
					<tr>
						<td>Title of the second post</td>
						<td>
							<a href="edit-post.php?post_id=2">Edit</a>
						</td>
						<td>
							<input
								type="submit"
								name="post[X]"
								value="Delete"
							/>
						</td>
					</tr>
					<tr>
						<td>Title of the third post</td>
						<td>
							<a href="edit-post.php?post_id=3">Edit</a>
						</td>
						<td>
							<input
								type="submit"
								name="post[X]"
								value="Delete"
							/>
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	</body>
</html>