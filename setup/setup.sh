#!/bin/bash
#commands which use the mysql_password have a space beforehand to remove them from bash history, just in case

 echo "Password to use for MySQL root account: "
 read mysql_password

echo "Beginning installation"
#update packages to make sure the install goes properly
echo "Updating APT"
sudo apt update > /dev/null

#install Apache2, PHP, and MySQL
echo "Installing packages"
sudo apt install apache2 -y > /dev/null
sudo apt install php7.2 -y > /dev/null
sudo apt install php7.2-mysql -y > /dev/null
sudo apt install mysql -y > /dev/null

#set up MySQL server
echo "Setting up MySQL server"
#update password in the PHP 'database.php' file
 cat /var/www/html/database.php | sed s/CHANGEME/$mysql_password/ | sudo tee /var/www/html/database.php
#proceed with the MySQL secure installation
 printf "$mysql_password\nN\nN\nY\nY\nY\nY\n" | sudo mysql_secure_installation > /dev/null


#creating database for SocialBook
echo "Creating SocialBook database"
 mysql -u root -p"$mysql_password" -e "`cat Create_SocialBook_DB.sql`" > /dev/null

#turn on website services
echo "Standing up website"
sudo a2enmod php7.2 > /dev/null
sudo systemctl enable mysql > /dev/null
sudo systemctl start mysql > /dev/null
sudo systemctl enable apache2 > /dev/null
sudo systemctl start apache2 > /dev/null

#unset variables
 unset mysql_password

echo "Installation Complete!"