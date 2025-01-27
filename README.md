# Bus Schedule

## Описание проекта

Проект **Bus Schedule** - серверная часть веб-приложения, демонстрирующего расписание рейсовых автобусов.
Оно позволяет пользователям просматривать автобусы, маршрут которых включает отрезок от одной остановки к другой, с тремя ближайшими к текущему времени вариантами времени прибытия на исходную остановку,
а также редактировать наборы остановок на пути следования автобуса.


## Предварительные требования

Перед началом установки убедитесь, что у вас установлены следующие компоненты:

- **PHP** (версии 7.4 или выше)
- **PostgreSQL** (версии 12 или выше)
- **Composer** (для управления зависимостями, если используется)
- **Git** (для клонирования репозитория)
- **Docker** 

## Установка

### 1. Клонирование репозитория

Для начала необходимо клонировать репозиторий:

```bash
git clone https://github.com/marcolouis119/bus-schedule.git
cd bus-schedule

### 2. Установка зависимостей

```bash
composer install

### 3. Настройка базы данных

Создайте базу данных: выполните следующие команды в командной строке PostgreSQL:
```sql
CREATE DATABASE bus_schedule;
CREATE USER postgres WITH PASSWORD 'postgres';
GRANT ALL PRIVILEGES ON DATABASE bus_schedule TO postgres;

Импортируйте дамп базы данных:
```bash
psql -U postgres -d bus_schedule -f "C:\php project\bus-schedule\database_dump.sql"

Откройте и настройте файл .env следующим образом:

DB_HOST=localhost
DB_NAME=bus_schedule
DB_USER=postgres
DB_PASS=postgres

### 4. Запускаем проект в контейнерах Docker

```bash
cd C:\php project\bus-schedule

Запускаем контейнеры в фоновом режиме:
```bash
docker-compose up -d

Проверяем работонспособность контейнеров
```bash
docker-compose ps

### 5. Открываем само приложение

В браузере прописываем адрес:
http://localhost:8000


По завершению использования останваливаем контейнеры:
```bash
docker-compose down



