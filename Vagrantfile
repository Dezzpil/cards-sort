# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|

  config.vm.box = "generic/debian8"
  config.vm.box_check_update = false

  # Пробрасываем порты для доступа из вне (с хост машины)
  config.vm.network "forwarded_port", guest: 80, host: 8080, auto_correct: true
  config.vm.network "forwarded_port", guest: 3000, host: 3000, auto_correct: true

  # Rsync для работы с файлами
  config.vm.synced_folder ".", "/vagrant"

  # Настраиваем провизион. Ставим все что нужно и конфигуряем
  config.vm.provision "shell", inline: <<-SHELL

    apt-get update
    apt-get install -y curl nano

    apt-get install -y apt-transport-https lsb-release ca-certificates
    wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
    echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list
    apt-get update
    apt-get install -y php7.1 php7.1-dev php7.1-xml php7.1-mbstring
    apt-get install -y graphviz

    cd /vagrant
    mkdir -p web/xhprof

    git clone https://github.com/longxinH/xhprof.git ./xhprof
    cd xhprof/extension/
    phpize
    ./configure --with-php-config=/usr/bin/php-config
    make && sudo make install

    mv /etc/php/7.1/cli/php.ini /etc/php/7.1/cli/php.ini.bak
    cp /vagrant/php.ini /etc/php/7.1/cli/php.ini

    php --re xhprof

    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
    php composer-setup.php --install-dir=/usr/bin --filename=composer
    php -r "unlink('composer-setup.php');"

    composer install

    touch server.log
    php -S 0.0.0.0:3000 -t xhprof/xhprof_html 2>&1 >> server.log &

  SHELL


end