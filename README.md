# SocialBook
#### The vulnerable Web App for Penetration Test simulations

## Warning
This application is vulnerable, do NOT make it internet facing! This is meant for internal use only, preferably on a virtual machine. You assume full responsibility for any consequences that result from using this software.

## Installation
**Requires a Linux OS**, preferably Ubuntu 18.04 LTS. Tested to work on Kali Linux (Debian 9)

Run the following commands to install the pre-requisites and setup SocialBook on your machine. These commands may need to be changed depending on your operating system.
```bash
sudo mkdir /var/www/html
cd /var/www/html
sudo rm -rf *
sudo git clone https://github.com/Sevaarcen/SocialBook.git /var/www/html
sudo bash ./setup/install.sh
```

One it's installed, you can create a new account
```
Default admin credentials
Username: admin
Password: c0nn3ction$
```

### Requirements
Please refer to the **Installation** section. If installing from the script, no need to install the requirements beforehand.
* Linux OS (Ubuntu 18.04 LTS recommended)
* Apache2 (tested on version 2.4.29-1ubuntu4.5)
* php7.X with mysqli (tested on php7.2 and php7.3)
* mariadb (tested on version 10.3.12)
