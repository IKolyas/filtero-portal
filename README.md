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

## УСТАНОВИТЬ ЗАВИСИМОСТИ
```
composer install
```

## ПРИМЕНИТЬ МИГРАЦИИ
```
cd database
php migrations.php up -all
```

## СТРУКТУРА БД
	
![image](https://user-images.githubusercontent.com/63105949/171395714-0591d7ac-f2e9-42ca-b3c5-3eb314a578dc.png)

## МИГРАЦИИ

```
 команды выполнять из дирректории database 
```

## СОЗДАНИЕ И УДАЛЕНИЕ ФАЙЛОВ МИГРАЦИЙ:
```sh
php migrations.php [action] [migration_name]
```

## Действия:
### Создание миграции
```sh
create
```
Создает файл миграции create_user_table.php:

```sh
php migrations.php create create_user_table
```

### Удаление миграции
```sh
drop
```
Удаляет файл миграции create_user_table.php:

```sh
php migrations.php drop create_user_table.php
```
## ПРИМЕНЕНИЕ И ОТКАТ МИГРАЦИЙ
```sh
php migrations.php [action] [migration_name] 
```
### Применить миграцию
```sh
up
```
Накатывает миграцию с именем файла migration_name_1234567890.php:

```sh
php migrations.php up migration_name_1234567890.php
```
### Применить все миграции последовательно
```sh
php migrations.php up -all
```
### Применить последние "n" - количество миграций
```sh
php migrations.php up -all:[n]
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
### Откатить последние "n" - количество миграций
```sh
php migrations.php down -all:[n]
```
## ШАБЛОН МИГРАЦИЙ
Шаблон находится в файле migration_template.php
В созданной на основе шаблона миграции, в параметры row записываются sql команды. Метод up() для применения.Метод down() для отката. 
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