# Laravel Blameable.

This package allow you to track the creator and updater of eloquent models.

## Installation

You can install the package via composer:

```bash

composer require digitalcloud/laravel-blameable

```

In Laravel 5.5 the service provider will automatically get registered. In older versions of the framework just add the service provider in config/app.php file:

```php

    'providers' => [
        DigitalCloud\Blameable\BlameableServiceProvider::class,
    ];

```


You can publish the config file with:

```bash

    php artisan vendor:publish --provider="DigitalCloud\Blameable\BlameableServiceProvider" --tag="config"

```

When published, the config/blameable.php config file contains:

```php
<?php

return [
    'column_names' => [
        'createdByAttribute' => 'created_by',
        'updatedByAttribute' => 'updated_by',
    ],
     'models' => [
         'user' => \App\User::class
     ]
];

```

You can update the columns names in this file, or you can stack with default names.
If you are not using the default laravel `App\User` model you need to provide the model class.


## Usage Example

First, you need to add the `DigitalCloud\Blameable\Traits\Blameable` trait to your model(s). For example:

```php
<?php

namespace App;

use DigitalCloud\Blameable\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use Blameable;
}

```

Then, you need to make sure that the database table for the model has the required columns. Luckily we provide two ways to do this task:

* By using console command and provide the model which you need to add columns:

    ```bash
      php artisan blameable:add-blameable-columns App\Post
    ```
    
* By calling `addBlameableColumns()` on the model uses `DigitalCloud\Blameable\Traits\Blameable` trait:

    ```php
      \App\Post::addBlameableColumns();
    ```

By using `DigitalCloud\Blameable\Traits\Blameable` in your model, the package will fill those columns automatically after creating nd updating the model.

## Relations

To get the creator/editor instance you can use:

```php
$post = \App\Post::find(1);
$cretor = $post->creator;
$editor = $post->editor;
```

### Note:

The package allow you to add blame columns to your migrations, using `blameable()` functions, for example:

```php

    Schema::table($table, function (Blueprint $table) {
        // this will add created_by and updated_by columns on your table.
        $table->blameable();
    });
            
``` 

