About
=====
This is a "simple" to install mooSocial Trial version on your local, vps.

Installation Instruction
=====
### Install Docker 
Please go to this link and select your platform OS to install Docker https://docs.docker.com/engine/install/

### Run mooSocial Trial
Step 1: go to folder mooSocial trial with terminal/powershell

Example: 

`cd /var/www/mooSocial-Trial/`

or

`cd D:\Data\mooSocial-Trial`

Step 2: Run with docker
`docker compose up --build`

### Install mooSocial Trial
After Run mooSocial Trial, Please go to http://localhost to install mooSocial
Use this information to connect mysql:

Database Host: `your ip` (Ex: 192.168.1.60)

Database Username: `root`

Database Password: `secret`

Database Name: `moosocial_trial`

Unix Socket: `3306`

*** You can change Username, Password, Database Name, Unix Socket (port) in docker-compose.yaml file
