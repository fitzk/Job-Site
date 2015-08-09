CREATE TABLE IF NOT EXISTS company(
company_id INT(6) AUTO_INCREMENT PRIMARY KEY NOT NULL,
company_name VARCHAR(255) NOT NULL UNIQUE,
company_size VARCHAR(255),
company_profit VARCHAR(255),
company_stock_symbol VARCHAR(15));

CREATE TABLE IF NOT EXISTS sector(
sector_id INT(6)AUTO_INCREMENT PRIMARY KEY NOT NULL,
sector_name VARCHAR(255) NOT NULL UNIQUE,
sector_description VARCHAR(255));

CREATE TABLE IF NOT EXISTS city(
city_id INT(6) AUTO_INCREMENT PRIMARY KEY NOT NULL,
city_name VARCHAR(255) NOT NULL UNIQUE);

CREATE TABLE IF NOT EXISTS job(
job_id INT(6)AUTO_INCREMENT PRIMARY KEY NOT NULL,
job_title VARCHAR(255) NOT NULL,
job_salary INT(15),
company_id INT(6),
city_id INT(6),
CONSTRAINT FOREIGN KEY(company_id)
REFERENCES company(company_id) ON DELETE SET NULL ON UPDATE CASCADE,
CONSTRAINT FOREIGN KEY(city_id)
REFERENCES city(city_id) ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS company_city(
city_id INT(6),
company_id INT(6),
CONSTRAINT FOREIGN KEY(city_id)
REFERENCES city(city_id) ON DELETE SET NULL ON UPDATE CASCADE,
CONSTRAINT FOREIGN KEY(company_id)
REFERENCES company(company_id) ON DELETE SET NULL ON UPDATE CASCADE);

CREATE TABLE IF NOT EXISTS company_sector(
company_id INT(6),
sector_id INT(6),
CONSTRAINT FOREIGN KEY(company_id)
REFERENCES company(company_id) ON DELETE SET NULL ON UPDATE CASCADE,
CONSTRAINT FOREIGN KEY(sector_id)
REFERENCES sector(sector_id) ON DELETE SET NULL ON UPDATE CASCADE);

CREATE TABLE IF NOT EXISTS city_sector(
city_id INT(6),
sector_id INT(6),
CONSTRAINT FOREIGN KEY(city_id)
REFERENCES city(city_id) ON DELETE SET NULL ON UPDATE CASCADE,
CONSTRAINT FOREIGN KEY(sector_id)
REFERENCES sector(sector_id) ON DELETE SET NULL ON UPDATE CASCADE);
-- http://www.ditawriter.com/so-whos-using-dita/
/*sector*/
INSERT IGNORE INTO sector (sector_name,sector_description) VALUES ('Software','Et eum tollit option, eu idque utinam sadipscing usu.');
INSERT IGNORE INTO sector (sector_name,sector_description) VALUES ('Health Care Information Technology','Et eum tollit option, eu idque utinam sadipscing usu.');
INSERT IGNORE INTO sector (sector_name,sector_description) VALUES ('Technical Documentation Solutions','Et eum tollit option, eu idque utinam sadipscing usu.');
INSERT IGNORE INTO sector (sector_name,sector_description) VALUES ('Semiconductors','Et eum tollit option, eu idque utinam sadipscing usu.');
INSERT IGNORE INTO sector (sector_name,sector_description) VALUES ('Telecommunications','Et eum tollit option, eu idque utinam sadipscing usu.');
INSERT IGNORE INTO sector (sector_name,sector_description) VALUES ('Training','Et eum tollit option, eu idque utinam sadipscing usu.');
INSERT IGNORE INTO sector (sector_name,sector_description) VALUES ('Consultancy','Et eum tollit option, eu idque utinam sadipscing usu.');
INSERT IGNORE INTO sector (sector_name,sector_description) VALUES ('Financial Services','Et eum tollit option, eu idque utinam sadipscing usu.');
INSERT IGNORE INTO sector (sector_name,sector_description) VALUES ('Academic Institution','Et eum tollit option, eu idque utinam sadipscing usu.');
INSERT IGNORE INTO sector (sector_name,sector_description) VALUES ('Networking Equipment','Et eum tollit option, eu idque utinam sadipscing usu.');
INSERT IGNORE INTO sector (sector_name,sector_description) VALUES ('Non-Profit Organization','Et eum tollit option, eu idque utinam sadipscing usu.');
INSERT IGNORE INTO sector (sector_name,sector_description) VALUES ('Oil','Et eum tollit option, eu idque utinam sadipscing usu.');
INSERT IGNORE INTO sector (sector_name,sector_description) VALUES ('Translation Solutions','Et eum tollit option, eu idque utinam sadipscing usu.');
INSERT IGNORE INTO sector (sector_name,sector_description) VALUES ('Other','Et eum tollit option, eu idque utinam sadipscing usu.');

/*city */
INSERT IGNORE INTO city (city_name) VALUES ('San Jose');
INSERT IGNORE INTO city (city_name) VALUES ('Mountain View');
INSERT IGNORE INTO city (city_name) VALUES ('Sunnyvale');
INSERT IGNORE INTO city (city_name) VALUES ('Gilroy');
INSERT IGNORE INTO city (city_name) VALUES ('Santa Clara');
INSERT IGNORE INTO city (city_name) VALUES ('Campbell');
INSERT IGNORE INTO city (city_name) VALUES ('Cupertino');
INSERT IGNORE INTO city (city_name) VALUES ('Los Gatos');
INSERT IGNORE INTO city (city_name) VALUES ('Los Altos');
INSERT IGNORE INTO city (city_name) VALUES ('Palo Alto');
INSERT IGNORE INTO city (city_name) VALUES ('Menlo Park');

/*Infosys Consulting*/
INSERT IGNORE INTO company(company_name,company_size,company_profit,company_stock_symbol) VALUES ('Infosys Consulting','5000+','$10+ billion', 'INFY');
/*company city  */ INSERT IGNORE INTO company_city(company_id,city_id) VALUES((SELECT company_id from company where company_name = 'Infosys Consulting'),(SELECT city_id from city WHERE city_name = 'San Jose'));
/*company sector*/ INSERT IGNORE INTO company_sector(company_id,sector_id) VALUES((SELECT company_id from company where company_name = 'Infosys Consulting'),(SELECT sector_id from sector WHERE sector_name = 'Consultancy'));
/*city sector   */ INSERT IGNORE INTO city_sector(city_id,sector_id) VALUES((SELECT city_id from city WHERE city_name = 'San Jose'),(SELECT sector_id from sector WHERE sector_name = 'Consultancy'));
/*Cisco Systems*/
INSERT IGNORE INTO company(company_name,company_size,company_profit,company_stock_symbol) VALUES ('Cisco Systems','5000+','$10+ billion','CSCO');
/*company city  */ INSERT IGNORE INTO company_city(company_id,city_id) VALUES((SELECT company_id from company where company_name = 'Cisco'),(SELECT city_id from city WHERE city_name = 'San Jose'));
/*company sector*/ INSERT IGNORE INTO company_sector(company_id,sector_id) VALUES((SELECT company_id from company where company_name = 'Cisco'),(SELECT sector_id from sector WHERE sector_name = 'Consultancy'));
/*city sector   */ INSERT IGNORE INTO city_sector(city_id,sector_id) VALUES((SELECT city_id from city WHERE city_name = 'San Jose'),(SELECT sector_id from sector WHERE sector_name = 'Consultancy'));
/*company sector*/ INSERT IGNORE INTO company_sector(company_id,sector_id) VALUES((SELECT company_id from company where company_name = 'Cisco'),(SELECT sector_id from sector WHERE sector_name = 'Software'));
/*city sector   */ INSERT IGNORE INTO city_sector(city_id,sector_id) VALUES((SELECT city_id from city WHERE city_name = 'San Jose'),(SELECT sector_id from sector WHERE sector_name = 'Software'));
/*company sector*/ INSERT IGNORE INTO company_sector(company_id,sector_id) VALUES((SELECT company_id from company where company_name = 'Cisco'),(SELECT sector_id from sector WHERE sector_name = 'Other'));
/*city sector   */ INSERT IGNORE INTO city_sector(city_id,sector_id) VALUES((SELECT city_id from city WHERE city_name = 'San Jose'),(SELECT sector_id from sector WHERE sector_name = 'Other'));
/*company sector*/ INSERT IGNORE INTO company_sector(company_id,sector_id) VALUES((SELECT company_id from company where company_name = 'Cisco'),(SELECT sector_id from sector WHERE sector_name = 'Telecommunications'));
/*city sector   */ INSERT IGNORE INTO city_sector(city_id,sector_id) VALUES((SELECT city_id from city WHERE city_name = 'San Jose'),(SELECT sector_id from sector WHERE sector_name = 'Telecommunications'));
/*Groupon*/
INSERT IGNORE INTO company(company_name,company_size,company_profit,company_stock_symbol) VALUES ('Groupon','5000+','$3.2+ billion','GRPN');
/*company city  */ INSERT IGNORE INTO company_city(company_id,city_id) VALUES((SELECT company_id from company where company_name = 'Groupon'),(SELECT city_id from city WHERE city_name = 'Palo Alto'));
/*company sector*/ INSERT IGNORE INTO company_sector(company_id,sector_id) VALUES((SELECT company_id from company where company_name = 'Groupon'),(SELECT sector_id from sector WHERE sector_name = 'Other'));
/*city sector   */ INSERT IGNORE INTO city_sector(city_id,sector_id) VALUES((SELECT city_id from city WHERE city_name = 'Palo Alot'),(SELECT sector_id from sector WHERE sector_name = 'Software'));
/* Twilio*/
INSERT IGNORE INTO company(company_name,company_size,company_profit,company_stock_symbol) VALUES ('Twilio','n/a','n/a','Private');
/*company city  */ INSERT IGNORE INTO company_city(company_id,city_id) VALUES((SELECT company_id from company where company_name = 'Twilio'),(SELECT city_id from city WHERE city_name = 'Mountain View'));
/*company sector*/ INSERT IGNORE INTO company_sector(company_id,sector_id) VALUES((SELECT company_id from company where company_name = 'Twilio'),(SELECT sector_id from sector WHERE sector_name = 'Software'));
/*city sector   */ INSERT IGNORE INTO city_sector(city_id,sector_id) VALUES((SELECT city_id from city WHERE city_name = 'Mountain View'),(SELECT sector_id from sector WHERE sector_name = 'Software'));
/*city sector   */ INSERT IGNORE INTO city_sector(city_id,sector_id) VALUES((SELECT city_id from city WHERE city_name = 'San Jose'),(SELECT sector_id from sector WHERE sector_name = 'Software'));

/*VMware*/
INSERT IGNORE INTO company(company_name,company_size,company_profit,company_stock_symbol) VALUES ('VMware','5000+','$6 billion','VMW');
/*company city  */ INSERT IGNORE INTO company_city(company_id,city_id) VALUES((SELECT company_id from company where company_name = 'VMware'),(SELECT city_id from city WHERE city_name = 'Palo Alto'));
/*company sector*/ INSERT IGNORE INTO company_sector(company_id,sector_id) VALUES((SELECT company_id from company where company_name = 'VMware'),(SELECT sector_id from sector WHERE sector_name = 'Software'));
/*city sector   */ INSERT IGNORE INTO city_sector(city_id,sector_id) VALUES((SELECT city_id from city WHERE city_name = 'Palo Alto'),(SELECT sector_id from sector WHERE sector_name = 'Software'));
/*Elastic*/
INSERT IGNORE INTO company(company_name,company_size,company_profit,company_stock_symbol) VALUES ('Elastic','150-499','n/a','Private');
/*company city  */ INSERT IGNORE INTO company_city(company_id,city_id) VALUES((SELECT company_id from company where company_name = 'Elastic'),(SELECT city_id from city WHERE city_name = 'Mountain View'));
/*company sector*/ INSERT IGNORE INTO company_sector(company_id,sector_id) VALUES((SELECT company_id from company where company_name = 'Elastic'),(SELECT sector_id from sector WHERE sector_name = 'Software'));
/*city sector   */ INSERT IGNORE INTO city_sector(city_id,sector_id) VALUES((SELECT city_id from city WHERE city_name = 'Mountain View'),(SELECT sector_id from sector WHERE sector_name = 'Software'));
/*Intuit*/
INSERT IGNORE INTO company(company_name,company_size,company_profit,company_stock_symbol) VALUES ('Intuit','5000+','$4,171 million','INTU');
/*company city  */ INSERT IGNORE INTO company_city(company_id,city_id) VALUES((SELECT company_id from company where company_name = 'Intuit'),(SELECT city_id from city WHERE city_name = 'Mountain View'));
/*company city  */ INSERT IGNORE INTO company_city(company_id,city_id) VALUES((SELECT company_id from company where company_name = 'Intuit'),(SELECT city_id from city WHERE city_name = 'San Jose'));
/*company sector*/ INSERT IGNORE INTO company_sector(company_id,sector_id) VALUES((SELECT company_id from company where company_name = 'Intuit'),(SELECT sector_id from sector WHERE sector_name = 'Software'));
/*city sector   */ INSERT IGNORE INTO city_sector(city_id,sector_id) VALUES((SELECT city_id from city WHERE city_name = 'Mountian View'),(SELECT sector_id from sector WHERE sector_name = 'Software'));
/*city sector   */ INSERT IGNORE INTO city_sector(city_id,sector_id) VALUES((SELECT city_id from city WHERE city_name = 'San Jose'),(SELECT sector_id from sector WHERE sector_name = 'Software'));
/*Intel*/
INSERT IGNORE INTO company(company_name,company_size,company_profit,company_stock_symbol) VALUES ('Intel','5000+','$55+ billion','INTC');
/*company city  */ INSERT IGNORE INTO company_city(company_id,city_id) VALUES((SELECT company_id from company where company_name = 'Intel'),(SELECT city_id from city WHERE city_name = 'Santa Clara'));
/*company sector*/ INSERT IGNORE INTO company_sector(company_id,sector_id) VALUES((SELECT company_id from company where company_name = 'Intel'),(SELECT sector_id from sector WHERE sector_name = 'Semiconductors'));
/*city sector   */ INSERT IGNORE INTO city_sector(city_id,sector_id) VALUES((SELECT city_id from city WHERE city_name = 'Santa Clara'),(SELECT sector_id from sector WHERE sector_name = 'Semiconductors'));
/*Blue Coat*/
INSERT IGNORE INTO company(company_name,company_size,company_profit,company_stock_symbol) VALUES ('Blue Coat','1000+','$500 million','Private');
/*company city  */ INSERT IGNORE INTO company_city(company_id,city_id) VALUES((SELECT company_id from company where company_name = 'Blue Coat'),(SELECT city_id from city WHERE city_name = 'San Jose'));
/*company sector*/ INSERT IGNORE INTO company_sector(company_id,sector_id) VALUES((SELECT company_id from company where company_name = 'Blue Coat'),(SELECT sector_id from sector WHERE sector_name = 'Other'));
/*city sector   */ INSERT IGNORE INTO city_sector(city_id,sector_id) VALUES((SELECT city_id from city WHERE city_name = 'San Jose'),(SELECT sector_id from sector WHERE sector_name = 'Other'));
/*NVIDIA*/
INSERT IGNORE INTO company(company_name,company_size,company_profit,company_stock_symbol) VALUES ('NVIDIA','5000+','$2 to $5 billion','NVDA');
/*company city  */ INSERT IGNORE INTO company_city(company_id,city_id) VALUES((SELECT company_id from company where company_name = 'NVIDIA'),(SELECT city_id from city WHERE city_name = 'Santa Clara'));
/*company sector*/ INSERT IGNORE INTO company_sector(company_id,sector_id) VALUES((SELECT company_id from company where company_name = 'NVIDIA'),(SELECT sector_id from sector WHERE sector_name = 'Software'));
/*city sector   */ INSERT IGNORE INTO city_sector(city_id,sector_id) VALUES((SELECT city_id from city WHERE city_name = 'Santa Clara'),(SELECT sector_id from sector WHERE sector_name = 'Software'));

/*Blue Coat job*/
INSERT IGNORE INTO job(job_title,job_salary,company_id,city_id) VALUES ('Software Engineer','124686',(SELECT company_id from company where company_name = 'Blue Coat'),(SELECT city_id from city WHERE city_name = 'San Jose'));
INSERT IGNORE INTO job(job_title,job_salary,company_id,city_id) VALUES ('QA Engineer','92116',(SELECT company_id from company where company_name = 'Blue Coat'),(SELECT city_id from city WHERE city_name = 'San Jose'));
INSERT IGNORE INTO job(job_title,job_salary,company_id,city_id) VALUES ('Software Engineer','113266',(SELECT company_id from company where company_name = 'Blue Coat'),(SELECT city_id from city WHERE city_name = 'San Jose'));
INSERT IGNORE INTO job(job_title,job_salary,company_id,city_id) VALUES ('QA Engineer','109742',(SELECT company_id from company where company_name = 'Blue Coat'),(SELECT city_id from city WHERE city_name = 'San Jose'));
INSERT IGNORE INTO job(job_title,job_salary,company_id,city_id) VALUES ('QA Engineer','124685',(SELECT company_id from company where company_name = 'Blue Coat'),(SELECT city_id from city WHERE city_name = 'San Jose'));
INSERT IGNORE INTO job(job_title,job_salary,company_id,city_id) VALUES ('Senior Software Engineer','136868',(SELECT company_id from company where company_name = 'Blue Coat'),(SELECT city_id from city WHERE city_name = 'San Jose'));
INSERT IGNORE INTO job(job_title,job_salary,company_id,city_id) VALUES ('Network Engineer','124648',(SELECT company_id from company where company_name = 'Blue Coat'),(SELECT city_id from city WHERE city_name = 'San Jose'));
INSERT IGNORE INTO job(job_title,job_salary,company_id,city_id) VALUES ('Tech Support Engineer','103584',(SELECT company_id from company where company_name = 'Blue Coat'),(SELECT city_id from city WHERE city_name = 'San Jose'));
/*Cisco Systems*/
INSERT IGNORE INTO job(job_title,job_salary,company_id,city_id) VALUES ('Software Engineer','117501',(SELECT company_id from company where company_name = 'Cisco Systems'),(SELECT city_id from city WHERE city_name = 'San Jose'));
INSERT IGNORE INTO job(job_title,job_salary,company_id,city_id) VALUES ('Software Engineer IV','131548',(SELECT company_id from company where company_name = 'Cisco Systems'),(SELECT city_id from city WHERE city_name = 'San Jose'));
INSERT IGNORE INTO job(job_title,job_salary,company_id,city_id) VALUES ('Software Engineer III','110949',(SELECT company_id from company where company_name = 'Cisco Systems'),(SELECT city_id from city WHERE city_name = 'San Jose'));
INSERT IGNORE INTO job(job_title,job_salary,company_id,city_id) VALUES ('QA Engineer','106648',(SELECT company_id from company where company_name = 'Cisco Systems'),(SELECT city_id from city WHERE city_name = 'San Jose'));
INSERT IGNORE INTO job(job_title,job_salary,company_id,city_id) VALUES ('Software Engineer II','92264',(SELECT company_id from company where company_name = 'Cisco Systems'),(SELECT city_id from city WHERE city_name = 'San Jose'));
INSERT IGNORE INTO job(job_title,job_salary,company_id,city_id) VALUES ('IT Engineer','118794',(SELECT company_id from company where company_name = 'Cisco Systems'),(SELECT city_id from city WHERE city_name = 'San Jose'));
INSERT IGNORE INTO job(job_title,job_salary,company_id,city_id) VALUES ('Software Engineer','94299',(SELECT company_id from company where company_name = 'Cisco Systems'),(SELECT city_id from city WHERE city_name = 'San Jose'));
/*Sample job*/
INSERT IGNORE INTO job(job_title,job_salary,company_id) VALUES ('Software Engineer','155097',(SELECT company_id from company where company_name = 'Elastic'));
/*Sample job*/
INSERT IGNORE INTO job(job_title,job_salary,company_id,city_id) VALUES ('Software Engineer','123381',(SELECT company_id from company where company_name = 'Intuit'),(SELECT city.city_id from city WHERE city.city_name = "San Jose"));
INSERT IGNORE INTO job(job_title,job_salary,company_id,city_id) VALUES ('Software Engineer','95427',(SELECT company_id from company where company_name = 'Intuit'),(SELECT city.city_id from city WHERE city.city_name = "San Jose"));
INSERT IGNORE INTO job(job_title,job_salary,company_id,city_id) VALUES ('Senior Software Engineer','126251',(SELECT company_id from company where company_name = 'Intuit'),(SELECT city.city_id from city WHERE city.city_name = "Mountain View"));
INSERT IGNORE INTO job(job_title,job_salary,company_id,city_id) VALUES ('Software Engineer','96007',(SELECT company_id from company where company_name = 'Intuit'),(SELECT city.city_id from city WHERE city.city_name = "Mountain View"));
INSERT IGNORE INTO job(job_title,job_salary,company_id,city_id) VALUES ('Software Engineer II','98689',(SELECT company_id from company where company_name = 'Intuit'),(SELECT city.city_id from city WHERE city.city_name = "Mountain View"));
/*Sample job*/
INSERT IGNORE INTO job(job_title,job_salary,company_id,city_id) VALUES ('Architect','129983',(SELECT company_id from company where company_name = 'NVIDIA'),(SELECT city.city_id from city WHERE city.city_name = "Santa Clara"));
INSERT IGNORE INTO job(job_title,job_salary,company_id,city_id) VALUES ('ASIC Design Engineer','103855',(SELECT company_id from company where company_name = 'NVIDIA'),(SELECT city.city_id from city WHERE city.city_name = "Santa Clara"));
INSERT IGNORE INTO job(job_title,job_salary,company_id,city_id) VALUES ('Senior Software Engineer','140557',(SELECT company_id from company where company_name = 'NVIDIA'),(SELECT city.city_id from city WHERE city.city_name = "Santa Clara"));
INSERT IGNORE INTO job(job_title,job_salary,company_id,city_id) VALUES ('Engineer III','124000',(SELECT company_id from company where company_name = 'NVIDIA'),(SELECT city.city_id from city WHERE city.city_name = "Santa Clara"));
INSERT IGNORE INTO job(job_title,job_salary,company_id,city_id) VALUES ('Software Engineer II','98689',(SELECT company_id from company where company_name = 'NVIDIA'),(SELECT city.city_id from city WHERE city.city_name = "Santa Clara"));
/*      */
INSERT IGNORE INTO company(company_name,company_size,company_profit,company_stock_symbol) VALUES ('Adobe', '5000+','$2 to $5 billion','ADBE');
INSERT IGNORE INTO company_city(company_id,city_id) VALUES((SELECT company_id from company where company_name = 'Adobe'),(SELECT city_id from city WHERE city_name = 'San Jose'));
INSERT IGNORE INTO company_sector(company_id,sector_id) VALUES((SELECT company_id from company where company_name = 'Adobe'),(SELECT sector_id from sector WHERE sector_name = 'Other'));
INSERT IGNORE INTO company_sector(company_id,sector_id) VALUES((SELECT company_id from company where company_name = 'Adobe'),(SELECT sector_id from sector WHERE sector_name = 'Software'));
INSERT IGNORE INTO company_sector(company_id,sector_id) VALUES((SELECT company_id from company where company_name = 'Adobe'),(SELECT sector_id from sector WHERE sector_name = 'Technical Documentation Solutions'));
INSERT IGNORE INTO city_sector(city_id,sector_id) VALUES((SELECT city_id from city where city_name = 'San Jose'),(SELECT sector_id from sector WHERE sector_name = 'Other'));
INSERT IGNORE INTO city_sector(city_id,sector_id) VALUES((SELECT city_id from city where city_name = 'San Jose'),(SELECT sector_id from sector WHERE sector_name = 'Software'));
INSERT IGNORE INTO city_sector(city_id,sector_id) VALUES((SELECT city_id from city where city_name = 'San Jose'),(SELECT sector_id from sector WHERE sector_name = 'Technical Documentation Solutions'));
/*      */
INSERT IGNORE INTO job(job_title,job_salary,company_id,city_id) VALUES ('QA Engineer','105983',(SELECT company_id from company where company_name = 'Adobe'), (SELECT city_id from city WHERE city_name = 'San Jose'));
INSERT IGNORE INTO job(job_title,job_salary,company_id,city_id) VALUES ('Product Manager','153917',(SELECT company_id from company where company_name = 'Adobe'), (SELECT city_id from city WHERE city_name = 'San Jose'));
INSERT IGNORE INTO job(job_title,job_salary,company_id,city_id) VALUES ('Senior Software Engineer','148938',(SELECT company_id from company where company_name = 'Adobe'), (SELECT city_id from city WHERE city_name = 'San Jose'));
INSERT IGNORE INTO job(job_title,job_salary,company_id,city_id) VALUES ('Senior Engineering Manager','197379',(SELECT company_id from company where company_name = 'Adobe'), (SELECT city_id from city WHERE city_name = 'San Jose'));
INSERT IGNORE INTO job(job_title,job_salary,company_id,city_id) VALUES ('Scientist','113851',(SELECT company_id from company where company_name = 'Adobe'), (SELECT city_id from city WHERE city_name = 'San Jose'));
/*  */
INSERT IGNORE INTO company(company_name,company_size,company_profit,company_stock_symbol) VALUES ('Yahoo', '5000+','$2 to $5 billion','YHOO');
INSERT IGNORE INTO company_city(company_id,city_id) VALUES((SELECT company_id from company where company_name = 'Yahoo'),(SELECT city_id from city WHERE city_name = 'Sunnyvale'));
INSERT IGNORE INTO company_sector(company_id,sector_id) VALUES((SELECT company_id from company where company_name = 'Yahoo'),(SELECT sector_id from sector WHERE sector_name = 'Other'));
INSERT IGNORE INTO company_sector(company_id,sector_id) VALUES((SELECT company_id from company where company_name = 'Yahoo'),(SELECT sector_id from sector WHERE sector_name = 'Software'));
INSERT IGNORE INTO city_sector(city_id,sector_id) VALUES((SELECT city_id from city where city_name = 'Sunnyvale'),(SELECT sector_id from sector WHERE sector_name = 'Other'));
INSERT IGNORE INTO city_sector(city_id,sector_id) VALUES((SELECT city_id from city where city_name = 'Sunnyvale'),(SELECT sector_id from sector WHERE sector_name = 'Software'));
/* */
INSERT IGNORE INTO company(company_name,company_size,company_profit,company_stock_symbol) VALUES ('Symantec', '5000+','$2 to $10 billion','SYMC');
INSERT IGNORE INTO company_city(company_id,city_id) VALUES((SELECT company_id from company where company_name = 'Symantec'),(SELECT city_id from city WHERE city_name = 'Mountain View'));
INSERT IGNORE INTO company_sector(company_id,sector_id) VALUES((SELECT company_id from company where company_name = 'Symantec'),(SELECT sector_id from sector WHERE sector_name = 'Other'));
INSERT IGNORE INTO company_sector(company_id,sector_id) VALUES((SELECT company_id from company where company_name = 'Symantec'),(SELECT sector_id from sector WHERE sector_name = 'Software'));
INSERT IGNORE INTO city_sector(city_id,sector_id) VALUES((SELECT city_id from city where city_name = 'Mountain View'),(SELECT sector_id from sector WHERE sector_name = 'Other'));
INSERT IGNORE INTO city_sector(city_id,sector_id) VALUES((SELECT city_id from city where city_name = 'Mountain View'),(SELECT sector_id from sector WHERE sector_name = 'Software'));
INSERT IGNORE INTO city(city_name) VALUES (new);
INSERT IGNORE INTO city(city_name) VALUES (new);
INSERT IGNORE INTO city(city_name) VALUES (san jose);
INSERT IGNORE INTO city(city_name) VALUES (new);
INSERT IGNORE INTO city(city_name) VALUES (new);
INSERT IGNORE INTO city(city_name) VALUES (new);
INSERT IGNORE INTO city(city_name) VALUES (new);
INSERT IGNORE INTO city(city_name) VALUES (san jose);
INSERT IGNORE INTO city(city_name) VALUES (new place);
