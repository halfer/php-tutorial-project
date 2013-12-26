/**
 * Database creation script
 */

DROP TABLE IF EXISTS post;

CREATE TABLE post (
	id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
	title VARCHAR NOT NULL,
	body VARCHAR NOT NULL,
	user_id INTEGER NOT NULL,
	created_at VARCHAR NOT NULL,
	updated_at VARCHAR
);

INSERT INTO
	post
	(
		title, body, user_id, created_at
	)
	VALUES(
		"Here's our first post",
		"This is the body of the first post.

It is split into paragraphs.",
		1,
		date('now', '-2 months')
	)
;

INSERT INTO
	post
	(
		title, body, user_id, created_at
	)
	VALUES(
		"Now for a second article",
		"This is the body of the second post.
This is another paragraph.",
		1,
		date('now', '-40 days')
	)
;

INSERT INTO
	post
	(
		title, body, user_id, created_at
	)
	VALUES(
		"Here's a third post",
		"This is the body of the third post.
This is split into paragraphs.",
		1,
		date('now', '-13 days')
	)
;

DROP TABLE IF EXISTS comment;

CREATE TABLE comment (
	id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
	post_id INTEGER NOT NULL,
	created_at VARCHAR NOT NULL,
	name VARCHAR NOT NULL,
	website VARCHAR,
	text VARCHAR NOT NULL
);

INSERT INTO
	comment
	(
		post_id, created_at, name, website, text
	)
	VALUES(
		1,
		date('now', '-10 days'),
		'Jimmy',
		'http://example.com/',
		"This is Jimmy's contribution"
	)
;

INSERT INTO
	comment
	(
		post_id, created_at, name, website, text
	)
	VALUES(
		1,
		date('now', '-8 days'),
		'Jonny',
		'http://anotherexample.com/',
		"This is a comment from Jonny"
	)
;