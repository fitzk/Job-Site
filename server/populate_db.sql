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

INSERT IGNORE INTO company(co_name) VALUES ('Infosys Consulting');
INSERT IGNORE INTO company_city(co_id,city_id) VALUES((SELECT co_id from company where co_name = 'Infosys Consulting'),(SELECT city_id from city WHERE city_name = 'San Jose'));
INSERT IGNORE INTO company_sector(co_id,sector_id) VALUES((SELECT co_id from company where co_name = 'Infosys Consulting'),(SELECT sector_id from sector WHERE sector_name = 'Consultancy'));
