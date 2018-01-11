# Standard Out [PSR-3](http://www.php-fig.org/psr/psr-3/) logger for [ReactPHP](https://github.com/reactphp/)

[![Linux Build Status](https://travis-ci.org/WyriHaximus/reactphp-psr-3-stdio.png)](https://travis-ci.org/WyriHaximus/reactphp-psr-3-stdio)
[![Latest Stable Version](https://poser.pugx.org/WyriHaximus/react-psr-3-stdio/v/stable.png)](https://packagist.org/packages/WyriHaximus/react-psr-3-stdio)
[![Total Downloads](https://poser.pugx.org/WyriHaximus/react-psr-3-stdio/downloads.png)](https://packagist.org/packages/WyriHaximus/react-psr-3-stdio/stats)
[![Code Coverage](https://scrutinizer-ci.com/g/WyriHaximus/reactphp-psr-3-stdio/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/WyriHaximus/reactphp-psr-3-stdio/?branch=master)
[![License](https://poser.pugx.org/WyriHaximus/react-psr-3-stdio/license.png)](https://packagist.org/packages/wyrihaximus/react-psr-3-stdio)
[![PHP 7 ready](http://php7ready.timesplinter.ch/WyriHaximus/reactphp-psr-3-stdio/badge.svg)](https://travis-ci.org/WyriHaximus/reactphp-psr-3-stdio)

### Installation ###

To install via [Composer](http://getcomposer.org/), use the command below, it will automatically detect the latest version and bind it with `^`.

```
composer require wyrihaximus/react-psr-3-stdio 
```

## Usage ##

```php
$loop = Factory::create(); // ReactPHP event loop
$logger = StdioLogger::create($loop);
$logger->info('log'); // Writes info log to STDOUT
```

When desired you can hide the log level from output by creating a logger that doesn't write it:

```php
$logger = StdioLogger::create($loop)->withHideLevel(true);
```

Another option is to write a new line (`PHP_EOL`) after each line, it is off by default 
but can be enabled with: 

```php
$logger = StdioLogger::create($loop)->withNewLine(true);
```

## Contributing ##

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## License ##

Copyright 2017 [Cees-Jan Kiewiet](http://wyrihaximus.net/)

Permission is hereby granted, free of charge, to any person
obtaining a copy of this software and associated documentation
files (the "Software"), to deal in the Software without
restriction, including without limitation the rights to use,
copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following
conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.
