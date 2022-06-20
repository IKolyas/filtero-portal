# FILTERO-PORTAL

## НАЧАЛО РАБОТЫ
### Настройка apache2
Перейти в директорию apache2
```sh
cd /etc/apache2/
```

Открыть файл apache2.conf
```sh
sudo nano apache2.conf
```
В файле найти тег <Directory /var/www/>, у параметра AllowOverride установить значение All
```sh
<Directory /var/www/>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
</Directory>
```
Далее, выполнить следующие команды

```sh
sudo a2enmod rewrite
sudo service apache2 restart
```
В проекте, в директории public_html создать файл .htaccess и добавить в него следующие строки
```sh
RewriteEngine On

RewriteCond %{SCRIPT_FILENAME} !-d
RewriteCond %{SCRIPT_FILENAME} !-f

RewriteRule ^(.*)$ ./index.php?route=$1
```

## СТРУКТУРА БД
	
![image](https://user-images.githubusercontent.com/63105949/171395714-0591d7ac-f2e9-42ca-b3c5-3eb314a578dc.png)

## МИГРАЦИИ

## ДЕЙСТВИЯ С МИГРАЦИЯМИ(создать/удалить)
```sh                      //переход в директорию database
php migrations.php [action] [name] //действие (action) с миграцией (name)
```
### Создание миграции
```sh
create
```
Создает миграцию с именем create_user_table:

```sh
php migrations.php create create_user_table
```

### Удаление миграции
```sh
drop
```
Удаляет миграцию с именем create_user_table:

```sh
php migrations.php drop create_user_table
```
## ДЕЙСТВИЯ МИГРАЦИЙ (накатить/откатить)
```sh                      //переход в директорию database
php migrations.php [migration_action] [migration_name_1234567890.php] 
//действие миграции(migration_action) с именем файла (migration_name_1234567890.php)
```
### Накатить миграцию
```sh
up
```
Накатывает миграцию с именем файла migration_name_1234567890.php:

```sh
php migrations.php up migration_name_1234567890.php
```
### Накатить все миграции последовательно
```sh
php migrations.php up -all
```
### Накатить последние n миграций
```sh
php migrations.php up -all:n
```
### Откатить миграцию
```sh
down
```
Откатывает миграцию с именем файла migration_name_1234567890.php:

```sh
php migrations.php down migration_name_1234567890.php
```
### Откатить все миграции последовательно
```sh
php migrations.php down -all
```
### Откатить последние n миграций
```sh
php migrations.php down -all:n
```
## ШАБЛОН МИГРАЦИЙ
Шаблон находится в файле migration_template.php
В созданной на основе шаблона миграции, в параметры row записываются sql запросы. В метод up() для накатывания. В метод down() для откатывания. 
```sh
class MIGRATION_NAME extends AbstractMigration
{
    public_html function up()
    {
        $row = "";

        return $this->connection->query($row);

    }

    public_html function down()
    {
        $row = "";

        return $this->connection->query($row);
    }

}
```