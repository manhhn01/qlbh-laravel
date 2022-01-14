- sudo apt install php7.4-mbstring
- sudo apt install php7.4-dom
- composer install

- docker run -it --name mysql_laravel -p 3306:3306 -e MYSQL_ROOT_PASSWORD=root mysql
- docker start mysql_laravel
- mysql -h 127.0.0.1 -P 3306 --protocol=tcp -u root -p   
