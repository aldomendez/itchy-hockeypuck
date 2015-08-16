<?php 


ini_set('display_errors','On');
ini_set('display_startup_errors','On');
error_reporting(E_ALL|E_STRICT);
// error_reporting(-1);


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

function serveCached($kind)
{
	/*
	 * Busca el archivo correspondiente y revisa que sea el actualizado
	 */
	if (file_exists(getFilename($kind)) ) {
		return true;
	} else {;
		return false;
	}
}

function getFilename($kind)
{
	$family = $_GET['family'];
	$day = date('d');
	$month = date('m');
	$hour = date('H');
	if (!is_dir("cache/")) {
		mkdir("cache/");
	}
	if (!is_dir("cache/" . $month)) {
		mkdir("cache/ . $month");
	}
	if (!is_dir("cache/{$month}")) {
		mkdir("cache/{$month}");
	}
	if (!is_dir("cache/{$month}/{$day}")) {
		mkdir("cache/{$month}/{$day}");
	}
	$filename = "cache/{$month}/{$day}/{$family}.{$kind}.{$hour}";
	return $filename;
}

function getSummary()
{
	$family = $_GET['family'];
	if (!isset($_GET['family'])) {
		throw new Exception("No se especifico [family]");
	}

	date_default_timezone_set("America/Monterrey");

	if ( serveCached('summary') ) {
		echo file_get_contents(getFilename('summary'));
	} else {
		$query = file_get_contents('sql/summary.sql');
		$DB = new MxOptix();
		$DB->setQuery($query);
		$DB->bind_vars(':family',$family);
		$DB->exec();
		file_put_contents(getFilename('summary'), $DB->json());
		echo $DB->json();
	}
}


function getSpecific()
{
	$family = $_GET['family'];
	if (!isset($_GET['family'])) {
		throw new Exception("No se especifico [family]");
	}
	
	date_default_timezone_set("America/Monterrey");
	
	if ( serveCached('specific') ) {
		echo file_get_contents(getFilename('specific'));
	} else {
		$query = file_get_contents('sql/specific.sql');
		$DB = new MxOptix();
		$DB->setQuery($query);
		$DB->bind_vars(':family',$family);
		$DB->exec();
		file_put_contents(getFilename('specific'), $DB->json());
		echo $DB->json();
	}
}

