# SimpleMath

Simple math expression evaluator.

Please note that in most cases it's better to use [Symfony ExpressionLanguage Component](https://packagist.org/packages/symfony/expression-language) instead. It performs better and provides more features.

This repository will probably not receive any updates in future.

[![Build Status](https://travis-ci.org/phpmyadmin/simple-math.svg?branch=master)](https://travis-ci.org/phpmyadmin/simple-math)
[![codecov.io](https://codecov.io/github/phpmyadmin/simple-math/coverage.svg?branch=master)](https://codecov.io/github/phpmyadmin/simple-math?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/phpmyadmin/simple-math/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/phpmyadmin/simple-math/?branch=master)
[![Packagist](https://img.shields.io/packagist/dt/phpmyadmin/simple-math.svg)](https://packagist.org/packages/phpmyadmin/simple-math)

## Features

* Supports basic arithmetic operations `+`, `-`, `*`, `/`, `%`
* Supports parenthesis
* Supports right associative ternary operator
* Supports comparison operators `==`, `!=`, `>`, `<`, `>=`, `<=`
* Supports basic logical operations `&&`, `||`
* Supports variables (either PHP style `$a` or simple `n`)

The library was developed in order to be able to evaluate Gettext plural
equations, but can be used for any mathematical calculations.

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
$value = $math->evaluate('1 + 2');

// Evaluate expression with PHP style variable
$math->registerVariable('$a', 4);
$value = $math->evaluate('$a + 1');

// Evaluate expression with variable
$math->registerVariable('n', 4);
$value = $math->evaluate('n + 1');

// Calculate same expression with different values
$math = new SimpleMath\Math();

$math->parse('n + 1');

$math->registerVariable('n', 10);
$value = $math->run();

$math->registerVariable('n', 100);
$value = $math->run();
```

## History

This library is based on [Expressions.php gist][2]. It adds some functions,
performance improvements and ability to install using [Composer][1].

[1]:https://getcomposer.org/
[2]:https://gist.github.com/dremie/fcb1f5beecc327679de8cca51c8e4743
