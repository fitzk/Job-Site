<?php

// function connectToServer(){
//     $dbhost = 'oniddb.cws.oregonstate.edu';
//     $dbname = 'fitzsimk-db';
//     $dbuser = 'fitzsimk-db';
//     $dbpass = 'VTUimCiHBfyC8P5P';
//     $mysqli = new mysqli($dbhost, $dbname, $dbpass, $dbuser);
//     if (mysqli_connect_errno())
//       {
//         echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
//       }
//     return $mysqli;
//  }
function connectToServer(){
    $dbhost = 'localhost';
    $dbname = 'jobsite';
    $dbuser = 'root';
    $dbpass = '';
    $mysqli = new mysqli($dbhost, $dbuser,$dbpass,$dbname);
    if (mysqli_connect_errno())
      {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
      }
    return $mysqli;
 }
function gen_tables(){
  $mysqli = connectToServer();

  $company = "CREATE TABLE IF NOT EXISTS company(
	co_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	co_name VARCHAR(255) NOT NULL UNIQUE,
	co_size VARCHAR(255),
	co_profit VARCHAR(255))";

	$sector = "CREATE TABLE IF NOT EXISTS sector(
	sector_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	sector_name VARCHAR(255) NOT NULL UNIQUE,
	sector_description VARCHAR(255))";

/* 	$city = "CREATE TABLE IF NOT EXISTS cityk(
	city_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	city_name VARCHAR(255) NOT NULL UNIQUE)";

	$co_city = "CREATE TABLE IF NOT EXISTS company-cityk(
	city_id INT(6),
	co_id INT(6),
	PRIMARY KEY (co_id),
	CONSTRAINT fk_city FOREIGN KEY (city_id)
	REFERENCES city(city_id),
	CONSTRAINT fk_company FOREIGN KEY (co_id)
	REFERENCES company(co_id))";
	 */

  $mysqli->query($company);
	$mysqli->query($sector);

	/* 	if (!$mysqli->query($city))
    {
        echo "city not created";
    }

		if (!$mysqli->query($co_city))
    {
        echo "co-city not created";
    } */
    $mysqli->close();
}

 function add_company($co_name, $co_size, $co_profit){
    $mysqli = connectToServer();
    if (!($stmt = $mysqli->prepare("INSERT INTO company(co_name,co_size,co_profit) VALUES (?,?,?)")))
      {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
      }
    if (!$stmt->bind_param("sss",$co_name, $co_size, $co_profit))
      {
        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
      }
    if (!$stmt->execute())
      {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
      }
    $mysqli->close();
 }
function add_sector($sector_name, $sector_description){
    $mysqli = connectToServer();
    if (!($stmt = $mysqli->prepare("INSERT INTO sector(sector_name,sector_description) VALUES (?,?)")))
      {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
      }
    if (!$stmt->bind_param("ss",$sector_name, $sector_description))
      {
        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
      }
    if (!$stmt->execute())
      {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
      }
    $mysqli->close();
 }
 function add_employee($employee_title, $employee_salary)
{
    $mysqli = connectToServer();
    if (!($stmt = $mysqli->prepare("INSERT INTO company(sector_name,sector_description) VALUES (?,?)")))
      {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
      }
    if (!$stmt->bind_param("ss",$sector_name, $sector_description))
      {
        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
      }
    if (!$stmt->execute())
      {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
      }
    $mysqli->close();
 }



?>
