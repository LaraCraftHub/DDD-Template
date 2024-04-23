<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Create global class aliases
|--------------------------------------------------------------------------
|
| @see https://backend-guidelines.playplay.dev/laravel/collections
|
*/

class_alias(Illuminate\Support\Collection::class, 'App\Alias\SupportCollection');
class_alias(Illuminate\Database\Eloquent\Collection::class, 'App\Alias\EloquentCollection');
