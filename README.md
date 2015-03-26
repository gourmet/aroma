# Aroma

[![Build Status](https://travis-ci.org/gourmet/aroma.svg?branch=master)](https://travis-ci.org/gourmet/aroma)
[![Total Downloads](https://poser.pugx.org/gourmet/aroma/downloads.svg)](https://packagist.org/packages/gourmet/aroma)
[![License](https://poser.pugx.org/gourmet/aroma/license.svg)](https://packagist.org/packages/gourmet/aroma)

DB-based configuration for [CakePHP 3][cakephp].

## Install

Using [Composer][composer]:

```
composer require gourmet/aroma
```

You then need to load the plugin. In `boostrap.php`, something like:

```php
\Cake\Core\Plugin::load('Gourmet/Aroma');
```

## Usage

{{@TODO documentation}}

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
