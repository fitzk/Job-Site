<?php

// ///////////////////////////////////////
//
//
// ///////////////////////////////////////
function insert_company_city($company, $city)
{
	$mysqli = connectToServer();
  $response= array(
    "response"=>array(
			array(
      "code"=>"200",
      "comment"=> "Successfuly associated $company with $city.\n"
    )
		)
  );
	if (!($stmt = $mysqli->prepare("INSERT IGNORE INTO company_city(company_id,city_id)
  VALUES((SELECT company_id from company where company_name = ?),(SELECT city_id from city WHERE city_name = ?));"))) {
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}

	if (!$stmt->bind_param("ss", $company, $city)) {
		echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	if (!$stmt->execute()) {
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    $response['response']['code']="400";
    $response['response']['comment']="Insert failed, please try again.";
	}
	else {

		$myfile = fopen("populate_db.sql", "a") or die("Unable to open file!");
		$txt = "INSERT IGNORE INTO company_city(company_id,city_id) VALUES((SELECT company_id from company where company_name = '$company'),(SELECT city_id from city WHERE city_name = '$city'));\n";
		fwrite($myfile, $txt);
		fclose($myfile);

	}
  return json_encode($response);
	$mysqli->close();
}

// ///////////////////////////////////////
//
//
// //////////////////////////////////////
function insert_city_sector($city, $sector)
{
	$mysqli = connectToServer();
  $response= array(
    "response"=>array(array(
      "code"=>"200",
      "comment"=> "Successfuly associated $city with $sector.\n"
    )
		)
  );
	if (!($stmt = $mysqli->prepare("INSERT IGNORE INTO city_sector(city_id,sector_id)
  VALUES((SELECT city_id from city WHERE city_name = ?),(SELECT sector_id from sector WHERE sector_name = ?));")))
	{
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}

	if (!$stmt->bind_param("ss", $city, $sector)) {
		echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	if (!$stmt->execute()) {
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    $response['response']['code']="400";
    $response['response']['comment']="Insert failed, please try again.";
	}
	else {
		$myfile = fopen("populate_db.sql", "a") or die("Unable to open file!");
		$txt = "INSERT IGNORE INTO city_sector(city_id,sector_id) VALUES((SELECT city_id from city where city_name = '$city'),(SELECT sector_id from sector WHERE sector_name = '$sector'));\n";
		fwrite($myfile, $txt);
		fclose($myfile);
	}
  return json_encode($response);
	$mysqli->close();
}
// ///////////////////////////////////////
//
//
// //////////////////////////////////////
function insert_company_sector($company, $sector)
{
	$mysqli = connectToServer();
  $response= array(
    "response"=>array(
      "code"=>"200",
      "comment"=> "Successfuly associated $company with $sector.\n"
	)
);
	if (!($stmt = $mysqli->prepare("INSERT IGNORE INTO company_sector(company_id,sector_id)
  VALUES((SELECT company_id from company where company_name = ?),
  (SELECT sector_id from sector WHERE sector_name = ?));"))) {
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}

	if (!$stmt->bind_param("ss", $company, $sector)) {
		echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	if (!$stmt->execute()) {
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    $response['response']['code']="400";
    $response['response']['comment']="Insert failed, please try again.";
	}
	else {
		$myfile = fopen("populate_db.sql", "a") or die("Unable to open file!");
		$txt = "INSERT IGNORE INTO company_sector(company_id,sector_id) VALUES((SELECT company_id from company where company_name = '$company'),(SELECT sector_id from sector WHERE sector_name = '$sector'));\n";
		fwrite($myfile, $txt);
		fclose($myfile);
	}
  return json_encode($response);
	$mysqli->close();
}

function add_sector($sector_name, $sector_description)
{
	$mysqli = connectToServer();
  $response= array(
    "response"=>array(
      "code"=>"200",
      "comment"=> "Successfuly added $sector_name.\n"
    )
  );
	if (!($stmt = $mysqli->prepare("INSERT INTO sector(sector_name,sector_description) VALUES (?,?)"))) {
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}

	if (!$stmt->bind_param("ss", $sector_name, $sector_description)) {
		echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	if (!$stmt->execute()) {
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    $response['response']['code']="400";
    $response['response']['comment']="Insert failed, please try again.";
	}else {
		$myfile = fopen("populate_db.sql", "a") or die("Unable to open file!");
		$txt = "INSERT INTO sector(sector_name,sector_description) VALUES ($sector_name,$sector_description)\n";
		fwrite($myfile, $txt);
		fclose($myfile);
	}
  return json_encode($response);
	$mysqli->close();
}

// //////////////////////////////////////////////////////
// fucntion: add job
// takes job title, salary, company, and city
// returns message if successful
// /////////////////////////////////////////////////////

function add_job($job_title, $job_salary, $company_name, $city)
{
	$mysqli = connectToServer();
  $response= array("response"=>array(
      "code"=>"200",
      "comment"=> "Successfuly added $job_title.\n"
    )
  );
	if (!($stmt = $mysqli->prepare("INSERT IGNORE INTO job(job_title,job_salary,company_id,city_id)
    VALUES (?,?,(SELECT company_id from company where company_name = ?),
    (SELECT city_id from city WHERE city_name = ?));"))) {
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}

	if (!$stmt->bind_param("ssss", $job_title, $job_salary, $company_name, $city)) {
		echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	if (!$stmt->execute()) {
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    $response['response']['code']="400";
    $response['response']['comment'] = "Insert failed, please try again.";
	}else {
		$myfile = fopen("populate_db.sql", "a") or die("Unable to open file!");
		$txt = "INSERT IGNORE INTO job(job_title,job_salary,company_id,city_id) VALUES ('$job_title','$job_salary',(SELECT company_id from company where company_name = '$company_name'), SELECT city_id from city WHERE city_name = '$city'));\n";
		fwrite($myfile, $txt);
		fclose($myfile);
	}
	$mysqli->close();
  return json_encode($response);

}
// //////////////////////////////////////////////////////
// fucntion: add job
// takes job title, salary, company, and city
// returns message if successful
// /////////////////////////////////////////////////////

function add_city($city_name)
{
	$mysqli = connectToServer();
  $response= array("response"=>array(
      "code"=>"200",
      "comment"=> "Successfuly added $city_name.\n"
    )
  );
	if (!($stmt = $mysqli->prepare("INSERT IGNORE INTO city(city_name)
    VALUES (?);"))) {
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}

	if (!$stmt->bind_param("s", $city_name)) {
		echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	if (!$stmt->execute()) {
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    $response['response']['code']="400";
    $response['response']['comment'] = "Insert failed, please try again.";
	}else {
		$myfile = fopen("populate_db.sql", "a") or die("Unable to open file!");
		$txt = "INSERT IGNORE INTO city(city_name) VALUES ($city_name);\n";
		fwrite($myfile, $txt);
		fclose($myfile);
	}
	$mysqli->close();
  return json_encode($response);
}


// ///////////////////////////////////////
//
//
// /////////////////////////////////////////

function add_company($name, $size, $profit, $stock)
{
	$mysqli = connectToServer();
  $response= array(
    "response"=>array(
      "code"=>"200",
      "comment"=> "Successfully added $name.\n"
		)
  );
	if (!($stmt = $mysqli->prepare("INSERT IGNORE INTO company(company_name,company_size,company_profit,company_stock_symbol) VALUES (?,?,?,?);" ))) {
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}

	if (!$stmt->bind_param("ssss", $name, $size, $profit, $stock)) {
		echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	if (!$stmt->execute()) {
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    $response['response']['code']="400";
    $response['response']['comment']="Insert failed, please try again.";
	}
	else {
		$myfile = fopen("populate_db.sql", "a") or die("Unable to open file!");
		$txt = "INSERT IGNORE INTO company(company_name,company_size,company_profit,company_stock_symbol) VALUES ('$name', '$size','$profit','$stock');\n";
		fwrite($myfile, $txt);
		fclose($myfile);
	}
	$mysqli->close();
	return json_encode($response);
}

function gen_db()
{
	$mysqli = connectToServer();

	$company = "CREATE TABLE IF NOT EXISTS company(
  company_id INT(6) AUTO_INCREMENT PRIMARY KEY NOT NULL,
 	company_name VARCHAR(255) NOT NULL UNIQUE,
 	company_size VARCHAR(255),
 	company_profit VARCHAR(255),
  company_stock_symbol VARCHAR(15))";
  $sector = "CREATE TABLE IF NOT EXISTS sector(
 	sector_id INT(6)AUTO_INCREMENT PRIMARY KEY NOT NULL,
 	sector_name VARCHAR(255) NOT NULL UNIQUE,
 	sector_description VARCHAR(255))";
  $job = "CREATE TABLE IF NOT EXISTS job(
  job_id INT(6)AUTO_INCREMENT PRIMARY KEY NOT NULL,
  job_title VARCHAR(255) NOT NULL,
  job_salary INT(15),
  company_id INT(6),
  city_id INT(6),
  CONSTRAINT FOREIGN KEY(company_id)
  REFERENCES company(company_id) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT FOREIGN KEY(city_id)
  REFERENCES city(city_id) ON DELETE SET NULL ON UPDATE CASCADE)";
  $city = "CREATE TABLE IF NOT EXISTS city(
 	city_id INT(6) AUTO_INCREMENT PRIMARY KEY NOT NULL,
 	city_name VARCHAR(255) NOT NULL UNIQUE)";
  $co_city = "CREATE TABLE IF NOT EXISTS company_city(
 	city_id INT(6),
  company_id INT(6),
 	CONSTRAINT FOREIGN KEY(city_id)
 	REFERENCES city(city_id) ON DELETE SET NULL ON UPDATE CASCADE,
 	CONSTRAINT FOREIGN KEY(company_id)
 	REFERENCES company(company_id) ON DELETE SET NULL ON UPDATE CASCADE)";
  $company_sector = "CREATE TABLE IF NOT EXISTS company_sector(
  company_id INT(6),
  sector_id INT(6),
  CONSTRAINT FOREIGN KEY(company_id)
  REFERENCES company(company_id) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT FOREIGN KEY(sector_id)
  REFERENCES sector(sector_id) ON DELETE SET NULL ON UPDATE CASCADE)";
  $city_sector = "CREATE TABLE IF NOT EXISTS city_sector(
  city_id INT(6),
  sector_id INT(6),
  CONSTRAINT FOREIGN KEY(city_id)
  REFERENCES city(city_id) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT FOREIGN KEY(sector_id)
  REFERENCES sector(sector_id) ON DELETE SET NULL ON UPDATE CASCADE)";
	if (!$mysqli->query($company)) {
		throw new Exception('company table not created');
	}

	if (!$mysqli->query($sector)) {
		throw new Exception('sector table not created');
	}

	if (!$mysqli->query($city)) {
		throw new Exception('city table not created');
	}
  if (!$mysqli->query($co_city)) {
    throw new Exception('co_city table not created');
  }

  if (!$mysqli->query($company_sector)) {
    throw new Exception('company_sector table not created ');
  }

  if (!$mysqli->query($job)) {
    throw new Exception('job table not created ');
  }

  $mysqli->close();
  }
  ?>
