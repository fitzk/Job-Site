
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
			$result = insert_company_city($_POST['name'], $city);
		}catch(Exception $e) {
			echo 'Error, ', $e->getMessage();
		}
	}

	foreach($_POST['sectors'] as $sector) {
		try {
			$result = insert_company_sector($_POST['name'], $sector);
		}catch(Exception $e) {
			echo 'Error, ', $e->getMessage();
		}
	}
	foreach($_POST['cities'] as $city) {
		foreach($_POST['sectors'] as $sector) {
			try {
					$result = insert_city_sector($city, $sector);
			}catch(Exception $e) {
					echo 'Error, ', $e->getMessage();
			}
		}
	}
}


if (isset($_POST['type']) && $_POST['type'] === 'add_sector') {
  $name = $_POST['sector_name'];
	$lname = strtolower($name);
	$current_sectors = json_decode(sector(),'true');
	$response= array("response"=>array(
      "code"=>"400",
      "comment"=> "$name already exists in the database.\n"
    )
  );
$sent = 'false';
	foreach($current_sectors['data'] as $sector){
		foreach($sector as $s){
			$sl = strtolower($s);
			if($lname === $sl){
				echo json_encode($response);
				$sent = 'true';
		}
	}
	}
	if($sent ==='false'){
		$result = add_sector($_POST['sector_name'], $_POST['sector_description']);
		echo $result;
	}
}
////////////////////////////////////////////////////////////
// add city
//
////////////////////////////////////////////////////////////
if (isset($_POST['type']) && $_POST['type'] === 'add_city') {
  $name = $_POST['name'];
	$lname = strtolower($name);
	$current_cities = json_decode(city(),'true');
	$response= array("response"=>array(
      "code"=>"400",
      "comment"=> "$name already exists in the database.\n"
    )
  );
$sent = 'false';
	foreach($current_cities['data'] as $city){
		foreach($city as $c){
			$cl = strtolower($c);
			if($lname === $cl){
				echo json_encode($response);
				$sent = 'true';
		}
	}
	}
	if($sent ==='false'){
 		$result = add_city($_POST['name']);
		echo $result;
	}
}
?>
