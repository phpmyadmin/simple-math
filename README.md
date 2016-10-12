# SimpleMath

Simple math expression evaluator.

[![Build Status](https://travis-ci.org/phpmyadmin/simple-math.svg?branch=master)](https://travis-ci.org/phpmyadmin/simple-math)
[![codecov.io](https://codecov.io/github/phpmyadmin/simple-math/coverage.svg?branch=master)](https://codecov.io/github/phpmyadmin/simple-math?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/phpmyadmin/simple-math/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/phpmyadmin/simple-math/?branch=master)
[![Packagist](https://img.shields.io/packagist/dt/phpmyadmin/simple-math.svg)](https://packagist.org/packages/phpmyadmin/simple-math)

## Features

* Supports basic arithmetic operations `+`, `-`, `*`, `/`
* Supports parenthesis
* Supports variables (either PHP style `$a` or simple `n`)

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

// Evaluate expression with PHP style variable
$math->registerVariable('$a', 4);
$math->evaluate('$a + 1');

// Evaluate expression with variable
$math->registerVariable('n', 4);
$math->evaluate('n + 1');

// Calculate same expression with different values

$math = new SimpleMath\Math();

$math->parse('n + 1');

$math->registerVariable('n', 10);
$math->run();

$math->registerVariable('n', 100);
$math->run();
```

## History

This library is based on [Expressions.php gist][2]. It adds some functions,
performance improvements and ability to install using [Composer][1].

[1]:https://getcomposer.org/
[2]:https://gist.github.com/dremie/fcb1f5beecc327679de8cca51c8e4743
