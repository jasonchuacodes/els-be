# Jason's ELS Project

This ELS Project is a Learning Management System built to showcase what I have learned during the training phase in Sun Asterisk.
 
 
## Built with
* PHP
* Laravel
* MySQL

The notable learnings that I had in creating this project is working with the MVC model in Laravel. 
I learned how to setup controllers, create CRUD functions, and how to work with model relationships to fetch and post data into the database.

## Description

The main functionalities that are implemented in the LMS app are the following:

#### Auth
* user_registration
* user_email_verification with Mailtrap
* user_authentication

#### Lesson
* display lesson categories and description from database
* auth_user taking lessons
* auth_user answering question_set
* auth_user display lesson question_set score

#### Follow
* auth_user follow/unfollow users

#### Activity
* lesson_activity log
* follow_activity log
* display user_activity logs

#### Admin 
To be added in future update:
  * lessons - add, edit, delete lesson info
  * users - add, edit, delete user info

## Getting Started


### Installing

* Download the .zip file at the github repo or clone by running the command 

`git clone git@github.com:jasonchuacodes/els-be.git`


### Executing program

#### Prerequisites

* create the MySQL database and name it as `els_db`

* go to the els-be directory `cd els-be` 
* setup the `.env` file 
`DB_DATABASE = els_db`

* setup the credentials for Mailtrap:
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=<mailtrap_username>
MAIL_PASSWORD=<mailtrap_password>
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}" 
```
* create the tables and seed by running the command
`php artisan migrate --seed`

* finally, run the command
`php artisan serve`


## Authors

Contributors names and contact info

Jason Clyde Chua [@jasonclchua](https://facebook.com/jasonclchua)

## Acknowledgments

Special thanks to my mentors who have taught me the skills on how to solve various problems while I was in the process of developing this app.

* John Paul Banera
* Joshua Escarilla
* Ejanton Potot
* Jeremiah Caballero
