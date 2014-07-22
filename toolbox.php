<?php 
include "../inc/database.php";

if (isset($_GET['action']) && $_GET['action'] !== '') {
	if (function_exists($_GET['action'])) {
		try {
			$_GET['action']();
		} catch (Exception $e) {
			echo '{"error":true,"desc":"Exception in: Get:[' . $_GET['action'] . '] with message: ' . $e->getMessage() . '"}';
		}
	} else {
		echo '{"error":true,"desc":"Exception: Get->Function->' . $_GET['action'] . ', Do not exists"}';
	}
}

function getResults()
{
	$query = file_get_contents('query.sql');
	$DB = new MxOptix();
	$DB->setQuery($query);
	$DB->bind_vars(':serial_num',$_GET['serial_num']);
	// echo $DB->query;
	$DB->exec();
	if ($DB->json() == "[]") {
		echo '[{"JOB":"' . $_GET['serial_num'] . '"}]';
	} else {
		echo $DB->json();
	}
}

function getLPN()
{
	$query = file_get_contents('selectByLPN.sql');
	$DB = new MxOptix();
	$DB->setQuery($query);
	$DB->bind_vars(':lpn',$_GET['lpn']);
	// echo $DB->query;
	$DB->exec();
	if ($DB->json() == "[]") {
		echo '[{"LPN":"' . $_GET['lpn'] . '"}]';
	} else {
		echo $DB->json();
	}
}