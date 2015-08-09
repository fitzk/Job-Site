
<?php
session_start();
require 'db.php';
require 'insert_db.php';

try {
	gen_db();
}

catch(Exception $e) {
	echo 'Error, ', $e->getMessage();
}

if (isset($_POST['type']) && $_POST['type'] === 'add_job') {
	$result = add_job($_POST['name'], $_POST['salary'], $_POST['company'], $_POST['location']);
	echo $result;
}

if (isset($_POST['type']) && $_POST['type'] === 'add_company') {
	$result = add_company($_POST['name'], $_POST['size'], $_POST['profit'], $_POST['stock']);
	echo $result;

	foreach($_POST['cities'] as $city) {
		try {
			echo insert_company_city($_POST['name'], $city);
		}catch(Exception $e) {
			echo 'Error, ', $e->getMessage();
		}
	}

	foreach($_POST['sectors'] as $sector) {
		try {
			echo insert_company_sector($_POST['name'], $sector);
		}catch(Exception $e) {
			echo 'Error, ', $e->getMessage();
		}
	}
	foreach($_POST['cities'] as $city) {
		foreach($_POST['sectors'] as $sector) {
			try {
					echo insert_city_sector($city, $sector);
			}catch(Exception $e) {
					echo 'Error, ', $e->getMessage();
			}
		}
	}
}

if (isset($_POST['type']) && $_POST['type'] === 'add_sector') {
	echo add_sector($_POST['sector_name'], $_POST['sector_description']);
}

?>
