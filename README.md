# Laravel Docker Boilerplate

This repository contains the latest Laravel 7.x framework bundled inside a docker container running on Nginx / PHP-FPM (php v7.3.x).

### Installation

1. git clone git@bitbucket.org:mvfglobal/velolog.git
2. cd velolog
3. make rebuild

> The application will be accessible via this url: http://localhost:11111

> The dev mysql server can be accessed on localhost port 33333 (user: root or velolog / pass: 123456)

### Linux OS Specific Notes

* One of the issue this boiler plate addresses is the issue with file permission of the running container
* To ensure laravel can create files (e.g. inside `storage` folder), the docker runs under a custom user using your local machine UID/GID
* To make sure this works correctly for you, run the command `id` in terminal & you should see your local user's UID/GID in your linux OS
* Make sure the UID/GID specified in `Dockerfile` matches your own, we default to `1000`

### Documentation / Notes

* Laravel specific files are placed inside `application` folder
* PHP Configuration can be found in `php` dir
* Nginx configuration cab be found in `nginx` dir
* Most of the automation are done via the `Makefile` - see below for available commands
* The public port of the application can be changed from `11111` to anything you need by editing the `docker-compose.yml` file
* We don't use laravel's `.env` file, instead we use the docker environment file from `env/development`

### Available Make Commands

* **rebuild** - Rebuild the containers and start it up again
* **down** - Brings down the containers
* **restart** - Restarts the containers
* **status** - Shows current status of the containers, e.g. _Name, Command, State and Ports_
* **shell** - Drops you into a bash shell inside the container running the application
* **stats** - Shows statistics (e.g. CPU utilisation, memory usage, net I/O etc...) of your container
* **logs** - Trails the stdout/stderr and other logs out of your containers
* **refresh-db** - Re-runs the db migrations (fresh mode) and runs all the seeders
