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
    if (mysqli_connect_errno()){ echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;}
    return $mysqli;
 }

 function add_company($co_name, $co_size, $co_profit){
    $mysqli = connectToServer();
    if (!($stmt = $mysqli->prepare("INSERT INTO company(co_name,co_size,co_profit) VALUES (?,?,?)"))){echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;}
    if (!$stmt->bind_param("sss",$co_name, $co_size, $co_profit)){echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;}
    if (!$stmt->execute()){echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;}
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
 function gen_tables(){
     $mysqli = connectToServer();

  $company = "CREATE TABLE IF NOT EXISTS company(
 	co_id INT(6) AUTO_INCREMENT PRIMARY KEY NOT NULL,
 	co_name VARCHAR(255) NOT NULL UNIQUE,
 	co_size VARCHAR(255),
 	co_profit VARCHAR(255))";

 	$sector = "CREATE TABLE IF NOT EXISTS sector(
 	sector_id INT(6)AUTO_INCREMENT PRIMARY KEY NOT NULL,
 	sector_name VARCHAR(255) NOT NULL UNIQUE,
 	sector_description VARCHAR(255))";

  $employee = "CREATE TABLE IF NOT EXISTS employee(
  employee_id INT(6)AUTO_INCREMENT PRIMARY KEY NOT NULL,
  employee_title VARCHAR(255) NOT NULL UNIQUE,
  employee_salary VARCHAR(255),
  co_id INT(6),
  CONSTRAINT FOREIGN KEY(co_id)
  REFERENCES company(co_id) ON DELETE SET NULL ON UPDATE CASCADE)";

  $city = "CREATE TABLE IF NOT EXISTS city(
 	city_id INT(6) AUTO_INCREMENT PRIMARY KEY NOT NULL,
 	city_name VARCHAR(255) NOT NULL UNIQUE)";

 	$co_city = "CREATE TABLE IF NOT EXISTS company_city(
 	city_id INT(6),
  co_id INT(6),
 	CONSTRAINT FOREIGN KEY(city_id)
 	REFERENCES city(city_id) ON DELETE SET NULL ON UPDATE CASCADE,
 	CONSTRAINT FOREIGN KEY(co_id)
 	REFERENCES company(co_id) ON DELETE SET NULL ON UPDATE CASCADE)";

  $company_sector = "CREATE TABLE IF NOT EXISTS company_sector(
  co_id INT(6),
  sector_id INT(6),
  CONSTRAINT FOREIGN KEY(co_id)
  REFERENCES company(co_id) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT FOREIGN KEY(sector_id)
  REFERENCES sector(sector_id) ON DELETE SET NULL ON UPDATE CASCADE)";

  $city_sector = "CREATE TABLE IF NOT EXISTS city_sector(
  city_id INT(6),
  sector_id INT(6),
  CONSTRAINT FOREIGN KEY(city_id)
  REFERENCES city(city_id) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT FOREIGN KEY(sector_id)
  REFERENCES sector(sector_id) ON DELETE SET NULL ON UPDATE CASCADE)";

   if(!$mysqli->query($company)){ throw new Exception('company table not created'); }
 	 if(!$mysqli->query($sector)){  throw new Exception('sector table not created');  }
   if(!$mysqli->query($city)){  throw new Exception('city table not created');  }
   if(!$mysqli->query($co_city)){ throw new Exception('co_city table not created'); }
   if(!$mysqli->query($company_sector)){ throw new Exception('company_sector table not created ');  }
   if(!$mysqli->query($employee)){ throw new Exception('employee table not created ');  }
   $mysqli->close();
 }


?>
