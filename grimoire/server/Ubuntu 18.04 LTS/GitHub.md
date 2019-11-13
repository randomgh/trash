# GitHub

### configuration

```bash
cd /var/www/
sudo mkdir .ssh
sudo chown -R www-data:www-data /var/www/
sudo -u www-data ssh-keygen -t rsa -b 4096 -C "{hostname}"
```

while configuration you will be asked several questions.
```bash
Enter file in which to save the key
> /var/www/.ssh/{project}_rsa

Enter passphrase
> {empty is fine}

Enter same passphrase again
> {passphrase}
```

create ssh configuration
```bash
sudo vi /var/www/.ssh/config
```

add the following
```ini
Host {project}.github.com
HostName github.com
IdentityFile ~/.ssh/{project}_rsa
```

change files owner and permissions
```bash
sudo chown -R www-data:www-data /var/www/
sudo chmod 600 /var/www/.ssh/config
sudo chmod 600 /var/www/.ssh/{project}_rsa
sudo chmod 600 /var/www/.ssh/{project}_rsa.pub
```

copy key and create new deploy key named {hostname} in repo settings
```bash
sudo cat /var/www/.ssh/{project}_rsa.pub
```

go to project folder and perform git clone
```bash
cd /var/www/{project}/
sudo -u www-data git clone git@{project}.github.com:Messapps/{project}.git
```

go to repo folder, change repo url and `.git` folder permissions
```bash
cd /var/www/{project}/{project}/
sudo -u www-data git remote set-url origin git@{project}.github.com:Messapps/{project}.git
sudo chmod -R g+w .git
```

make 2 copies of the repo for each branch
```bash
cd /var/www/{project}
sudo cp -rp /var/www/{project}/{project} /var/www/{project}/develop
sudo mv /var/www/{project}/{project} /var/www/{project}/master
sudo chown -R www-data:www-data /var/www/
cd /var/www/{project}/develop/
sudo -u www-data git checkout develop
```

### webhook handler

create webhook with url *http://{hostname}:88* in repo settings

#### Apache

create new configuration for webhook
```bash
sudo vi /etc/apache2/sites-available/git.conf
```

```apacheconfig
<VirtualHost *:88>
	ServerAdmin {email}
	DocumentRoot /var/www/git

	ErrorLog ${APACHE_LOG_DIR}/git-error.log
	CustomLog ${APACHE_LOG_DIR}/git-access.log combined

    <Directory /var/www/git/>
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

add 88 port to apache listened ports
```bash
sudo vi /etc/apache2/ports.conf
```

add row after `Listen 80`
```apacheconfig
Listen 88
```

create folder, copy and edit [php webhook files](/boilerplates/github/php) and change owner
```bash
sudo mkdir /var/www/git
sudo chown -R www-data:www-data /var/www/
```

enable 2 sites and restart apache
```bash
sudo a2ensite git
sudo apache2ctl configtest
sudo systemctl restart apache2
sudo systemctl status apache2
```


#### NodeJS

create folder, copy and edit [nodejs webhook files](/boilerplates/github/nodejs) and change owner
```bash
sudo mkdir /var/www/git
sudo chown -R www-data:www-data /var/www/
cd /var/www/git
sudo -H -u www-data npm i
sudo chown -R www-data:www-data /var/www/
```

create new service
```bash
sudo vi /etc/systemd/system/git.service
```

```dotenv
[Unit]
Description=Github webhook handler
After=network.target

[Service]
Type=simple
User=www-data
WorkingDirectory=/var/www/git/
ExecStart=/usr/bin/npm run start
Restart=on-failure
RestartSec=10
StandardOutput=syslog
StandardError=syslog
SyslogIdentifier=git

[Install]
WantedBy=multi-user.target
```

enable and start service
```bash
sudo systemctl enable git.service
sudo systemctl start git
sudo systemctl status git
```

grant permissions to *www-data* group to control service
```bash
sudo visudo
```

add the following line
```ini
%www-data       ALL=NOPASSWD:/usr/sbin/service git *  
```