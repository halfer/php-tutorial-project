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

/**
 * Escapes HTML so it is safe to output
 * 
 * @param string $html
 * @return string
 */
function htmlEscape($html)
{
	return htmlspecialchars($html, ENT_HTML5, 'UTF-8');
}

function convertSqlDate($sqlDate)
{
	/* @var $date DateTime */
	$date = DateTime::createFromFormat('Y-m-d H:i:s', $sqlDate);

	return $date->format('d M Y, H:i');
}

function getSqlDateForNow()
{
	return date('Y-m-d H:i:s');
}

/**
 * Converts unsafe text to safe, paragraphed, HTML
 * 
 * @param string $text
 * @return string
 */
function convertNewlinesToParagraphs($text)
{
	$escaped = htmlEscape($text);

	return '<p>' . str_replace("\n", "</p><p>", $escaped) . '</p>';
}

function redirectAndExit($script)
{
	$host = $_SERVER['HTTP_HOST'];
	header('Location: http://' . $host . '/' . $script);
	exit();
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

function tryLogin(PDO $pdo, $username, $password)
{
	$sql = "
		SELECT
			password
		FROM
			user
		WHERE
			username = :username
	";
	$stmt = $pdo->prepare($sql);
	$stmt->execute(
		array('username' => $username, )
	);

	// Get the hash from this row, and use the third-party hashing library to check it
	$hash = $stmt->fetchColumn();
	$success = password_verify($password, $hash);

	return $success;
}

function login($username)
{
	$_SESSION['logged_in_username'] = $username;
}
