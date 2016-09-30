# _Shoe Store with PHP and SQL_

#### _This is an application to list out local shoe stores and the brands of shoes that they carry. The user can update and delete a store's name. Also a user can add stores and brands, and be able to modify which stores carry a particular brand, September 30, 2016_

#### By _**Stephen Burden**_

## Specifications
| Behavior | Input Ex. | Output Ex. |
| --- | --- | --- |
| Create Store name, to display and record in database  | "Foot Locker"  |  "Foot Locker" |
| Retrieve a Store's Brands | "Foot Locker"  | "Nike", "Adidas" |
| Update Store name in database | "Big 5"  | "Big 5" |
| Remove Store from database |  Remove "Big 5" from database containing "Big 5" & "Foot Locker" | "Foot Locker" |
| Retrieve Stores that hold a certain Brand  | "Nike" |  "Foot Locker" |
| Add Stores that carry a certain Brand | "Big 5" | "Big 5, Foot Locker" |

## Setup/Installation Requirements
* _Clone the repository from the link below to your desktop_
* _Run Composer Install to include all dependencies_
* _Download and install a program named 'MAMP' on your system_
* _Open MAMP and select Start Servers OR on terminal enter the command: apachectl start_
* _To access the MySQL shell at Epicodus, open the bash terminal and run: mysql.server start followed by the command mysql -uroot -proot
* _To access the database admin page use your browser to open localhost:8080/phpmyadmin, or localhost:8888/phpmyadmin depending on your networks settings with the user:root and password:root_
* _In Terminal or Command Prompt go to the /web directory and enter the command: php -S localhost:8000_
* _To browse the website go to http://localhost:8000/ in the browser of your choosing_
* _If the server's database is not functioning: change the server number in the app file to match your MySQL Port number in MAMP (Preferences... -> Ports). EXAMPLE: 'mysql:host=localhost:8889;dbname=shoes' OR uncomment out the 'ALTERNATIVE SERVER' in the app file and comment out the other._

## MySQL commands ran for project:
* _/Applications/MAMP/Library/bin/mysql --host=localhost -uroot -proot_
* _SELECT DATABASE();_
* _CREATE DATABASE shoes;_
* _SHOW DATABASES;_
* _USE shoes;_
* _CREATE TABLE stores (id serial PRIMARY KEY, name VARCHAR (255));_
* _CREATE TABLE brands (id serial PRIMARY KEY, name VARCHAR (255), brand_id INT);_
* _CREATE TABLE stores_brands (id serial PRIMARY KEY, store_id INT, brand_id INT);_

## Link
https://github.com/spburden/shoe-store-php-sql

## Known Bugs
_There are no known bugs with this application._

## Support and contact details
_spburden@hotmail.com_

## Technologies Used
_PHP, MySQL, MAMP, Silex, Twig, PHP Unit, HTML, and Bootstrap_

### License
The MIT License (MIT)

Copyright (c) 2016 **_Stephen Burden_**
