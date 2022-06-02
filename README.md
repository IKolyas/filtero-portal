# FILTERO-PORTAL

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
    public function up()
    {
        $row = "";

        return $this->connection->query($row);

    }

    public function down()
    {
        $row = "";

        return $this->connection->query($row);
    }

}
```