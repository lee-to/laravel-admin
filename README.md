## Laravel CutCode Admin panel

*Другие языки: [English](README.en.md), [Russian](README.md)

Административная панель для Ваших Laravel проектов. Прошла обкатку в более 120 проектах и доказала свою эффективность :P. Поможет работать быстрее и качественнее.

1.Конфигурируемая - настройте под свои задачи

2.Легко внедряемая - добавьте админ панель в свой проект. просто

3.Красивая и функциональная. Нечего добавить, лучше и не скажешь

#### Команды

- 1.Установка
``` bash
composer require lee-to/laravel-admin
```

- 2.Генерация структуры файлов
``` bash
php artisan admin:install
```

- 3.Публикация конфигов
``` bash
php artisan vendor:publish --provider="Leeto\Admin\Providers\AdminServiceProvider"
```

- 4.Миграции
``` bash
php artisan migrate
```

- 5.Создание админа
``` bash
php artisan admin:superuser
```

#### Использование

- Добавлние нового раздела
``` bash
php artisan admin:generate People --model="App\Models\People" --title="People"
```

#### Расширения

- [Локализация моделей](https://github.com/lee-to/laravel-model-localization)
- [Сео модуль](https://github.com/lee-to/laravel-seo)
- [Модуль по работе с подписками](https://github.com/lee-to/laravel-subscription)
