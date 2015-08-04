<?php
//SELECT AVG(employee_salary) FROM `employee` INNER JOIN company ON employee.company_id = company.company_id WHERE employee_title = 'Sample Engineer' AND company.company_name = 'Blue Coat';
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
function add_employee($employee_title, $employee_salary){
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

function all_companies_by_location($city_name){
  $mysqli = connectToServer();
  if (!($stmt = $mysqli->prepare("SELECT company.company_name, company.company_size, company.company_profit,
    company.company_stock_symbol FROM company INNER JOIN company_city ON company.company_id = company_city.company_id
    INNER JOIN city ON company_city.city_id = city.city_id WHERE city.city_name = ?;")))
    {
      echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }
  if (!$stmt->bind_param("s",$city_name)){
      echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }
  if (!$stmt->execute())
    {
      echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }else{
      $result = $stmt->get_result();
      if ($result->num_rows > 0)
        {
          $companies = array();
          while ($row = $result->fetch_array(MYSQL_ASSOC))
            {
                  $companies[] = $row;
            }
          $result->close();
          return json_encode($companies);
        }else{
          return "0 results";
        }
    }
    $mysqli->close();
}

function search_company_location($company, $location){
  $mysqli = connectToServer();
  if (!($stmt = $mysqli->prepare("SELECT company.company_name, company.company_size, company.company_profit,
    company.company_stock_symbol FROM company INNER JOIN company_city ON company.company_id = company_city.company_id
    INNER JOIN city ON company_city.city_id = city.city_id WHERE  company.company_name = ? AND city.city_name = ?;")))
    {
      echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }
  if (!$stmt->bind_param("ss",$company,$location)){
      echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }
  if (!$stmt->execute())
    {
      echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }else{
      $result = $stmt->get_result();
      if ($result->num_rows > 0)
        {
          $companies = array();
          while ($row = $result->fetch_array(MYSQL_ASSOC))
            {
                  $companies[] = $row;
            }
          $result->close();
          return json_encode($companies);
        }else{
          return "0 results";
        }
    }
    $mysqli->close();
}
function search_job_location($employee, $location){
  $mysqli = connectToServer();
  if (!($stmt = $mysqli->prepare("SELECT employee.employee_title, company.company_name, employee.employee_salary FROM employee
    INNER JOIN company ON employee.company_id = company.company_id
    INNER JOIN company_city ON company.company_id = company_city.company_id
    INNER JOIN city ON company_city.city_id = city.city_id
    WHERE  employee.employee_title = ? AND city.city_name = ?
    ORDER BY company.company_name;")))
    {
      echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }
  if (!$stmt->bind_param("ss",$employee,$location)){
      echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }
  if (!$stmt->execute())
    {
      echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }else{
      $result = $stmt->get_result();
      if ($result->num_rows > 0)
        {
          $companies = array();
          while ($row = $result->fetch_array(MYSQL_ASSOC))
            {
                  $companies[] = $row;
            }
            //store in object
          $result->close();
          return json_encode($companies);
        }else{
          return "0 results";
        }
    }
    $mysqli->close();
}
function gen_db(){
  $mysqli = connectToServer();
  //$db = "CREATE DATABASE IF NOT EXISTS 'jobsite'";
  $company = "CREATE TABLE IF NOT EXISTS jobsite.company(
 	company_id INT(6) AUTO_INCREMENT PRIMARY KEY NOT NULL,
 	company_name VARCHAR(255) NOT NULL UNIQUE,
 	company_size VARCHAR(255),
 	company_profit VARCHAR(255),
  company_stock_symbol VARCHAR(15))";

 	$sector = "CREATE TABLE IF NOT EXISTS jobsite.sector(
 	sector_id INT(6)AUTO_INCREMENT PRIMARY KEY NOT NULL,
 	sector_name VARCHAR(255) NOT NULL UNIQUE,
 	sector_description VARCHAR(255))";

  $employee = "CREATE TABLE IF NOT EXISTS jobsite.employee(
  employee_id INT(6)AUTO_INCREMENT PRIMARY KEY NOT NULL,
  employee_title VARCHAR(255) NOT NULL,
  employee_salary INT(15),
  company_id INT(6),
  CONSTRAINT FOREIGN KEY(company_id)
  REFERENCES company(company_id) ON DELETE SET NULL ON UPDATE CASCADE)";

  $city = "CREATE TABLE IF NOT EXISTS jobsite.city(
 	city_id INT(6) AUTO_INCREMENT PRIMARY KEY NOT NULL,
 	city_name VARCHAR(255) NOT NULL UNIQUE)";

 	$co_city = "CREATE TABLE IF NOT EXISTS jobsite.company_city(
 	city_id INT(6),
  company_id INT(6),
 	CONSTRAINT FOREIGN KEY(city_id)
 	REFERENCES city(city_id) ON DELETE SET NULL ON UPDATE CASCADE,
 	CONSTRAINT FOREIGN KEY(company_id)
 	REFERENCES company(company_id) ON DELETE SET NULL ON UPDATE CASCADE)";

  $company_sector = "CREATE TABLE IF NOT EXISTS jobsite.company_sector(
  company_id INT(6),
  sector_id INT(6),
  CONSTRAINT FOREIGN KEY(company_id)
  REFERENCES company(company_id) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT FOREIGN KEY(sector_id)
  REFERENCES sector(sector_id) ON DELETE SET NULL ON UPDATE CASCADE)";

  $city_sector = "CREATE TABLE IF NOT EXISTS jobsite.city_sector(
  city_id INT(6),
  sector_id INT(6),
  CONSTRAINT FOREIGN KEY(city_id)
  REFERENCES city(city_id) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT FOREIGN KEY(sector_id)
  REFERENCES sector(sector_id) ON DELETE SET NULL ON UPDATE CASCADE)";

// if(!$mysqli->query($db)){ throw new Exception('jobsite db not created'); }
  if(!$mysqli->query($company)){ throw new Exception('company table not created'); }
 	if(!$mysqli->query($sector)){  throw new Exception('sector table not created');  }
  if(!$mysqli->query($city)){  throw new Exception('city table not created');  }
  if(!$mysqli->query($co_city)){ throw new Exception('co_city table not created'); }
  if(!$mysqli->query($company_sector)){ throw new Exception('company_sector table not created ');  }
  if(!$mysqli->query($employee)){ throw new Exception('employee table not created ');  }
  $mysqli->close();
 }


?>
