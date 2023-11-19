if it is 1, disabling word block.
"The disableFlg column in all records of 'Word' table will be reset to 0 every day at 00:00.(using crontab)


You can block "Site", "Word" and "YoutubeChannel" by registering them in this system.

### Word
in "Word",you mustn't contain spaces in string.

you need to concatenate strings by a space.

(ex)
one piece -> onepiece
one ok rock -> oneokrock

### YoutubeChannel

# Todo after cloning on local environment
$ composer install

$ php artisan key:generate

$ php artisan serve

 setting mysql

$ create database laravel;

$ CREATE USER "ss119" IDENTIFIED BY "password";

$ GRANT ALL PRIVILEGES ON * . * TO 'ss119';

- rename .env.example file

- edit DB_username and DB_password .env file 

========================

$ php artisan migrate

- register username and password in users table.
> INSERT INTO users (email, password) values ("soras.k.m.tj16@gmail.com", "$2y$10$KCQzuQxeCa3ODHTCOJ2WS.OFdUtuOknegDkf5Pj.q/PHnjt0pSKKq");


# 本番環境にデプロイ後

run the below cmd

php artisan queue:table
=========================

# crantab -e setting
0 15 * * * cd /var/www/html/example-app && php artisan limit:daily >> /dev/null 2>&1

queueを使用してyoutubechannelblockのblock メソッド内で　

=========================

white listとblacklist モードを切り替えれるようにする






