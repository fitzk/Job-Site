<?php
session_start();
require 'db.php';
require 'insert_db.php';
try{
	gen_db();
}catch(Exception $e){
	echo 'Error, ', $e->getMessage();
}

if(isset($_GET['type']) && $_GET['type'] === 'get_ave'){
	$result = ave_job();
	echo $result;
}
if(isset($_GET['type']) && $_GET['type'] === 'city'){
	$result = city();
	echo $result;
}
if(isset($_GET['type']) && $_GET['type'] === 'sector'){
	$result = sector();
	echo $result;
}
if(isset($_GET['type']) && $_GET['type'] === 'sector2'){
	$result = sector2();
	echo $result;
}
if(isset($_GET['type']) && $_GET['type'] === 'company_city'){
	$result = company_city($_GET['name'],$_GET['location']);
	echo $result;
}
if(isset($_GET['type']) && $_GET['type'] === 'job_city'){
	$result = job_city($_GET['name'],$_GET['location']);
	echo $result;
}
?>
