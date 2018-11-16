# Wordpress Installation

```text
CREATE USER 'user'@'localhost' IDENTIFIED BY 'userpw';
GRANT ALL ON wordpress.* TO 'WPElmo'@'localhost' IDENTIFIED BY 'userpw' WITH GRANT OPTION;
FLUSH PRIVILEGES;
EXIT;
cd /tmp && wget https://wordpress.org/latest.tar.gz
tar -zxvf latest.tar.gz
sudo mv wordpress /var/www/html/wordpress


sudo nano /etc/apache2/sites-available/wordpress.conf

sudo systemctl restart apache2.service

sudo chown -R www-data:www-data /var/www/html/wordpress/
sudo chmod -R 755 /var/www/html/wordpress/

sudo mv /var/www/html/wordpress/wp-config-sample.php /var/www/html/wordpress/wp-config.php
```

