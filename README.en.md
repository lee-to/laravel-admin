## Laravel CutCode Admin panel

*Read this in other languages: [English](README.en.md), [Russian](README.md)

Admin panel for your Laravel projects. Tested in over 120 projects and proven to be effective. It will help you work faster and better.

1.Configurable - customize to suit your needs

2.Easy to implement - add an admin panel to your project. simply

3.Beautiful and functional. Nothing to add, you can't say better

#### Commands

- 1.Install
``` bash
composer require lee-to/laravel-admin
```

- 2.Generate admin panel structure
``` bash
php artisan admin:install
```

- 3.Publish
``` bash
php artisan vendor:publish --provider="Leeto\Admin\Providers\AdminServiceProvider"
```

- 4.Migrate all tables
``` bash
php artisan migrate
```

- 5.Create admin user
``` bash
php artisan admin:superuser
```

#### Usage

- Create new admin section
``` bash
php artisan admin:generate People --model="App\Models\People" --title="People"
```

#### Troubleshooting

- Images 404. Don't forget about the symbolic link to the storage folder and configure config/filesystems.php
``` bash
php artisan storage:link
```

#### Extensions

- [Model localization](https://github.com/lee-to/laravel-model-localization)
- [Seo module](https://github.com/lee-to/laravel-seo)
- [Subscription module](https://github.com/lee-to/laravel-subscription)
