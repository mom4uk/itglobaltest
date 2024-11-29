#### Ссылка на dump
[Ссылка на dump](https://github.com/mom4uk/itglobaltest/blob/master/dumpfile.sql)

#### Схема структуры базы данных
![Схема](https://github.com/mom4uk/itglobaltest/blob/master/other/Screenshot%202024-11-29%20at%2013.42.03.png)

#### Инструкция по запуску

    1. Склонируйте репозиторий

    2. Установите зависимости
        `make setup`
    3. Добавьте переменные окружения в .env файл
        ```
        DB_CONNECTION=pgsql
        DB_HOST=localhost
        DB_PORT=54320
        DB_DATABASE=postgres
        DB_USERNAME=postgres
        DB_PASSWORD=postgres
        ```
    4. Поднимите контейнер с бд и наполните данными
        ```
        make compose-start-database
        make db-prepare
        ```
    5. Запустите локальный сервер
        `make compose-start`