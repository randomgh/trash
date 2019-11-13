# Wordpress project init

1. Create new GITHUB repo.
    [https://github.com/new](https://github.com/new)\
    Owner: Messapps\
    Repository name: {project}\
    Description: {wrike project name}\
    Visibility: Private\
    Initialize this repository with a README: yes\
    .gitignore: None\
    License: Apache License 2.0

2. Clone repo to your machine.
    ```bash
    git clone ...
    ```

3. Make gitflow branches
    ```bash
    git checkout -b develop
    git checkout -b feature/init
    ```

4. Download latest Wordpress and unpack to project folder
5. Launch project in browser to setup Wordpress settings
6. Remove all plugins from `wp-content/plugins/`
7. Remove all themes from `wp-content/themes/`
8. Checkout Wordpress boilerplate to project folder
9. Customize boilerplate regarding project
    1. rename theme folder`wp-content/themes/{project}`
    2. rename `env` to `.env` and edit
    3. `wp-content/themes/{project}/style.css`
    4. `package.json`
    5. replace `wp-content/themes/{project}/screenshot.png`
    6. in all php files replace 'madtd' with theme text domain
    7. run test gulp production build
10. pull request `feature/init` to `develop`
11. run new server instance with ***Ubuntu 18.04 LTS***
12. go through [LAMP.md](/server/Ubuntu%2018.04%20LTS/LAMP.md)
13. go through [phpMyAdmin.md](/server/Ubuntu%2018.04%20LTS/phpMyAdmin.md)
14. go through [Wordpress.md](/server/Ubuntu%2018.04%20LTS/Wordpress.md)
15. go through [GitHub.md](/server/Ubuntu%2018.04%20LTS/GitHub.md)
16. merge pull request to develop
17. copy and edit `.env` and `wp-config.php` files to each branch folder