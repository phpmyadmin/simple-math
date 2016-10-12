# SimpleMath

Simple math expression evaluator.

[![Build Status](https://travis-ci.org/phpmyadmin/simple-math.svg?branch=master)](https://travis-ci.org/phpmyadmin/simple-math)
[![codecov.io](https://codecov.io/github/phpmyadmin/simple-math/coverage.svg?branch=master)](https://codecov.io/github/phpmyadmin/simple-math?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/phpmyadmin/simple-math/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/phpmyadmin/simple-math/?branch=master)
[![Packagist](https://img.shields.io/packagist/dt/phpmyadmin/simple-math.svg)](https://packagist.org/packages/phpmyadmin/simple-math)

## Features

* All strings are stored in memory for fast lookup
* Fast loading of MO files
* Low level API for reading MO files
* Emulation of Gettext API

## Limitations

* Not suitable for huge MO files which you don't want to store in memory
* Input and output encoding has to match (preferably UTF-8)

## Installation

Please use [Composer][1] to install:

```
composer require phpmyadmin/simple-math
```

## Documentation

The API documentation is available at 
<https://develdocs.phpmyadmin.net/simple-math/>.


## Object API usage

```php
// Create math object
$math = new SimpleMath\Math();

// Evaluate expression
$math->evaluate('1 + 2');

// Evaluate expressoin with variable
$math->registerVariable('a', 4);
$math->evaluate('$a + 1');

```

## History

This library is based on [Expressions.php gist][2]. It adds some functions,
performance improvements and ability to install using [Composer][1].

[1]:https://getcomposer.org/
[2]:https://gist.github.com/dremie/fcb1f5beecc327679de8cca51c8e4743
