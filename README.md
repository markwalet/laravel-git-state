# Laravel Git State

[![Build Status](https://github.com/markwalet/laravel-git-state/workflows/tests/badge.svg)](https://github.com/markwalet/laravel-git-state/actions)
[![Total Downloads](https://img.shields.io/packagist/dt/markwalet/laravel-git-state)](https://packagist.org/packages/markwalet/laravel-git-state)
[![Latest Stable Version](https://img.shields.io/packagist/v/markwalet/laravel-git-state)](https://packagist.org/packages/markwalet/laravel-git-state)
[![License](https://img.shields.io/packagist/l/markwalet/laravel-git-state)](https://packagist.org/packages/markwalet/laravel-git-state)

A Laravel package that gives you information about the current git state.

## Installation
You can install this package with composer:

```shell
composer require markwalet/laravel-git-state
```

The package supports PHP 8.2+ and Laravel 12+.

Laravel auto-loads service providers for you, so you don't have to register it. If you want to register the service provider manually, add the following line to your `config/app.php` file:

```php
MarkWalet\GitState\GitStateServiceProvider::class
```

## Usage
When you want to get information about the current git state, you can inject the `MarkWalet\GitState\Drivers\GitDriver` class in your methods:

```php
<?php

use MarkWalet\GitState\Drivers\GitDriver;

class Controller {
    
    public function index(GitDriver $driver) {
        $branch = $driver->currentBranch();
        $commit = $driver->latestCommitHash();
        $timestamp = $driver->latestCommitTimestamp(); // Carbon instance
        $title = $driver->latestCommitTitle();
        $description = $driver->latestCommitDescription();
        
        return view('index', compact('branch', 'commit', 'timestamp', 'title', 'description'));
    }
}
```
When injecting a GitDriver like this, you will get an instance of the default driver you configured. If you want to have more control over the driver you are using, you can use the `MarkWalet\GitState\GitManager`:

```php
<?php

use MarkWalet\GitState\GitStateManager;

class Controller {
    
    public function index(GitStateManager $driver) {
        $branch = $driver->driver('other-driver')->currentBranch();
        
        return view('index', compact('branch'));
    }
}
```
## Configuration

The default configuration is defined in `git-state.php`. If you want to edit this file you can copy it to your config folder by using the following command:
```shell
php artisan vendor:publish --provider="MarkWalet\GitState\GitServiceProvider"
```

In this file you can configure different drivers for fetching the current Git state, as well as setting a default configuration.

The supported drivers are: `exec` and `file`. There is also a `fake` implementation for testing purposes.
