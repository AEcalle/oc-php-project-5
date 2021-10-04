# PHP blog
PHP blog project as part of training course "Application Developer - PHP / Symfony" on OpenClassrooms.
## Prerequisites
*   PHP 7.4.9
*   MySQL 8.0.21
*   Apache/2.4.46
*   SMTP server
## Installation
Copy project on your system
```bash
git clone https://github.com/AEcalle/oc-php-project-5.git
```
Install dependencies
```bash
composer install
```

### Create Database
*   Create MYSQL database
*   Import blog.sql file

### Configure environment variables

Replace the values in .env with your own values to configure database connection
```
DB_HOST=host_name
DB_NAME=db_name
DB_USERNAME=username
DB_PASSWORD=password
```

Replace the values in .env with your own values to configure SMTP connection
```
SMTP_HOST=host
SMTP_USERNAME=username
SMTP_PASSWORD=password
```

Replace the URL_SITE value in .env with your domain
```
URL_SITE=http://blog/
```
### Configure Server
#### With PHP server
Run this command
```
php -S localhost:8000 -t public
```
#### With Apache
Create a virtual host in apache2.4.46\conf\extra\httpd-vhosts.conf
```
#
<VirtualHost *:80>
	ServerName blog
	DocumentRoot "path-to-your-project/public"
	<Directory  "path-to-your-project/public/">
		Options +Indexes +Includes +FollowSymLinks +MultiViews
		AllowOverride All
		Require local
	</Directory>
</VirtualHost>
#
```

### Create your admin profile
*   Register here : your-domain/createUser
*   Update your user role in database with "admin" value
