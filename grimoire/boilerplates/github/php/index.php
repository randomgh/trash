<?php

require_once "GithubWebhook.php";

$endpoint = new GithubWebhook('{project}', '{secret}');

try {
	$endpoint->run();
} catch (Exception $e) {
	header('HTTP/1.1 500 Internal Server Error');
	echo "Error on line {$e->getLine()}: ".htmlSpecialChars($e->getMessage());
	die();
}
