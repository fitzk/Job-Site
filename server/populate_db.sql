-- http://www.ditawriter.com/so-whos-using-dita/
INSERT IGNORE INTO sector (sector_name,sector_description) VALUES ('Software','');
INSERT IGNORE INTO sector (sector_name,sector_description) VALUES ('Health Care Information Technology','');
INSERT IGNORE INTO sector (sector_name,sector_description) VALUES ('Technical Documentation Solutions','');
INSERT IGNORE INTO sector (sector_name,sector_description) VALUES ('Semiconductors','');
INSERT IGNORE INTO sector (sector_name,sector_description) VALUES ('Telecommunications','');
INSERT IGNORE INTO sector (sector_name,sector_description) VALUES ('Training','');
INSERT IGNORE INTO sector (sector_name,sector_description) VALUES ('Consultancy','');
INSERT IGNORE INTO sector (sector_name,sector_description) VALUES ('Financial Services','');
INSERT IGNORE INTO sector (sector_name,sector_description) VALUES ('Academic Institution','');
INSERT IGNORE INTO sector (sector_name,sector_description) VALUES ('Networking Equipment','');
INSERT IGNORE INTO sector (sector_name,sector_description) VALUES ('Non-Profit Organization','');
INSERT IGNORE INTO sector (sector_name,sector_description) VALUES ('Oil','');
INSERT IGNORE INTO sector (sector_name,sector_description) VALUES ('Translation Solutions','');
INSERT IGNORE INTO sector (sector_name,sector_description) VALUES ('Other','');


INSERT IGNORE INTO city (city_name) VALUES ('San Jose');
INSERT IGNORE INTO city (city_name) VALUES ('San Francisco');
INSERT IGNORE INTO city (city_name) VALUES ('San Mateo');
INSERT IGNORE INTO city (city_name) VALUES ('Redwood City');
INSERT IGNORE INTO city (city_name) VALUES ('Mountain View');
INSERT IGNORE INTO city (city_name) VALUES ('Sunnyvale');
INSERT IGNORE INTO city (city_name) VALUES ('San Leandro');
INSERT IGNORE INTO city (city_name) VALUES ('Foster City');
INSERT IGNORE INTO city (city_name) VALUES ('Fremont');
INSERT IGNORE INTO city (city_name) VALUES ('Pleasanton');
INSERT IGNORE INTO city (city_name) VALUES ('Livermore');
INSERT IGNORE INTO city (city_name) VALUES ('Oakland');
INSERT IGNORE INTO city (city_name) VALUES ('Berkeley');
INSERT IGNORE INTO city (city_name) VALUES ('Walnut Creek');
INSERT IGNORE INTO city (city_name) VALUES ('Emeryville');
INSERT IGNORE INTO city (city_name) VALUES ('Santa Clara');
INSERT IGNORE INTO city (city_name) VALUES ('Campbell');
INSERT IGNORE INTO city (city_name) VALUES ('Cupertino');
INSERT IGNORE INTO city (city_name) VALUES ('Los Gatos');
INSERT IGNORE INTO city (city_name) VALUES ('Los Altos');
INSERT IGNORE INTO city (city_name) VALUES ('Pacifica');
INSERT IGNORE INTO city (city_name) VALUES ('Palo Alto');
INSERT IGNORE INTO city (city_name) VALUES ('Menlo Park');
/*Infosys Consulting*/
INSERT IGNORE INTO company(company_name,company_size,company_profit) VALUES ('Infosys Consulting','5000+','$10+ billion');
INSERT IGNORE INTO company_city(company_id,city_id) VALUES((SELECT company_id from company where company_name = 'Infosys Consulting'),(SELECT city_id from city WHERE city_name = 'San Jose'));
INSERT IGNORE INTO company_sector(company_id,sector_id) VALUES((SELECT company_id from company where company_name = 'Infosys Consulting'),(SELECT sector_id from sector WHERE sector_name = 'Consultancy'));
/*Cisco Systems*/
INSERT IGNORE INTO company(company_name,company_size,company_profit) VALUES ('Cisco Systems','5000+','$10+ billion');
INSERT IGNORE INTO company_city(company_id,city_id) VALUES((SELECT company_id from company where company_name = 'Cisco'),(SELECT city_id from city WHERE city_name = 'San Jose'));
INSERT IGNORE INTO company_sector(company_id,sector_id) VALUES((SELECT company_id from company where company_name = 'Cisco'),(SELECT sector_id from sector WHERE sector_name = 'Consultancy'));
INSERT IGNORE INTO company_sector(company_id,sector_id) VALUES((SELECT company_id from company where company_name = 'Cisco'),(SELECT sector_id from sector WHERE sector_name = 'Software'));
INSERT IGNORE INTO company_sector(company_id,sector_id) VALUES((SELECT company_id from company where company_name = 'Cisco'),(SELECT sector_id from sector WHERE sector_name = 'Other'));
INSERT IGNORE INTO company_sector(company_id,sector_id) VALUES((SELECT company_id from company where company_name = 'Cisco'),(SELECT sector_id from sector WHERE sector_name = 'Telecommunications'));
/*Groupon*/
INSERT IGNORE INTO company(company_name,company_size,company_profit,company_stock_symbol) VALUES ('Groupon','5000+','$3.2+ billion','GRPN');
INSERT IGNORE INTO company_city(company_id,city_id) VALUES((SELECT company_id from company where company_name = 'Groupon'),(SELECT city_id from city WHERE city_name = 'Palo Alto'));
INSERT IGNORE INTO company_sector(company_id,sector_id) VALUES((SELECT company_id from company where company_name = 'Groupon'),(SELECT sector_id from sector WHERE sector_name = 'Other'));
/* Twilio*/
INSERT IGNORE INTO company(company_name,company_size,company_profit,company_stock_symbol) VALUES ('Twilio','n/a','n/a','Private');
INSERT IGNORE INTO company_city(company_id,city_id) VALUES((SELECT company_id from company where company_name = 'Twilio'),(SELECT city_id from city WHERE city_name = 'Mountain View'));
INSERT IGNORE INTO company_city(company_id,city_id) VALUES((SELECT company_id from company where company_name = 'Twilio'),(SELECT city_id from city WHERE city_name = 'San Francisco'));
INSERT IGNORE INTO company_sector(company_id,sector_id) VALUES((SELECT company_id from company where company_name = 'Twilio'),(SELECT sector_id from sector WHERE sector_name = 'Software'));
/*VMware*/
INSERT IGNORE INTO company(company_name,company_size,company_profit,company_stock_symbol) VALUES ('VMware','5000+','$6 billion','VMW');
INSERT IGNORE INTO company_city(company_id,city_id) VALUES((SELECT company_id from company where company_name = 'VMware'),(SELECT city_id from city WHERE city_name = 'Palo Alto'));
INSERT IGNORE INTO company_sector(company_id,sector_id) VALUES((SELECT company_id from company where company_name = 'VMware'),(SELECT sector_id from sector WHERE sector_name = 'Software'));
/*Elastic*/
INSERT IGNORE INTO company(company_name,company_size,company_profit,company_stock_symbol) VALUES ('Elastic','150-499','n/a','Private');
INSERT IGNORE INTO company_city(company_id,city_id) VALUES((SELECT company_id from company where company_name = 'Elastic'),(SELECT city_id from city WHERE city_name = 'Mountain View'));
INSERT IGNORE INTO company_sector(company_id,sector_id) VALUES((SELECT company_id from company where company_name = 'Elastic'),(SELECT sector_id from sector WHERE sector_name = 'Software'));
/*Intuit*/
INSERT IGNORE INTO company(company_name,company_size,company_profit,company_stock_symbol) VALUES ('Intuit','5000+','$4,171 million','INTU');
INSERT IGNORE INTO company_city(company_id,city_id) VALUES((SELECT company_id from company where company_name = 'Intuit'),(SELECT city_id from city WHERE city_name = 'Mountain View'));
INSERT IGNORE INTO company_sector(company_id,sector_id) VALUES((SELECT company_id from company where company_name = 'Intuit'),(SELECT sector_id from sector WHERE sector_name = 'Software'));
/*Intel*/
INSERT IGNORE INTO company(company_name,company_size,company_profit,company_stock_symbol) VALUES ('Intel','5000+','$55+ billion','INTC');
INSERT IGNORE INTO company_city(company_id,city_id) VALUES((SELECT company_id from company where company_name = 'Intel'),(SELECT city_id from city WHERE city_name = 'Santa Clara'));
INSERT IGNORE INTO company_sector(company_id,sector_id) VALUES((SELECT company_id from company where company_name = 'Intel'),(SELECT sector_id from sector WHERE sector_name = 'Semiconductors'));
/*Blue Coat*/
INSERT IGNORE INTO company(company_name,company_size,company_profit,company_stock_symbol) VALUES ('Blue Coat','1000+','$500 million','Private');
INSERT IGNORE INTO company_city(company_id,city_id) VALUES((SELECT company_id from company where company_name = 'Blue Coat'),(SELECT city_id from city WHERE city_name = 'Sunnyvale'));
INSERT IGNORE INTO company_sector(company_id,sector_id) VALUES((SELECT company_id from company where company_name = 'Blue Coat'),(SELECT sector_id from sector WHERE sector_name = 'Other'));
/*Sample Employee*/
INSERT INTO employee(employee_title,employee_salary,company_id) VALUES ('Sample Engineer','76000',(SELECT company_id from company where company_name = 'Blue Coat'));
/*Sample Employee*/
INSERT INTO employee(employee_title,employee_salary,company_id) VALUES ('Sample Engineer','80000',(SELECT company_id from company where company_name = 'Cisco Systems'));
/*Sample Employee*/
INSERT INTO employee(employee_title,employee_salary,company_id) VALUES ('Sample Engineer','12000',(SELECT company_id from company where company_name = 'Elastic'));
/*Sample Employee*/
INSERT INTO employee(employee_title,employee_salary,company_id) VALUES ('Sample Engineer','11500',(SELECT company_id from company where company_name = 'Intuit'));
