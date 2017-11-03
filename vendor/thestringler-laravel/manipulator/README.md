# The Stringler Laravel Package

A Laravel package for [The Stringler](https://github.com/spatie/string), a string manipulation class.

## Install
Compsoser:
```
composer require thestringler-laravel/manipulator
```

After composer has done its thing, add the package service provider to the array in `config.app`:

```php
TheStringlerLaravel\Manipulator\Manipulator::class
```

Then add the facade to the aliases array, also in `config.php`:

```php
'Manipulator' => TheStringlerLaravel\Manipulator\ManipulatorFacade::class,
```

Example Controller Usage:
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Manipulator;

use App\Http\Requests;

class ExampleController extends Controller
{
    public function index()
    {
    	$string = Manipulator::make('Laravel 5')->toUpper();

    	return view('welcome', [
    		'title' => $string
		]);
    }
}

```

Helper function:
```php
$string = manipulate('hello')->toUpper();
```