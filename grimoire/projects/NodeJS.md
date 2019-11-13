# NodeJS project init

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

4. Checkout NodeJS boilerplate to project folder
5. Edit `package.json` and install `npm i`
6. pull request `feature/init` to `develop`
7. run new server instance with ***Ubuntu 18.04 LTS***
8. go through [NodeJS.md](/server/Ubuntu%2018.04%20LTS/NodeJS.md)
9. go through [GitHub.md](/server/Ubuntu%2018.04%20LTS/GitHub.md)
10. merge pull request to develop
11. copy and edit `.env` files to each branch folder