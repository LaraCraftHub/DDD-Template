<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Create global class aliases
|--------------------------------------------------------------------------
|
| @see https://laravel-ddd-guidelines.dev/laravel/collections
|
*/

class_alias(Illuminate\Support\Collection::class, 'App\Alias\SupportCollection');
class_alias(Illuminate\Database\Eloquent\Collection::class, 'App\Alias\EloquentCollection');
