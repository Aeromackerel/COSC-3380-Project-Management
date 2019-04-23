Project Management Web-APP

Minimalistic project management app with role-based views

Built on : PHP, HTML5/CSS, SQL-DB, Some JS scripts

Utilizing Bootstrap4 CSS sheet

Description: web-based application meant to streamline contemporary problems within managing projects.

1) Git Clone https://github.com/Aeromackerel/Project-Management-Project.git

2) Navigate to Project-Management-Project/front-end

3) Use CMD terminal "cd .../Project-Management-Project/front-end" to set current directory

4) php -S localhost:8000 (whatever port really)

5) Connect to localhost:8000/home.php using your web browser

6) Log in using either 
email : genUser@gmail.com	password : mango90 (General Employee ACCESS)
email : groupManager@gmail.com password : 12345(Group Manager ACCESS)
email : projectManager@gmail.com password: 12345 (Project Manager ACCESS)

If you're having problems finding driver

https://github.com/Microsoft/msphpsql

CHECK your php version if it's the latest then use the following (latest version = PhP 7.2.(whatever number)

Download the driver from here

navigate to -> php.ini file and insert the following

extension=php_sqlsrv_72_ts
extension=php_pdo_sqlsrv_72_ts

if that doesn't work then use the nts version
