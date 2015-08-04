<?php
session_start();
require 'db.php';
try{
	gen_db();
}catch(Exception $e){
	echo 'Error, ', $e->getMessage();
}

if(isset($_POST['type']) && $_POST['type'] === 'add_company'){
	add_company($_POST['co_name'],$_POST['co_size'],$_POST['co_profit']);
}
if(isset($_POST['type']) && $_POST['type'] === 'add_sector'){
	add_sector($_POST['sector_name'],$_POST['sector_description']);
}
if(isset($_POST['type']) && $_POST['type'] === 'search_company_location'){
	$result = search_company_location($_POST['name'],$_POST['location']);
	echo $result;
}
if(isset($_POST['type']) && $_POST['type'] === 'search_job_location'){
	$result = search_job_location($_POST['name'],$_POST['location']);
	echo $result;
}
?>
