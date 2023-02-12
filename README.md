## API Generator

Create an API resource with just one command line. This is a useful tool that can help us reduce development time thus promoting efficiency amongst all developers.

## Installation



## Main Features
* Create API route resource
* Create database migration
* Create a model with relationship
* Create controller with CRUD methods
* Create View Blade index file

## Usage

You do not need to change anything after you have successfully setup the package.
Just run php artisan generate:api {api_name}
> **Note**
> {api_name} should follow the standard Model naming for laravel.

```
php artisan generate:api Books
```

This should output
```
Books Controller has been created
Books API routes resources has been created
Books View blade index has been created
Books Model has been created
create_books_table migration has been created
Route cache has been cleared
```

To confirm, you must navigate to these directories:
* App\Http\Controllers
* routes\api.php
* resources\views\
* App\Models\
* database\migrations

Model relationships
* arguments
   * --relationship1={cardinality} {Model}
   * --relationship2={cardinality} {Model}
* Cardinality list
   * hasOne
   * belongsToMany
   * hasMany
   * belongsTo
* Sample command 
```
$ php artisan generate:api Books --relationship1=hasOne User --relationship2=hasMany Profile
```
Generated code sample output
* [Generated Controller]
* [Generated Model with cardinality]
* [Generated API route resource]
* [Generated view blade]