<?php

/**
 * Gets the root path of the project
 * 
 * @return string
 */
function getRootPath()
{
	return realpath(__DIR__ . '/..');
}

/**
 * Gets the full path for the database file
 * 
 * @return string
 */
function getDatabasePath()
{
	return getRootPath() . '/data/data.sqlite';
}

/**
 * Gets the DSN for the SQLite connection
 * 
 * @return string
 */
function getDsn()
{
	return 'sqlite:' . getDatabasePath();
}

/**
 * Gets the PDO object for database acccess
 * 
 * @return \PDO
 */
function getPDO()
{
	return new PDO(getDsn());
}

function convertSqlDate($sqlDate)
{
	/* @var $date DateTime */
	$date = DateTime::createFromFormat('Y-m-d', $sqlDate);

	return $date->format('d M Y');
}

/**
 * Returns the number of comments for the specified post
 * 
 * @param integer $postId
 * @return integer
 */
function countCommentsForPost($postId)
{
	$pdo = getPDO();
	$sql = "
		SELECT
			COUNT(*) c
		FROM
			comment
		WHERE
			post_id = :post_id
	";
	$stmt = $pdo->prepare($sql);
	$stmt->execute(
		array('post_id' => $postId, )
	);

	return (int) $stmt->fetchColumn();
}

/**
 * Returns all the comments for the specified post
 * 
 * @param integer $postId
 */
function getCommentsForPost($postId)
{
	$pdo = getPDO();
	$sql = "
		SELECT
			id, name, text, created_at, website
		FROM
			comment
		WHERE
			post_id = :post_id
	";
	$stmt = $pdo->prepare($sql);
	$stmt->execute(
		array('post_id' => $postId, )
	);

	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
