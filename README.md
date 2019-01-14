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
    ]
];

```

You can update the columns names in this file, or you can stack with default names.


## Usage Example

All you need to use this package, is adding the `DigitalCloud\Blameable\Traits\Blameable` trait to your model(s). For example:

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

By using `DigitalCloud\Blameable\Traits\Blameable` in your model, the package will check if the model table has the blameable columns (by default, `created_by` and `updated_by`), and if the columns not existed, they will be added automatically to the table.
after adding the columns, the package will fill those columns automatically after creating nd updating the model.

### note:

The package allow you to add blame columns to your migrations, using blameable() functions, for example:

```php

    Schema::table($table, function (Blueprint $table) {
        // this will add created_by and updated_by columns on your table.
        $table->blameable();
    });
            
``` 

