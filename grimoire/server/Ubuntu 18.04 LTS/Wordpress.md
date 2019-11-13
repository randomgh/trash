# Wordpress

### configuration

#### MySQL

enter mysql with root
```bash
mysql -u root -p

Enter password:
> {password}
```

create 2 new databases for each branch
```mysql
CREATE DATABASE {project}_{branch} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

grant privileges on databases to *www-data*
```mysql
GRANT ALL PRIVILEGES ON {project}_{branch}.* TO 'www-data'@'localhost';
FLUSH PRIVILEGES;
```

exit mysql
```mysql
exit;
```

#### Apache

create 2 new configurations for each branch
```bash
sudo vi /etc/apache2/sites-available/{project}_{branch}.conf
```

use 80 port for master branch and 8080 for develop
```apacheconfig
<VirtualHost *:{port}>
	ServerAdmin {email}
	DocumentRoot /var/www/{project}/{branch}

	ErrorLog ${APACHE_LOG_DIR}/{project}_{branch}-error.log
	CustomLog ${APACHE_LOG_DIR}/{project}_{branch}-access.log combined

    <Directory /var/www/{project}/{branch}/>
        Options Indexes FollowSymLinks MultiViews
        AllowOverride all
        Order allow,deny
        allow from all
        Require all granted

        <IfModule php7_module>
            php_value upload_max_filesize 128M
            php_value post_max_size 128M
        </IfModule>
    </Directory>
</VirtualHost>
```

add 8080 port to apache listened ports
```bash
sudo vi /etc/apache2/ports.conf
```

add row after `Listen 80`
```apacheconfig
Listen 8080
```

enable 2 sites and restart apache
```bash
sudo a2ensite {project}_{branch}
sudo apache2ctl configtest
sudo systemctl restart apache2
sudo systemctl status apache2
```