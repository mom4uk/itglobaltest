## Ссылка на dump
[Ссылка на dump](https://github.com/mom4uk/itglobaltest/blob/master/dumpfile.sql)

## Схема структуры базы данных
![Схема](https://github.com/mom4uk/itglobaltest/blob/master/other/Screenshot%202024-11-29%20at%2013.42.03.png)

## Requirements
* PHP ^8.2
* Composer

## Инструция по запуску локально
1. Склонируйте репозиторий

2. Установите зависимости
    ```
    make setup
    ```
3. Добавьте переменные окружения в .env файл
    ```
    DB_CONNECTION=pgsql
    DB_HOST=localhost
    DB_PORT=5433
    DB_DATABASE=postgres
    DB_USERNAME=postgres
    DB_PASSWORD=postgres
    ```
4. Подготовьте данные бд
    ```
    make compose-start-database
    make db-prepare
    ```
5. Запустите приложение
    ```
    make start-app
    ```
6. Запуск тестов
    ```
    make tests
    ```


## Запуск в Docker

1. Измените переменные окружения в .env файле
    ```
    DB_CONNECTION=pgsql
    DB_HOST=database
    DB_PORT=5432
    DB_DATABASE=postgres
    DB_USERNAME=postgres
    DB_PASSWORD=postgres
    ```
2. Соберите и запустите приложение

    ```
    make compose-setup
    make compose-start
    ```

## Роут /api/update-bus
Отправляется 2 параметра:
1. route_id - id роута, который вы хотите изменить (работает, только для одного маршрута за раз)
2. stop_ids - последовательность id остановок через запятую, пример (1,2,3,4,5,6,7). 