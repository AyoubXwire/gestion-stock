# Get started

Clone the repository into your local machine, then inside the project folder, run the commands

```
composer install
```

modify the file .env to link your mysql database
* replace "root" with your mysql username
* replace "xwire" with your mysql password

then, run the following command to create the database

```
php bin/console doctrine:database:create
```

run the following command to create the database tables

```
php bin/console doctrine:migrations:migrate
```

run the following command to fill in the tables with some data

```
php bin/console doctrine:fixtures:load
```

That's it! now you can run the website in your localhost.