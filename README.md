### Application with REST API & simple GUI without page reloading

Application allows to see 45 user's information records with photo by portion of 6 records. In start
is viewed 6 portions. To see next 6 portions is needed to press button "Show more" and etc. There is
able to see exact user record by user id, it is needed to press to id of user. There is is able to
register a new user, to do it is needed to press "Register" button and insert user's info, select
user's job position and his photo. To register a new user it is provided 40 minutes. If the time is out 
of the limit it is needed to reload the page, for taking a new token and new 40 minutes for registration
process. Application handles validation errors, errors clicked to not existed page, errors if the user 
with inputted email or phone has already registered.

#### Used:
* Stack: PHP, Laravel, MySQL, HTML, JS, JQuery, Composer, Docker
* Foreign service: Image file handler service "TinyPNG"
* Technologies: JWT, JSON
* Additional libraries: tymon/jwt-auth, tinify/tinify, DataTables 

### How to run:
* Clone the repository ```https://github.com/AlexKhranovskiy/test-a```
* Copy content from .env.example file to .env file
* Run ```docker-compose up -d```
* Run ```composer install```
* Run ```php artisan optimize```
* Run ```php artisan config:clear```
* To exit, run ```make down```

Local web is available here: [http://localhost:8080](http://localhost:8080)



