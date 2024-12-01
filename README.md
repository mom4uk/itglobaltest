## Ссылка на dump
[Ссылка на dump](https://github.com/mom4uk/itglobaltest/blob/master/dumpfile.sql)

## Схема структуры базы данных
![Схема](https://github.com/mom4uk/itglobaltest/blob/master/other/Screenshot%202024-11-29%20at%2013.42.03.png)

## Requirements
* PHP ^8.2
* Composer
* PosgreSQL

## Инструция по запуску локально
1. Склонируйте репозиторий

2. Установите зависимости
    ```
    make install
    ```
3. Добавьте переменные окружения в .env файл
    ```
    DB_CONNECTION=pgsql
    DB_HOST=localhost
    DB_PORT=5432
    DB_DATABASE=postgres
    DB_USERNAME=postgres
    DB_PASSWORD=postgres
    ```
4. Подготовьте данные бд
    ```
    make db-prepare
    ```


## Запуск в Docker

5. Установите в docker-compose.yaml номер версии вашей бд
    ```
    database:
        image: postgres:{BD_VERSION}
    ```
6. Добавьте переменные окружения в .env файл
    ```
    DB_CONNECTION=pgsql
    DB_HOST=database
    DB_PORT=5432
    DB_DATABASE=postgres
    DB_USERNAME=postgres
    DB_PASSWORD=postgres
    ```
7. Соберите и запустите приложение

    ```
    make compose-setup
    make compose-start
    ```