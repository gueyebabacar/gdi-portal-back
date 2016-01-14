# -*- mode: ruby -*-
# vi: set ft=ruby :

############################### SCRIPT ###############################

$scriptCommunDebian8 = <<SCRIPT

    echo "[Common] Update system..."
        apt-get update -y
        apt-get upgrade -y
        apt-get install -y -f vim nano wget curl htop telnet rsync lynx

    echo "[Apache/PHP/Mysql] Install..."
        echo mysql-server mysql-server/root_password password c4rm4r00t | sudo debconf-set-selections
        echo mysql-server mysql-server/root_password_again password c4rm4r00t | sudo debconf-set-selections

        #Apache
        apt-get install -y -f apache2-mpm-prefork
        #MySQL
        apt-get install -y -f mysql-server
        #PHP
        apt-get install php5-common -y -f
        apt-get install php5-cli -y -f
        apt-get install php5-dev -y -f
        apt-get install php5-curl -y -f
        apt-get install php5-gd -y -f
        apt-get install php5-intl -y -f
        apt-get install php5-mcrypt -y -f
        apt-get install php5-mysql -y -f
        apt-get install php5-readline -y -f
        apt-get install libapache2-mod-php5 -y -f
        apt-get install php5-xdebug -y -f
        #Others
        apt-get install -y -f

    echo "[Composer] Prepare..."
        curl -sS https://getcomposer.org/installer | php
        mv composer.phar /usr/local/bin/composer

    echo "[Symfony] Prepare..."
        curl -LsS http://symfony.com/installer -o /usr/local/bin/symfony
        chmod a+x /usr/local/bin/symfony

    echo "[NodeJs] Prepare..."
            curl --silent --location https://deb.nodesource.com/setup_0.12 | sudo bash -
            apt-get install --yes nodejs
            npm cache clean
            npm install npm -g
            npm cache clean

    echo "[AngularJs] Prepare..."
        apt-get install -y -f --force-yes git libpng-dev libfontconfig
        npm install -g yo --unsafe-perm
        npm install -g gulp@3.8.11
        npm install -g bower --save-dev
        npm install -g generator-gulp-angular --save-dev
        npm cache clean

    echo "[Java] Prepare..."
        apt-get install -y -f --force-yes openjdk-7-jre-headless

    echo "[Xvbf] Prepare..."
        apt-get install -y -f --force-yes xvfb libxrender1 libasound2 libdbus-glib-1-2 libgtk2.0-0 xfonts-100dpi xfonts-75dpi xfonts-scalable xfonts-cyrillic

    echo "[Firefox] Prepare..."
        wget "http://ftp.mozilla.org/pub/mozilla.org/firefox/releases/32.0.3/linux-x86_64/fr/firefox-32.0.3.tar.bz2"
        tar xjf firefox-32.0.3.tar.bz2
        mv firefox /opt
        ln -s  /opt/firefox/firefox /usr/bin/firefox
        rm firefox-32.0.3.tar.bz2

SCRIPT

############################### SCRIPT ###############################

$scriptConfDebian8 = <<SCRIPT

echo "[Profile] Configuration..."
    echo "cd /var/www/" >> /home/vagrant/.bash_profile

echo "[Apache/PHP/Mysql] Configuration..."
    sed -i 's#;date.timezone =#date.timezone = Europe/Paris#g' /etc/php5/apache2/php.ini
    sed -i 's#;date.timezone =#date.timezone = Europe/Paris#g' /etc/php5/cli/php.ini

    sed -i 's/export APACHE_RUN_USER=www-data/export APACHE_RUN_USER=vagrant/g' /etc/apache2/envvars
    sed -i 's/export APACHE_RUN_GROUP=www-data/export APACHE_RUN_GROUP=vagrant/g' /etc/apache2/envvars


    echo 'Europe/Paris' > /etc/timezone
    sudo dpkg-reconfigure --frontend noninteractive tzdata

    a2enmod php5 rewrite
    a2enmod headers
    service apache2 restart

echo "
# If you just change the port or add more ports here, you will likely also
# have to change the VirtualHost statement in
# /etc/apache2/sites-enabled/000-default
# This is also true if you have upgraded from before 2.2.9-3 (i.e. from
# Debian etch). See /usr/share/doc/apache2.2-common/NEWS.Debian.gz and
# README.Debian.gz

Listen 80
Listen 8090
Listen 8091

<IfModule mod_ssl.c>
# If you add NameVirtualHost *:443 here, you will also have to change
# the VirtualHost statement in /etc/apache2/sites-available/default-ssl
# to <VirtualHost *:443>
# Server Name Indication for SSL named virtual hosts is currently not
# supported by MSIE on Windows XP.
Listen 443
</IfModule>

<IfModule mod_gnutls.c>
Listen 443
</IfModule>
"  > /etc/apache2/ports.conf

echo "
<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    ProxyPreserveHost on
    ProxyPass /api/portal-back http://127.0.0.1:8090
    ProxyPass /api/portal-back-integration http://127.0.0.1:8091

    DocumentRoot /var/www/gdi-portal/dist
    <Directory /var/www/gdi-portal/dist>
        Options FollowSymLinks MultiViews
        AllowOverride All
        Require all granted
    </Directory>

    ScriptAlias /cgi-bin/ /usr/lib/cgi-bin/
    <Directory /usr/lib/cgi-bin>
        AllowOverride All
        Options ExecCGI SymLinksIfOwnerMatch
        Require all granted
    </Directory>

    ErrorLog /var/log/apache2/error_angular.log
    LogLevel warn
    CustomLog /var/log/apache2/access_angular.log combined
</VirtualHost>

<VirtualHost *:8090>
    DocumentRoot /var/www/gdi-portal-back/web/
    <Directory /var/www/gdi-portal-back/web/>
        AllowOverride All
        Options ExecCGI SymLinksIfOwnerMatch
        Order allow,deny
        Allow from all
    </Directory>
    ErrorLog /var/log/apache2/error_portal_back.log
    CustomLog /var/log/apache2/access_portal_back.log combined
</VirtualHost>

<VirtualHost *:8091>
    DocumentRoot /var/www/gdi-portal-back-integration/web/
    <Directory /var/www/gdi-portal-back-integration/web/>
        AllowOverride All
        Options ExecCGI SymLinksIfOwnerMatch
        Order allow,deny
        Allow from all
    </Directory>
    ErrorLog /var/log/apache2/error_portal_back.log
    CustomLog /var/log/apache2/access_portal_back.log combined
</VirtualHost>

" > /etc/apache2/sites-available/default.conf

    a2dissite 000-default.conf
    a2ensite default.conf
    a2enmod proxy
    a2enmod proxy_connect
    a2enmod proxy_http
    service apache2 restart

echo "[Xdebug] Configuration..."
    php5dismod xdebug
    service apache2 stop
    rmdir /var/lock/apache2
    service apache2 start

echo "[Hosts] Test..."
sed -i -e '1i 127.0.0.1 test.local\' /etc/hosts

#Configure cron table
crontab -l | { cat; echo "10 */1 * * * sudo echo 1 >> /var/www/gdi-newppi/cron.log 2>&1"; } | crontab -

SCRIPT

$scriptCI = <<SCRIPT
    echo "[Xdebug] Start..."
        php5enmod xdebug
        service apache2 stop
        rmdir /var/lock/apache2
        service apache2 start
SCRIPT

Vagrant.configure(2) do |config|

    #DEBIAN 8
    #config.vm.box = "debian/jessie64"
    #config.vm.provision "shell", inline: $scriptCommunDebian8
    #config.vm.provision "shell", inline: $scriptConfDebian8

    config.vm.box = "gdi-container-v4"
    config.vm.box_url = "https://owncloud.carma.grdf.fr/public.php?service=files&t=e6a9f978f9147e228f5979e68d95594a&download"

    config.vm.usable_port_range = (1042..3000)

    config.ssh.username = "vagrant"

    config.vm.provider "virtualbox" do |vb|
        vb.memory=2048
        vb.cpus=2
    end

    ####################################
    # DEV
    ####################################

    config.vm.define "dev" do |dev|
        dev.vm.network "private_network", ip: "10.0.57.2"
        dev.vm.synced_folder ".", "/var/www/"
    end

    config.vm.define "devwin" do |devwin|
        devwin.vm.network "private_network", ip: "10.0.57.2"
        devwin.vm.synced_folder ".", "/var/www/"
    end

    config.vm.define "devosx" do |devosx|
        devosx.vm.network "private_network", ip: "10.0.57.2"
        devosx.vm.synced_folder ".", "/var/www/"
    end

    ####################################
    # PHP CI
    ####################################

    config.vm.define "ci" do |ci|
        ci.vm.provision "shell", inline: $scriptCI
        ci.vm.network "private_network", ip: "10.0.55.12"
        ci.vm.synced_folder ".", "/var/www/", type: "rsync", rsync__exclude: [
          ".git/",
          "app/cache",
          "app/logs",
          "build",
          "web/bundles"
        ],
        rsync__args: [
          "--verbose",
          "--archive",
          "--delete",
          "-z"
        ],
        rsync__auto: false
        ci.vm.provider "virtualbox" do |vb|
            vb.memory=8192
        end
    end

    config.vm.define "cif" do |cif|
        cif.vm.provision "shell", inline: $scriptCI
        cif.vm.network "private_network", ip: "10.0.55.13"
        cif.vm.synced_folder ".", "/var/www/", type: "rsync", rsync__exclude: [
          ".git/",
          "app/cache",
          "app/logs",
          "build",
          "web/bundles"
        ],
        rsync__args: [
          "--verbose",
          "--archive",
          "--delete",
          "-z"
        ],
        rsync__auto: false
        cif.vm.provider "virtualbox" do |vb|
            vb.memory=8192
        end
    end
end