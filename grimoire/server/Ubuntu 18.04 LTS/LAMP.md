# LAMP

update the list of available packages
```bash
sudo apt update
```

## Apache

### installation

install apache
```bash
sudo apt install apache2
```

firewall rules
```bash
sudo ufw allow in "Apache Full"
```

## MySQL

### installation

install mysql server
```bash
sudo apt install mysql-server
```

### configuration

configure mysql
```bash
sudo mysql_secure_installation
```

while configuration you will be asked several questions.
use some [password generator](https://passwordsgenerator.net/) to get secure passwords.
```bash
...
...Would you like to setup VALIDATE PASSWORD plugin?
> y

There are three levels of password validation policy:
...
> 2

New password:
> {password}

Re-enter new password:
> {password}

Do you wish to continue with the password provided?
> y

...

Remove anonymous users?
> y

...

Disallow root login remotely?
> y

...

Remove test database and access to it?
> y

...

Reload privilege tables now?
> y

...
All done!
```

enter mysql
```bash
sudo mysql
```

set password for *root* user
```mysql
ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY '{password}';
```

create additional user *www-data* for apache actions
```mysql
CREATE USER 'www-data'@'localhost' IDENTIFIED WITH mysql_native_password BY '{password}';
FLUSH PRIVILEGES;
```

exit mysql
```mysql
exit;
```

## PHP

### installation

install php and modules
```bash
sudo apt install php libapache2-mod-php php-mysql php-curl php-gd php-mbstring php-xml php-xmlrpc
```

### configuration

change ***index.php*** priority
```bash
sudo vi /etc/apache2/mods-enabled/dir.conf
```

WAS
```apacheconfig
<IfModule mod_dir.c>
    DirectoryIndex index.html index.cgi index.pl index.php index.xhtml index.htm
</IfModule>
```

BECOME
```apacheconfig
<IfModule mod_dir.c>
    DirectoryIndex index.php index.html index.cgi index.pl index.xhtml index.htm
</IfModule>
```

enable ***rewrite*** module
```bash
sudo a2enmod rewrite
```

edit default apache configuration
```bash
sudo vi /etc/apache2/apache2.conf
```

add project directory to the ***directories*** section
```apacheconfig
<Directory /var/www/{project}/>
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>
```

create project directory and change owner
```bash
sudo mkdir /var/www/{project}/
sudo chown -R www-data:www-data /var/www/
```

restart apache
```bash
sudo apache2ctl configtest
sudo systemctl restart apache2
sudo systemctl status apache2
```

disable default apache site
```bash
sudo a2dissite 000-default
sudo rm -rf /var/www/html
```