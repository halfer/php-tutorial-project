<?php

/**
 * Tries to delete the specified post
 * 
 * @param PDO $pdo
 * @param integer $postId
 * @return boolean Returns true on successful deletion
 * @throws Exception
 */
function deletePost(PDO $pdo, $postId)
{
	$sql = "
		DELETE FROM
			post
		WHERE
			id = :id
	";
	$stmt = $pdo->prepare($sql);
	if ($stmt === false)
	{
		throw new Exception('There was a problem preparing this query');
	}

	$result = $stmt->execute(
		array('id' => $postId, )
	);

	return $result !== false;
}
