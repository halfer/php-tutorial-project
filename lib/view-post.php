<?php

/**
 * Called to handle the comment form, redirects upon success
 * 
 * @param PDO $pdo
 * @param integer $postId
 * @param array $commentData
 */
function handleAddComment(PDO $pdo, $postId, array $commentData)
{
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

	return $errors;
}

/**
 * Retrieves a single post
 * 
 * @param PDO $pdo
 * @param integer $postId
 * @throws Exception
 */
function getPostRow(PDO $pdo, $postId)
{
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

	return $row;
}

/**
 * Writes a comment to a particular post
 * 
 * @param PDO $pdo
 * @param integer $postId
 * @param array $commentData
 * @return array
 */
function addCommentToPost(PDO $pdo, $postId, array $commentData)
{
	$errors = array();

	// Do some validation
	if (empty($commentData['name']))
	{
		$errors['name'] = 'A name is required';
	}
	if (empty($commentData['text']))
	{
		$errors['text'] = 'A comment is required';
	}

	// If we are error free, try writing the comment
	if (!$errors)
	{
		$sql = "
			INSERT INTO
				comment
			(name, website, text, created_at, post_id)
			VALUES(:name, :website, :text, :created_at, :post_id)
		";
		$stmt = $pdo->prepare($sql);
		if ($stmt === false)
		{
			throw new Exception('Cannot prepare statement to insert comment');
		}

		$result = $stmt->execute(
			array_merge(
				$commentData,
				array('post_id' => $postId, 'created_at' => getSqlDateForNow(), )
			)
		);

		if ($result === false)
		{
			// @todo This renders a database-level message to the user, fix this
			$errorInfo = $pdo->errorInfo();
			if ($errorInfo)
			{
				$errors[] = $errorInfo[2];
			}
		}
	}

	return $errors;
}