# Предварительные требования:
Убедитесь, что на вашем компьютере установлен PHP, Composer и сервер баз данных (например, MySQL).
Убедитесь, что ваш сервер баз данных запущен и настроен на работу с Symfony проектом.
## Клонирование репозитория:
Склонируйте репозиторий с вашим Symfony проектом из вашего репозитория на GitHub на локальную машину.
## Конфигурация окружения:
Создайте файл .env.local на основе .env и настройте подключение к базе данных, если это необходимо.
## Установка зависимостей:
Установите зависимости Composer:

<code>
composer install --no-dev --optimize-autoloader
</code>     
## Применение миграций:
Выполните миграции Doctrine для создания таблиц в базе данных:
<code>
php bin/console doctrine:migrations:migrate
</code>

## Запуск веб-сервера Symfony:
Запустите веб-сервер Symfony:
<code>
    symfony server:start
</code>

## Проверка:
Откройте веб-браузер и перейдите по адресу, указанному после выполнения предыдущего шага.