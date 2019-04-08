#!/bin/bash
#commands which use the mysql_password have a space beforehand to remove them from bash history, just in case

echo "Beginning installation"
#update packages to make sure the install goes properly
echo "Updating APT repositories"
sudo apt-get update > /dev/null #update repository information to ensure the packages can be installed

#install Apache2, PHP, and MySQL
echo "Installing packages"
sudo apt-get install apache2 -y &> /dev/null #apache2 is the web server itself
sudo apt-get install php7.* -y &> /dev/null #installing everything due to issues with different Linux distros
sudo apt-get install php7.*-mysql -y &> /dev/null #ensuring mysqli was installed with the previous command
sudo apt-get install mariadb-server -y &> /dev/null #install mariadb since that is better supported afaik

echo "Attempting to sync local files with GitHub repository"
sudo git -C /var/www/html/ fetch origin &> /dev/null
sudo git -C /var/www/html/ reset --hard origin/master &> /dev/null

#set up MySQL server
echo "Setting up MySQL server"
 mysql_password=`head /dev/urandom | tr -dc 'A-Za-z0-9#&()*+,-.:;<=>?@[\]^_{|}~' | head -c 24`
#update password in the PHP 'database.php' file
 cat /var/www/html/database.php | sed "s/\$mysql_password = \"[^\"]*\";/\$mysql_password = \"$var\";/" | sudo tee /var/www/html/database.php > /dev/null
#non-interactive mysql secure installation
 sudo /etc/init.d/mysql stop &> /dev/null #ensure mysql is stopped
 sudo pkill -9 mysqld &> /dev/null #ensure mysql daemon is fully shutdown
 sleep 0.5
 sudo mysqld_safe --skip-grant-tables --skip-networking & &> /dev/null #start mysql daemon without checking passwords
 sleep 1 #lazy way to wait for mysql daemon to start
#update root password with the randomly generated password
 sudo mysql -u root -e "UPDATE mysql.user SET plugin='mysql_native_password', Password=PASSWORD(\"$mysql_password\") WHERE User='root'; FLUSH PRIVILEGES;" > /dev/null
 sleep 0.5 #making sure the query has time to execute and change the password
 sudo pkill -9 mysqld &> /dev/null #kill mysql daemon that doesn't check passwords
 sudo /etc/init.d/mysql start > /dev/null #start mysql with the new password
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
 mysql -u root -p"$mysql_password" -e "`cat /var/www/html/setup/*.sql`" #will run any .sql files that are part of the setup

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
