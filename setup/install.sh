#!/bin/bash
#commands which use the mysql_password have a space beforehand to remove them from bash history, just in case

 echo "Password to use for MySQL root account: "
 read mysql_password

echo "Beginning installation"
#update packages to make sure the install goes properly

#echo "Would you like to add the PHP7.2 repository (this is needed on some systems, like Debian) [Y/n]: "
#read resp
#if [[ "$resp" =~ ^([yY][eE][sS]|[yY])+$ ]]
#then
#  sudo apt-get install apt-transport-https lsb-release ca-certificates > /dev/null
#  wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
#  echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list
#fi
echo "Updating APT repositories"
sudo apt-get update > /dev/null

#install Apache2, PHP, and MySQL
echo "Installing packages"
sudo apt-get install apache2 -y > /dev/null
sudo apt-get install php7.* -y > /dev/null
sudo apt-get install php7.*-mysql -y > /dev/null
sudo apt-get install mysql-server -y > /dev/null

#set up MySQL server
echo "Setting up MySQL server"
#update password in the PHP 'database.php' file
 cat /var/www/html/database.php | sed s/CHANGEME/$mysql_password/ | sudo tee /var/www/html/database.php > /dev/null
#proceed with the MySQL secure installation
 printf "$mysql_password\nN\nN\nY\nY\nY\nY\n" | sudo mysql_secure_installation > /dev/null


#creating database for SocialBook
echo "Creating SocialBook database"
 mysql -u root -p"$mysql_password" -e "`cat /var/www/html/setup/Create_SocialBook_DB.sql`" > /dev/null

#turn on website services
echo "Standing up website"
sudo chown -R www-data:www-data /var/www/html
sudo a2dismod php* > /dev/null
sudo a2enmod php7.* > /dev/null
sudo /etc/init.d/mysql start
sudo /etc/init.d/apache2 start

#unset variables
 unset mysql_password

echo "Installation Complete!"
