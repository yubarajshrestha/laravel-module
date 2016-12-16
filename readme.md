# Modularizing Laravel
> This helps you to organize your Laravel Project codes by modularizing all your controllers, views and models. This will be very helpful when your laravel project is very big.

### How to?
1. Add following line after **"App\\": "app/"** in `composer.json`
	**"Modules\\": "Modules/"**

	Example:
	```php
	"psr-4": {
        "App\\": "app/",
        "Modules\\": "Modules/"
    }
	```
2. 	Copy `module.php` from `source` and paste it into your projects `config` directory.
3. 	Add required module name inside array:

	Example:
	```php
	return [
		'modules'=>array(
	        "Admin",
	        "Home",
	        "Your_Module_Name"
	    ),
	];
	```
4. Copy `Modules` directory from `source` to your projects `root` directory.
5. Modify Modules as per your requirement.
6. Now open up the file config/app.php and add ‘Modules\ModulesServiceProvider’ to the end of the providers array.
7. Your laravel project is now ready to go :+1:.
8. If you caught into problem: class not found then please do 'composer dump-autoload -o'.
