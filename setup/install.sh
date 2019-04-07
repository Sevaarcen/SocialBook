#!/bin/bash
#commands which use the mysql_password have a space beforehand to remove them from bash history, just in case

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
sudo apt-get install apache2 -y 2> /dev/null
sudo apt-get install php7.* -y 2> /dev/null
sudo apt-get install php7.*-mysql -y 2> /dev/null
sudo apt-get install mariadb-server -y 2> /dev/null

#set up MySQL server
echo "Setting up MySQL server"
 mysql_password=`head /dev/urandom | tr -dc 'A-Za-z0-9#&()*+,-./:;<=>?@[\]^_{|}~' | head -c 24`
#update password in the PHP 'database.php' file
 cat /var/www/html/database.php | sed s/CHANGEME/$mysql_password/ | sudo tee /var/www/html/database.php > /dev/null
#non-interactive mysql secure installation
#change password
 sudo mysqld_safe --skip-grant-tables --skip-networking & > /dev/null
#update root password with the randomly generated password
 sudo mysql -u root -e "UPDATE mysql.user SET plugin='mysql_native_password', Password=PASSWORD(\"$mysql_password\") WHERE User='root'; FLUSH PRIVILEGES;" > /dev/null
 sudo /etc/init.d/mysql start  > /dev/null
#delete anonymous users
 mysql -u root -p"$mysql_password" -e "DELETE FROM mysql.user WHERE User='';" > /dev/null
#remove ability for remote root login
 mysql -u root -p"$mysql_password" -e "DELETE FROM mysql.user WHERE User='root' AND HOST NOT IN ('localhost', '127.0.0.1', '::1');" > /dev/null
#delete any test databases
 mysql -u root -p"$mysql_password" -e "DROP DATABASE IF EXISTS test;" > /dev/null
 mysql -u root -p"$mysql_password" -e "DELETE FROM mysql.db WHERE Db='test' OR Db='test\\_%';" > /dev/null
#update any provilege changes
 mysql -u root -p"$mysql_password" -e "FLUSH PRIVILEGES;" > /dev/null


#creating database for SocialBook
echo "Creating SocialBook database"
 mysql -u root -p"$mysql_password" -e "`cat /var/www/html/setup/Create_SocialBook_DB.sql`"

#turn on website services
echo "Standing up website"
sudo chown -R www-data:www-data /var/www/html
sudo a2dismod php* > /dev/null
sudo a2enmod php7.* > /dev/null
sudo /etc/init.d/mysql restart
sudo /etc/init.d/apache2 start

#unset variables
 unset mysql_password

echo "Installation Complete!"
