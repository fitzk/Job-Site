<?php
session_start();
require 'db.php';

gen_tables();

if(isset($_POST['type']) && $_POST['type'] === 'initial_search'){
	$result = initial_search($_POST['city_name']);
	echo $result;
} 
if(isset($_POST['type']) && $_POST['type'] === 'add_company'){
	add_company($_POST['co_name'],$_POST['co_size'],$_POST['co_profit']);
}
if(isset($_POST['type']) && $_POST['type'] === 'add_sector'){
	add_sector($_POST['sector_name'],$_POST['sector_description']);
}

?>