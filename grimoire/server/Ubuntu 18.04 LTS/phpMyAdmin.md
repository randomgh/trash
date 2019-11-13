# phpMyAdmin

### installation

install pma and required php modules
```bash
sudo apt install phpmyadmin php-mbstring php-gettext
```

while install you will be asked several questions.
use some [password generator](https://passwordsgenerator.net/) to get secure passwords.
```bash
Please choose the web server that should be automatically configured to run phpMyAdmin.
...
> apache2

...
Configure database for phpmyadmin with dbconfig-common?
> Yes

...
MySQL application password for phpmyadmin:
> {password}

Re-enter password:
> {password}
```

enable ***mbstring*** module
```bash
sudo phpenmod mbstring
```

### configuration

make link to pma conf file and open it
```bash
sudo ln -s /etc/phpmyadmin/apache.conf /etc/apache2/sites-available/phpmyadmin.conf
sudo vi /etc/apache2/sites-available/phpmyadmin.conf
```

add to the beginning of the file
```apacheconfig
<VirtualHost *:8888>
    ServerAdmin {email}
    DocumentRoot /usr/share/phpmyadmin

    ErrorLog ${APACHE_LOG_DIR}/pma-error.log
    CustomLog ${APACHE_LOG_DIR}/pma-access.log combined
```

and remove row
```apacheconfig
Alias /phpmyadmin /usr/share/phpmyadmin
```

add to the end of the file
```apacheconfig
    <IfModule php7_module>
        php_value upload_max_filesize 64M
        php_value post_max_size 64M
    </IfModule>
</VirtualHost>
```

add *8888* port to apache listened ports
```bash
sudo vi /etc/apache2/ports.conf
```

add row after `Listen 80`
```apacheconfig
Listen 8888
```

enable pma site and restart apache
```bash
sudo a2ensite phpmyadmin
sudo apache2ctl configtest
sudo systemctl restart apache2
sudo systemctl status apache2
```