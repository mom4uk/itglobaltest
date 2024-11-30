## Ссылка на dump
[Ссылка на dump](https://github.com/mom4uk/itglobaltest/blob/master/dumpfile.sql)

## Схема структуры базы данных
![Схема](https://github.com/mom4uk/itglobaltest/blob/master/other/Screenshot%202024-11-29%20at%2013.42.03.png)

## Инструкция по запуску

1. Склонируйте репозиторий

2. Установите зависимости
    `make setup`
3. Добавьте переменные окружения в .env файл
    ```
    DB_CONNECTION=pgsql
    DB_HOST=database
    DB_PORT=5432
    DB_DATABASE=postgres
    DB_USERNAME=postgres
    DB_PASSWORD=postgres
    ```
4. Подготовьте данные бд
    ```
    make db-prepare
    ```
5. Соберите и запустите приложение

    ```
    make compose-start
    ```
6. Зайдите на http://127.0.0.1:8000