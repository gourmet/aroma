# Aroma

[![Build Status](https://travis-ci.org/gourmet/aroma.svg?branch=master)](https://travis-ci.org/gourmet/aroma)
[![Total Downloads](https://poser.pugx.org/gourmet/aroma/downloads.svg)](https://packagist.org/packages/gourmet/aroma)
[![License](https://poser.pugx.org/gourmet/aroma/license.svg)](https://packagist.org/packages/gourmet/aroma)

DB-based configuration for [CakePHP 3][cakephp].

## Install

Using [Composer][composer]:

```
composer require gourmet/aroma:~1.0
```

You then need to load the plugin. You can use the shell command:

```
bin/cake plugin load Gourmet/Aroma
```

or by manually adding statement shown below to `bootstrap.php`:

```php
Plugin::load('Gourmet/Aroma');
```

## Usage

For the most basic setup, you don't need to do much:

```php
// config/bootstrap.php
use Cake\Core\Configure;
use Gourmet\Core\Configure\Engine\DbConfig;

Configure::config('db', new DbConfig());
```

If you'd like to use a custom table for storing configuration:

```php
// config/bootstrap.php
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Gourmet\Core\Configure\Engine\DbConfig;

Configure::config('db', new DbConfig(TableRegistry::get('MyConfigurations')));
```

Of if you just want to use a different caching engine configuration for storing the database query results:

```php
// config/bootstrap.php
use Cake\Core\Configure;
use Gourmet\Core\Configure\Engine\DbConfig;

Configure::config('db', new DbConfig(null, 'customCacheConfigAlias'));
```

Once you have set it up, you can use like any other `Configure` engine, using the `key` you have assigned it:

```php
Configure::read('site_name', 'db');
Configure::write('site_name', 'My Personal Blog', 'db');
```

## Patches & Features

* Fork
* Mod, fix
* Test - this is important, so it's not unintentionally broken
* Commit - do not mess with license, todo, version, etc. (if you do change any, bump them into commits of
their own that I can ignore when I pull)
* Pull request - bonus point for topic branches

## Bugs & Feedback

http://github.com/gourmet/aroma/issues

## License

Copyright (c) 2015, Jad Bitar and licensed under [The MIT License][mit].

[cakephp]:http://cakephp.org
[composer]:http://getcomposer.org
[composer:ignore]:http://getcomposer.org/doc/faqs/should-i-commit-the-dependencies-in-my-vendor-directory.md
[mit]:http://www.opensource.org/licenses/mit-license.php
