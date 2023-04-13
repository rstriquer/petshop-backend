# Pet Shop (Backend API)

A simple pet shop api backend

Autor: [@rstriquer](https://gist.io/@rstriquer/4e8012db1a55bebdc99672d2d178bbaa/)

Licence: [MIT](https://choosealicense.com/licenses/mit/)

## Used Stack

-   **Back-end:** Laravel 10
-   **Infrastructure:** Docker 20

Docker will download and instantiate a Mysql 5.7 and a php 8.2 container into
your environment.

It uses a [rstriquer/php-fpm.dev](https://hub.docker.com/r/rstriquer/php-fpm.dev)
docker image hosted at [hub.docker.com](https://hub.docker.com). It should work
out of the box but if needed you can find the Dockerfile in the
[php-fpm.dev github repository](https://github.com/rstriquer/docker-dev.php-fpm/tree/8.2-dev)
and build it as instructed there.

## Install

First of all you need to clone the repository and create your own .env file. For that you can just run like bellow:

```bash
git clone git@github.com:rstriquer/petshop-backend.git
cd petshop-backend
cp .env.example .env
```

**IMPORTANT**: the next step (running the docker container) may take a few minutes therefore please give it a few moments (like 3 to 5 minutes - for it is building the database) before carry on the execution.

Then you need to access the cloned repository and start docker with the command `docker-compose up -d`.

Once you have done that you can run the mysql commands to grant privileges to the user

```bash
mysql -h 127.0.0.1 --port 3306 -u root -p12345678 -e "CREATE DATABASE petshop_dev; GRANT ALL PRIVILEGES ON petshop_dev.* TO 'petshop'@'%' IDENTIFIED BY '12345678';"
```

Finaly you run the sequence ....

```bash
composer install
./artisan key:generate
./artisan migrate:install
./artisan migrate --seed
```

If you whish you can populate the database with some lines with the seeder running `./artisan db:seed`
