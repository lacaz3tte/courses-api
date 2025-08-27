# Courses-api - API для заявок на курсы обучения

## Роуты
- POST:/api/register - регистрация пользователя
- POST:/api/login - логин пользователя
- GET:/api/courses - получение списка курсов
- GET:/api/applications - получение списка заявок (работает фильтрация по курсу ('?course=...') и почте юзера('?email=....'))
- POST:/api/applications - создание новой заявки
- GET:/api/applications/{$id} - получение конкретной заявки
- DELETE:/api/applications/{$id} - удаление конкретной заявки
- POST:/api/logout - разлогин пользователя
- GET:/api/user - получение информации о юзере

## Запуск приложения
- git clone https://github.com/lacaz3tte/courses-api.git
- cd courses-api
- docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install --ignore-platform-reqs
- cp .env.example .env
- ./vendor/bin/sail up -d
- ./vendor/bin/sail artisan key:generate       
- ./vendor/bin/sail artisan migrate           
- ./vendor/bin/sail artisan db:seed           
- npm install             
- npm run dev  
