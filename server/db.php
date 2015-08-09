
<?php

// SELECT AVG(job_salary) FROM `job` INNER JOIN company ON job.company_id = company.company_id WHERE job_title = 'Sample Engineer' AND company.company_name = 'Blue Coat';
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
//    return $mysqli;
//  }

function connectToServer()
{
    $dbhost = 'localhost';
    $dbname = 'jobsite';
    $dbuser = 'root';
    $dbpass = '';
    $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }

    return $mysqli;
}

// ///////////////////////////////////////////
// function: all jobs by specific location
//
// ///////////////////////////////////////////

function city_anyjob($city_name)
{
    $mysqli = connectToServer();
    if (!($stmt = $mysqli->prepare("SELECT job.job_title,
    job.job_salary, company.company_name FROM job LEFT JOIN company ON job.company_id = company.company_id
    WHERE job.city_id IN(SELECT city.city_id from city WHERE city.city_name = ?)
    ORDER BY company.company_name LIMIT 10"))) {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }
    if (!$stmt->bind_param("s", $city_name)) {
        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    } else {
        $result    = $stmt->get_result();
        $companies = array(
            "response" => array(
                    "code" => "200",
                    "comment" => "0 Results. Here are some jobs associated with the city you searched for..."
            ),
            "headers" => array(array(

                    "title" => "Job Title",
                    "salary" => "Salary",
                    "company" => "Company"

            )),
            "data" => array()
        );
        if ($result->num_rows > 0) {
            $row_results = array();
            while ($row = $result->fetch_array(MYSQL_ASSOC)) {
                array_push($companies["data"], $row);
            }
        } else {
            $companies["response"]["code"] = "400";
        }
    }
    return json_encode($companies);
    $result->close();
    $mysqli->close();
}
// ///////////////////////////////////////////
// function: location any company
// returns any company for a given location
// ///////////////////////////////////////////

function city_anycompany($city_name)
{
    $mysqli = connectToServer();
    if (!($stmt = $mysqli->prepare("SELECT company.company_name, company.company_size, company.company_profit,
    company.company_stock_symbol,city.city_name FROM company INNER JOIN company_city ON company.company_id = company_city.company_id
    INNER JOIN city ON company_city.city_id = city.city_id WHERE city.city_name = ?;"))) {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }

    if (!$stmt->bind_param("s", $city_name)) {
        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    } else {
        $result    = $stmt->get_result();
        $companies = array(
            "response" => array(
                "code" => "200",
                "comment" => "0 Results. Here are some companies that are associated with the city you searched for..."
            ),
            "headers" => array(
                array(
                    "title" => "Job Title",
                    "salary" => "Salary",
                    "company" => "Company"
                )
            ),
            "data" => array()
        );
        if ($result->num_rows > 0) {
            $row_results = array();
            while ($row = $result->fetch_array(MYSQL_ASSOC)) {
                array_push($companies["data"], $row);
            }
        } else {
            $companies["response"]["code"] = "400";
        }
    }
    return json_encode($companies);
    $result->close();
    $mysqli->close();
}

// ///////////////////////////////////////
// function: company_city
// returns company information and city
// name for a specific company and city
// ///////////////////////////////////////
function company_city($company, $location)
{
    $mysqli = connectToServer();
    if (!($stmt = $mysqli->prepare("SELECT company.company_name, company.company_size, company.company_profit,
    company.company_stock_symbol, city.city_name FROM company INNER JOIN company_city ON company.company_id = company_city.company_id
    INNER JOIN city ON company_city.city_id = city.city_id WHERE  company.company_name = ? AND city.city_name = ?;"))) {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }

    if (!$stmt->bind_param("ss", $company, $location)) {
        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    } else {
        $result    = $stmt->get_result();
        $companies = array(
            "response" => array(

                    "code" => "200",
                    "comment" => ""

            ),
            "headers" => array(
                array(
                    "name" => "Name",
                    "size" => "Number of jobs",
                    "profit" => "Annual Profit",
                    "stock" => "Stock Symbol",
                    "location" => "City"
                )
            ),
            "data" => array(),
            "job_data" => array()
        );
        if ($result->num_rows > 0) {
            $row_results = array();
            while ($row = $result->fetch_array(MYSQL_ASSOC)) {
                array_push($companies["data"], $row);
            }

            $result->close();
            $job_info = json_decode(jobs_company_city($company, $location), 'true');
            array_push($companies["job_data"], $job_info);
            return json_encode($companies);
        } else {
            $mysqli->close();
            $company_by_name        = json_decode(company($company), 'true');
            $all_companies_location = json_decode(city_anycompany($location), 'true');
            if ($company_by_name['response']['code'] === "400" && $all_companies_location['response']['code'] === "400") {
                $companies['response']['code']      = "400";
                $companies["response"]["comments"] = "Error, no company or city was found that matched your search. Please try again.";
                return json_encode($companies);
            } elseif ($all_companies_location['response']['code'] === "400") {
                return json_encode($company_by_name);
            } else {
                return json_encode($all_companies_location);
            }
        }
    }
    $result->close();
    $mysqli->close();
}

//////////////////////////////////////////////
// function: company
// returns the company and city (location)
// for each company that matches the param
/////////////////////////////////////////////
function company($company)
{
    $mysqli = connectToServer();
    if (!($stmt = $mysqli->prepare("SELECT DISTINCT * FROM (SELECT company.company_name, city.city_name FROM company LEFT JOIN company_city
    ON company.company_id=company_city.company_id LEFT JOIN city ON company_city.city_id= city.city_id WHERE company.company_name = ?) a"))) {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }

    if (!$stmt->bind_param("s", $company)) {
        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    } else {
        $companies = array(
            "response" => array(

                    "code" => "200",
                    "comment" => "0 results. Here are the cities associated with the company you searched for..."

            ),
            "headers" => array(
                array(
                    "company" => "Company",
                    "city" => "Locations"
                )
            ),
            "data" => array()
        );
        $result    = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_array(MYSQL_ASSOC)) {
                array_push($companies["data"], $row);
            }
        } else {
            $companies["response"]["code"] = "400";
        }
        $result->close();
    }
    return json_encode($companies);
    $mysqli->close();
}
//////////////////////////////////////////////
// function: jobs_company_city
// returns all jobs given a company and a city
/////////////////////////////////////////////
function jobs_company_city($company, $location)
{
    $mysqli = connectToServer();
    if (!($stmt = $mysqli->prepare("SELECT job.job_title, job.job_salary FROM job WHERE job.city_id
  IN (SELECT city.city_id
  FROM city left JOIN company_city ON city.city_id = company_city.city_id
  left JOIN company ON company.company_id = company_city.company_id
  WHERE city.city_name = ?)
  AND job.company_id
  IN (SELECT company.company_id from company where company.company_name = ?) ORDER BY job.job_salary DESC LIMIT 10;"))) {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }

    if (!$stmt->bind_param("ss", $location, $company)) {
        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    } else {
        $result    = $stmt->get_result();
        $companies = array(
            "response" => array(
                "code" => "200",
                "comment" => "Here are the job titles associated with the company and city you searched for..."
            ),
            "headers" => array(
                array(
                    "title" => "Job Title",
                    "salary" => "Top 10 Salaries"
                )
            ),
            "data" => array()
        );
        if ($result->num_rows > 0) {
            $row_results = array();
            while ($row = $result->fetch_array(MYSQL_ASSOC)) {
                array_push($companies["data"], $row);
            }
        } else {
            $companies["response"]["code"] = "400";
        }
    }
    $result->close();
    return json_encode($companies);
    $mysqli->close();
}
//////////////////////////////////////////////
// funciton: city
// returns all cities
/////////////////////////////////////////////
function city()
{
    $mysqli = connectToServer();
    $sql    = "SELECT city.city_name FROM city ORDER BY `city`.`city_name` ASC";
    if (!$result = $mysqli->query($sql)) {
        echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
    } else {
        $companies = array(
            "response" => array(
                "code" => "200",
                "comment" => "All cities in database."
            ),
            "headers" => array(
                array(
                    "city" => "Cities"
                )
            ),
            "data" => array()
        );
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_array(MYSQL_ASSOC)) {
                array_push($companies["data"], $row);
            }

            $result->close();
            return json_encode($companies);
        } else {
            $companies["response"]["code"] = "400";
        }
    }
    $mysqli->close();
}
//////////////////////////////////////////////
// funciton: sector
// returns all sectors
/////////////////////////////////////////////
function sector()
{
    $mysqli = connectToServer();
    $sql    = "SELECT sector.sector_name FROM sector ORDER BY sector.sector_name ASC";
    if (!$result = $mysqli->query($sql)) {
        echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
    } else {
        $companies = array(
            "response" => array(

                    "code" => "200",
                    "comment" => "All sectors in database"

            ),
            "headers" => array(
                array(
                    "sector" => "Sectors"
                )
            ),
            "data" => array()
        );
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_array(MYSQL_ASSOC)) {
                array_push($companies["data"], $row);
            }
        } else {
            $companies["response"]["code"]    = "400";
            $companies["response"]["comment"] = "Internal error in sector.";
        }
    }
    return json_encode($companies);
    $result->close();
    $mysqli->close();
}
//////////////////////////////////////////////
// funciton: sector2
// returns all sectors
/////////////////////////////////////////////
function sector2()
{
    $mysqli = connectToServer();
    $sql    = "SELECT DISTINCT * FROM (SELECT sector.sector_name, sector.sector_description FROM sector RIGHT JOIN company_sector ON sector.sector_id = company_sector.sector_id) a ORDER BY a.`sector_name` ASC ";
    if (!$result = $mysqli->query($sql)) {
        echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
    } else {
        $companies = array(
            "response" => array(

                    "code" => "200",
                    "comment" => "0 results. Here are all the Sectors that currently have companies associate with them..."

            ),
            "headers" => array(
                array(
                    "sector" => "Sector",
                    "desc" => "Description"
                )
            ),
            "data" => array()
        );
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_array(MYSQL_ASSOC)) {
                array_push($companies["data"], $row);
            }
        } else {
            $companies["response"]["code"] = "400";
        }
    }
    $result->close();
    return json_encode($companies);
    $mysqli->close();
}
////////////////////////////////////////////
// function: ave Job
// returns the average of all job titles in
// database, limit 10
///////////////////////////////////////////
function ave_job()
{
    $mysqli = connectToServer();
    $sql    = "SELECT job.job_title, REPLACE(FORMAT(avg(job.job_salary), '0'),',','') AS ave_salary FROM job
  group by job.job_title Asc having count(job.job_title) > 0 ";
    if (!$result = $mysqli->query($sql)) {
        echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
    } else {
        $companies = array(
            "response" => array(

                    "code" => "200",
                    "comment" => ''

            ),
            "headers" => array(
                array(
                    "title" => "Job Title",
                    "salary" => "Average Salary"
                )
            ),
            "data" => array()
        );
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_array(MYSQL_ASSOC)) {
                array_push($companies["data"], $row);
            }
        } else {
            $companies["response"]["code"] = "400";
        }
    }
    $result->close();
    return json_encode($companies);
    $mysqli->close();
}

////////////////////////////////////////////
// function: job
// returns the average of all job titles in
// database, limit 10
///////////////////////////////////////////
function job($job)
{
    $mysqli = connectToServer();
    if (!($stmt = $mysqli->prepare("SELECT job.job_title,job.job_salary,company.company_name, city.city_name FROM
		job right join city on job.city_id = city.city_id right join company on job.company_id = company.company_id WHERE job.job_title = ?"))) {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }

    ////add prepare statment
    if (!$stmt->bind_param("s", $job)) {
        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    } else {
        $result    = $stmt->get_result();
        $companies = array(
            "response" => array(
                    "code" => "200",
                    "comment" => "Here are some jobs in local cities associated with the job title you requested..."

            ),
            "headers" => array(
								array(
                    "title" => "Job Title",
                    "salary" => "Average Salary",
                    "company" => "Company",
                    "city" => "city"
									)

            ),
            "data" => array()
        );
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_array(MYSQL_ASSOC)) {
                array_push($companies["data"], $row);
            }
        } else {
            $companies["response"]["code"] = "400";
        }
    }
		$result->close();
    return json_encode($companies);
    $mysqli->close();
}

/**/
function sector_city($location)
{
    $mysqli = connectToServer();
    if (!($stmt = $mysqli->prepare("SELECT sector.sector_name, concat('(',Count(city.city_name),')') as numCities from city inner join city_sector
	on city.city_id = city_sector.city_id inner join sector on city_sector.sector_id = sector.sector_id where city.city_name = ? group by sector.sector_name;"))) {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }
    if (!$stmt->bind_param("s", $location)) {
        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    } else {
        $result    = $stmt->get_result();
        $companies = array(
            "response" => array(
                    "code" => "200",
                    "comment" => ""
            ),
            "headers" => array(
                array(
                    "sector" => "Sector",
                    "num_cities" => "Number of Companies"
                )
            ),
            "data" => array()
        );

        if ($result->num_rows > 0) {
            $row_results = array();
            while ($row = $result->fetch_array(MYSQL_ASSOC)) {
                array_push($companies["data"], $row);
            }
            $result->close();

        } else {

            	$companies["response"]["code"]="400";
            	$companies["response"]["commments"]="Error, no sectors are associated with this city";


        }

    }
		return json_encode($companies);
    $mysqli->close();
}


// /////////////////////////////////////////////
// returns all jobs for a desired company
// ////////////////////////////////////////////

function job_company($job, $company)
{
    $mysqli = connectToServer();
    if (!($stmt = $mysqli->prepare("SELECT job.job_title,
    job.job_salary, company.company_name FROM job LEFT JOIN company ON job.company_id = company.company_id
    WHERE job.company_id IN(SELECT company.company_id from company WHERE company.company_name = ?) AND job.city_id IN(SELECT city.city_id from city)
		AND job.job_title = ? ORDER BY job.job_salary;"))) {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }
    if (!$stmt->bind_param("ss", $company, $job)) {
        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    } else {
        $result    = $stmt->get_result();
        $companies = array(
            "response" => array(

                    "code" => "200",
                    "comment" => ""

            ),
            "headers" => array(
							array(
                    "title" => "Job Title",
                    "salary" => "Salary",
                    "company" => "Company"
							)
            ),
            "data" => array()
        );

        if ($result->num_rows > 0) {
            $row_results = array();
            while ($row = $result->fetch_array(MYSQL_ASSOC)) {
                array_push($companies["data"], $row);
            }
            $result->close();
        } else {
            $job_by_name    = json_decode(job($job), 'true');
            $company_anyjob = json_decode(company_anyjob($location), 'true');
            if ($job_by_name["response"]["code"] === "400" && $company_anyjob["response"]["code"] === "400") {
                $companies["response"]["code"] = "400";
								$companies["response"]["comment"] = "Sorry, no job titles or companies matched your search, please try again.";
            } elseif ($job_by_name["response"]["code"] === "400") {
                return $company_anyjob;
            } else {
                return $job_by_name;
            }
        return json_encode($companies);
			  }
    }
    $mysqli->close();
}
/**/
function job_city($job, $location)
{
    $mysqli = connectToServer();
    if (!($stmt = $mysqli->prepare("SELECT job.job_title,
    job.job_salary, company.company_name FROM job LEFT JOIN company ON job.company_id = company.company_id
    WHERE job.city_id IN(SELECT city.city_id from city WHERE city.city_name = ?) AND job.job_title = ?
    ORDER BY job.job_salary;"))) {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }
    if (!$stmt->bind_param("ss", $location, $job)) {
        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    } else {
        $result    = $stmt->get_result();
        $companies = array(
					"response" => array(
						"code" => "200","comment" => ""
					)  ,
            "headers" => array(
                    "title" => "Job Title",
                    "salary" => "Salary",
                    "company" => "Company"

            ),
            "data" => array()
        );

        if ($result->num_rows > 0) {
            $row_results = array();
            while ($row = $result->fetch_array(MYSQL_ASSOC)) {
                array_push($companies["data"], $row);
            }
            $result->close();
            return json_encode($companies);
        } else {
            $job_by_name = json_decode(job($job), 'true');
            $city_anyjob = json_decode(city_anyjob($location), 'true');
						//echo "job_by_name: ".$job_by_name["response"];
            if ($job_by_name["response"]["code"] === "400" && $city_anyjob["response"]["code"] === "400") {
                $companies["response"]["code"] = "400";
                $companies["response"]["comments"] = "Error job_city";
                return json_encode($companies);
            } elseif ($job_by_name["response"]["code"] === "400") {
                return json_encode($city_anyjob);
            } else {
                return json_encode($job_by_name);
            }
        }
    }
    $mysqli->close();
}
?>
