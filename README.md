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

- Клонирование репозитория с GitHub
```bash
git clone https://github.com/lacaz3tte/courses-api.git
```

- Переход в директорию проекта
```bash
cd courses-api
```

- Запуск Docker контейнера для установки Composer зависимостей
```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install --ignore-platform-reqs
```
- Копирование файла окружения из примера
```bash
cp .env.example .env
```

- Запуск Docker контейнеров Sail в фоновом режиме
```bash
./vendor/bin/sail up -d
```

- Генерация ключа приложения Laravel
```bash
./vendor/bin/sail artisan key:generate
```

- Запуск миграций базы данных
```bash   
./vendor/bin/sail artisan migrate
```

- Запуск сидеров базы данных
```bash        
./vendor/bin/sail artisan db:seed
```

- Установка NPM зависимостей
```bash       
npm install
```

- Сборка фронтенд-ассетов в режиме разработки
```bash  
npm run dev
```
