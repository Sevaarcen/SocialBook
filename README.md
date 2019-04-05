# SocialBook
#### The vulnerable Web App for Penetration Test simulations

## Warning
This application is vulnerable, do NOT make it internet facing! This is meant for internal use only, preferably on a virtual machine. You assume full responsibility for any consequences that result from using this software.

## Installation
**Requires a Linux OS**, preferably Ubuntu 18.04 LTS

Run the following commands to install the pre-requisites and setup SocialBook on your machine. These commands may need to be changed depending on your operating system.
```bash
sudo mkdir /var/www/html
cd /var/www/html
sudo rm -rf *
sudo git clone https://github.com/Sevaarcen/SocialBook.git /var/www/html
sudo bash ./setup/install.sh
```

One it's installed, you can login to the website using the following credentials:
```
Username: admin
Password: c0nn3ction$
```

### Requirements
Please refer to the **Installation** section. If installing from the script, no need to install the requirements beforehand.
* Linux OS (Ubuntu 18.04 LTS recommended)
* Apache2 (tested on version 2.4.29-1ubuntu4.5)
* php7.2 with mysqli
* mysql (tested on version 14.14)
