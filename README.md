Simple RESTful API using PHP 7+ has 3 resources: 
 * POST /auth​ -- to authenticate user
 * GET /users​ -- to output list of users with pagination
 * DELETE /auth​ -- to logout user
 
MySQL database has two tables:
 * api_users​ -- table to store username and password which is used to log in to the app
 * students​ -- list of people which to be shown once user is logged in
 
Installing:
 1 import kc.sql file in your DataBase
 2 api/config/database.php fill in your data to connect to DataBase
 3 execute index.html (test login: user1, password: 123456) 
