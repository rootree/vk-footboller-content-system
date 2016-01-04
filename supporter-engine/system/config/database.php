<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * @package  Database
 *
 * Database connection settings, defined as arrays, or "groups". If no group
 * name is used when loading the database library, the group named "default"
 * will be used.
 *
 * Each group can be connected to independently, and multiple groups can be
 * connected at once.
 *
 * Group Options:
 *  benchmark     - Enable or disable database benchmarking
 *  persistent    - Enable or disable a persistent connection
 *  connection    - Array of connection specific parameters; alternatively,
 *                  you can use a DSN though it is not as fast and certain
 *                  characters could create problems (like an '@' character
 *                  in a password):
 *                  'connection'    => 'mysql://dbuser:secret@localhost/kohana'
 *  character_set - Database character set
 *  table_prefix  - Database table prefix
 *  object        - Enable or disable object results
 *  cache         - Enable or disable query caching
 *	escape        - Enable automatic query builder escaping
 */
$config['stuff'] = array
(
	'benchmark'     => TRUE,
	'persistent'    => FALSE,
	'connection'    => array
	(
		'type'     => 'pgsql',
		'user'     => 'postgres',
		'pass'     => '111111',
		'host'     => 'localhost',
		'port'     => '5432',
		'socket'   => FALSE,
		'database' => 'crazy_statistic'
	),
	'character_set' => 'utf8',
	'table_prefix'  => '',
	'object'        => TRUE,
	'cache'         => FALSE,
	'escape'        => TRUE
);
 
$config['default'] = array
(
	'benchmark'     => TRUE,
	'persistent'    => FALSE,
	'connection'    => array
	(
		'type'     => 'mysql',
		'user'     => DB_SUPPORT_USER,
		'pass'     => DB_SUPPORT_PASS,
		'host'     => DB_SUPPORT_HOST,
		'port'     => '3306',
		'socket'   => FALSE,
		'database' => DB_SUPPORT_NAME
	),
	'character_set' => 'utf8',
	'table_prefix'  => '',
	'object'        => TRUE,
	'cache'         => FALSE,
	'escape'        => TRUE
);

$config['pro'] = array
(
	'benchmark'     => TRUE,
	'persistent'    => FALSE,
	'connection'    => array
	(
		'type'     => 'mysql',
		'user'     => DB_USER,
		'pass'     => DB_PASS,
		'host'     => DB_HOST,
		'port'     => '3306',
		'socket'   => FALSE,
		'database' => DB_NAME
	),
	'character_set' => 'utf8',
	'table_prefix'  => '',
	'object'        => TRUE,
	'cache'         => FALSE,
	'escape'        => TRUE
);