<?php

/**
 * Tries to delete the specified post
 * 
 * We first delete the comments attached to the post, and then delete the post itself
 * 
 * @param PDO $pdo
 * @param integer $postId
 * @return boolean Returns true on successful deletion
 * @throws Exception
 */
function deletePost(PDO $pdo, $postId)
{
	$sqls = array(
		// Delete comments first, to remove the foreign key objection
		"DELETE FROM
			comment
		WHERE
			post_id = :id",
		// Now we can delete the post
		"DELETE FROM
			post
		WHERE
			id = :id",
	);

	foreach ($sqls as $sql)
	{
		$stmt = $pdo->prepare($sql);
		if ($stmt === false)
		{
			throw new Exception('There was a problem preparing this query');
		}

		$result = $stmt->execute(
			array('id' => $postId, )
		);

		// Don't continue if something went wrong
		if ($result === false)
		{
			break;
		}
	}

	return $result !== false;
}
