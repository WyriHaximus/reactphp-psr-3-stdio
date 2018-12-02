<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require \dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

\class_alias(TestCase::class, '\PHPUnit_Framework_TestCase');
