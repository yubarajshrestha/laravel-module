# Modularizing Laravel
====================
[![GitHub stars](https://img.shields.io/github/stars/yubarajshrestha/laravel-module.svg)](https://github.com/yubarajshrestha/laravel-module/stargazers)
[![Latest Stable Version](https://poser.pugx.org/yubarajshrestha/ym/v/stable)](https://packagist.org/packages/yubarajshrestha/ym)
[![Total Downloads](https://poser.pugx.org/yubarajshrestha/ym/downloads)](https://packagist.org/packages/yubarajshrestha/ym)
[![License](https://poser.pugx.org/yubarajshrestha/ym/license)](https://packagist.org/packages/yubarajshrestha/ym)

**If you are sick trying to findout the controllers, routes and views from too many project files in laravel then yes, this package is for you.**

> This helps you to organize your Laravel Project codes by modularizing all your controllers, views and models. This will be very helpful when your laravel project is very big.

### How to?
#### Step 1: Install package

Add the package in your composer.json by executing the command.

```
composer require yubarajshrestha/ym
```

#### Step 2: Add Providers
Add the service provider to `config/app.php`

`YubarajShrestha\YM\YMServiceProvider::class,`
`YubarajShrestha\YM\YMModuleProvider::class,`

#### Step 3: Add PSR-4 Autoloader
Add following line after **"App\\": "app/"** in `composer.json`
	**"YModules\\": "YModules/"**

	Example:
	"psr-4": {
        "App\\": "app/",
        "YModules\\": "YModules/"
    }
#### Step 4: Publish Vendor Files
You need to have some files and don't worry it's quite easy. You just want to execute the command now.

`php artisan vendor:publish`

#### Step 5: We are there now
Final step is to migrate some files.
Execute migration command.

`php artisan migrate`

#### Step 6: Awesome
1. Your laravel project is now ready to go :+1:.
2. All you have to do is serve your laravel app. and then visit `/ym`. Eg. `http://localhost:8000/ym`
