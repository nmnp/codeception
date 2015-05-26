# Codeception Demo Application

This demo project has few dependencies, please make sure that you meet those.

* Codeception
    - Install codeception( global installation)
        - ```sudo wget http://codeception.com/codecept.phar -O /usr/local/bin/codecept```
        - ```sudo chmod +x /usr/local/bin/codecept```

* Composer
    - Install composer (global installation)
        - ```curl -sS https://getcomposer.org/installer | php```
        - ```sudo mv composer.phar /usr/local/bin/composer```

After cloning the project,
  - execute the sql file **(db.sql)**
  - copy **config/application.ini-bak** and create a new one with the name **application.ini**
  - update your database credentials in **application.ini** file
  - exucute command ```composer update```
  - create a **virtual host** for the project

After following the above steps you should be able to run the application. If you face any problem regarding project setup, please let me know.
  