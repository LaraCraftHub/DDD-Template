<?php

declare(strict_types=1);

use Rector\Caching\ValueObject\Storage\FileCacheStorage;
use Rector\Config\RectorConfig;
use Rector\PHPUnit\CodeQuality\Rector\MethodCall\AssertNotOperatorRector;
use Rector\PHPUnit\CodeQuality\Rector\MethodCall\AssertSameBoolNullToSpecificMethodRector;
use Rector\PHPUnit\Set\PHPUnitLevelSetList;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictNativeCallRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictScalarReturnExprRector;
use RectorLaravel\Rector\FuncCall\RemoveDumpDataDeadCodeRector;
use RectorLaravel\Set\LaravelLevelSetList;
use RectorLaravel\Set\LaravelSetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/app',
        __DIR__ . '/tests',
    ]);

    $rectorConfig->cacheClass(FileCacheStorage::class);
    $rectorConfig->cacheDirectory('./.cache/rector');

    $rectorConfig->importNames();

    $rectorConfig->sets([
        // PHP
        SetList::CODE_QUALITY,
        SetList::CODING_STYLE,
        SetList::DEAD_CODE,
        SetList::EARLY_RETURN,
        SetList::TYPE_DECLARATION,
        LevelSetList::UP_TO_PHP_82,
        // LARAVEL
        LaravelSetList::LARAVEL_CODE_QUALITY,
        //LaravelSetList::LARAVEL_STATIC_TO_INJECTION, // TODO: find a way to apply it only for infrastructure folder
        //LaravelSetList::LARAVEL_ELOQUENT_MAGIC_METHOD_TO_QUERY_BUILDER, User::find => User::query()->find
        LaravelSetList::LARAVEL_FACADE_ALIASES_TO_FULL_NAMES,
        LaravelLevelSetList::UP_TO_LARAVEL_100,
        // PHPUNIT
        PHPUnitSetList::PHPUNIT_CODE_QUALITY,
        PHPUnitSetList::ANNOTATIONS_TO_ATTRIBUTES,
        PHPUnitLevelSetList::UP_TO_PHPUNIT_100,
    ]);

    $rectorConfig->rules([
        // PHP
        ReturnTypeFromStrictNativeCallRector::class,
        ReturnTypeFromStrictScalarReturnExprRector::class,
        // LARAVEL
        RemoveDumpDataDeadCodeRector::class,
        // PHPUNIT
        AssertNotOperatorRector::class,
        AssertSameBoolNullToSpecificMethodRector::class,
    ]);

    $rectorConfig->skip([
        // PHP
        // PHPUNIT
    ]);
};
