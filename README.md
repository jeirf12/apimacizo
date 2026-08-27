# Project Web - Api Macizo
This project is based to raise awareness about beekeeping and its various products that are obtained by hand, and are located in the Colombian
massif as an alternative to counteract the effects of illicit crops, bringing together a large community of 133 beekeepers of which 18 are women.

# Pre-Requisites
Before installing the local configuration you must configure the `custom.ini` file with the following:
```
post_max_size = 16M
upload_max_filesize = 16M
```
In addition, the `.env` file must be configured for the application environment variables:
```
HOST=[url-app]
PORT=[port-app]
DB_HOST=[url-host-database]
DB_PORT=[port-host-database]
DB_USERNAME=["username-database"]
DB_PASSWORD=["password-database"]
DB_NAME=["apimacizo"]
GOOGLE_IDCLIENT=["id-client-api-google"]
GOOGLE_SECRET_KEY=["secret-key-api-google"]
GOOGLE_REDIRECT_RESOURCE=["index.php?c=Sesion&a=ApiGoogle"]
EMAIL_PAGE=["email-admin-google"]
PASSWORD_EMAIL_PAGE=["password-app-google"]
EMAIL_PORT=["port-communication-smtp"]
```
Note: The brackets must be removed and the corresponding values must be inserted.

# Configuration local
First you must have the following technologies:
* [Php](https://www.php.net/downloads.php)
* [Composer](https://getcomposer.org/download/)
* [Xampp](https://www.apachefriends.org/download.html)
***
The next step is to install the dependencies with the command:
```
  composer install
```
Note: You must be located in the root of the project and open the terminal according to your operating system.  
***
After having installed the dependencies, we load the `bbd.sql` database script into the `xampp` program.  
Note: You must have the `xampp` program running, otherwise activate `apache` and `mysql`.  
***
Finally open the browser and enter the following:
```
  localhost/apimacizo/
```
