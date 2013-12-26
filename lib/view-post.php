<?php

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