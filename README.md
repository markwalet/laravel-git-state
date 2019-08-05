# Laravel Git State

[![Build Status](https://travis-ci.org/markwalet/laravel-git-state.svg?branch=master)](https://travis-ci.org/markwalet/laravel-git-state)
[![Coverage Status](https://coveralls.io/repos/github/markwalet/laravel-git-state/badge.svg?branch=master)](https://coveralls.io/github/markwalet/laravel-git-state?branch=master)
[![Total Downloads](https://poser.pugx.org/markwalet/laravel-git-state/downloads)](https://packagist.org/packages/markwalet/laravel-git-state)
[![Latest Stable Version](https://poser.pugx.org/markwalet/laravel-git-state/v/stable)](https://packagist.org/packages/markwalet/laravel-git-state)
[![License](https://poser.pugx.org/markwalet/laravel-git-state/license)](https://packagist.org/packages/markwalet/laravel-git-state)

A Laravel package that gives you information about the current git state.

## Installation
You can install this package with composer:

```shell
composer require markwalet/laravel-git-state
```

Laravel >=5.5 uses Package auto-discovery, so you don't have to register the service provider. If you want to register the service provider manually, add the following line to your `config/app.php` file:

```php
MarkWalet\GitState\GitServiceProvider::class
```

## Usage
When you want to get information about the current git state, you can inject the `\MarkWalet\GitState\Drivers\GitDriver` class in your methods:

```php
<?php

use MarkWalet\GitState\Drivers\GitDriver;

class Controller {
    
    public function index(GitDriver $driver) {
        $branch = $driver->currentBranch();
        
        return view('index', compact('branch'));
    }
}
```
When injecting a GitDriver like this, you will get an instance of the default driver you configured. If you want to have more control over the driver you are using, you can use the `MarkWalet\GitState\GitManager`:

```php
<?php

use MarkWalet\GitState\GitManager;

class Controller {
    
    public function index(GitManager $driver) {
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
