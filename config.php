<?php
require 'environment.php';

define('BASE_URL', 'http://localhost/contaazul');

global $config;
$config = array();

if (ENVIRONMENT == 'development') {
	$config['dbname'] = 'contaazul';
	$config['host']   = '127.0.0.1';
	$config['dbuser'] = 'root';
	$config['dbpass'] = 'root';
} else {
	$config['dbname'] = 'contaazul';
	$config['host']   = '127.0.0.1';
	$config['dbuser'] = 'root';
	$config['dbpass'] = 'root';
}