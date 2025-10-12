<?php

declare(strict_types=1);

namespace WyriHaximus\React\Tests\PSR3\Stdio;

use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Psr\Log\InvalidArgumentException;
use Psr\Log\LogLevel;
use React\Stream\WritableStreamInterface;
use WyriHaximus\React\PSR3\Stdio\StdioLogger;
use WyriHaximus\TestUtilities\TestCase;

final class StdioLoggerTest extends TestCase
{
    #[Test]
    public function write(): void
    {
        $level   = LogLevel::INFO;
        $message = 'adasads';

        $stdio = Mockery::mock(WritableStreamInterface::class);
        $stdio->expects('write')->with($level . ' ' . $message)->atLeast()->once();

        new StdioLogger($stdio)->log($level, $message);
    }

    #[Test]
    public function writeHideLevel(): void
    {
        $level   = LogLevel::INFO;
        $message = 'adasads';

        $stdio = Mockery::mock(WritableStreamInterface::class);
        $stdio->expects('write')->with($message)->atLeast()->once();

        new StdioLogger($stdio)->withHideLevel(true)->log($level, $message);
    }

    #[Test]
    public function writeNewLine(): void
    {
        $level   = LogLevel::INFO;
        $message = 'adasads';

        $stdio = Mockery::mock(WritableStreamInterface::class);
        $stdio->expects('write')->with($level . ' ' . $message . StdioLogger::NEW_LINE)->atLeast()->once();

        new StdioLogger($stdio)->withNewLine(true)->log($level, $message);
    }

    #[Test]
    public function writeNewLineHideLevel(): void
    {
        $level   = LogLevel::INFO;
        $message = 'adasads';

        $stdio = Mockery::mock(WritableStreamInterface::class);
        $stdio->expects('write')->with($message . StdioLogger::NEW_LINE)->atLeast()->once();

        new StdioLogger($stdio)->withHideLevel(true)->withNewLine(true)->log($level, $message);
    }

    #[Test]
    public function writeMultiline(): void
    {
        $level   = LogLevel::INFO;
        $message = "a\r\nd\r\na\rs\na\r\nd\r\ns";

        $stdio = Mockery::mock(WritableStreamInterface::class);
        $stdio->expects('write')->with($level . ' ' . $message)->atLeast()->once();

        new StdioLogger($stdio)->log($level, $message);
    }

    #[Test]
    public function throwsOnInvalidLevel(): void
    {
        self::expectException(InvalidArgumentException::class);

        StdioLogger::create()->log('invalid level', 'Foo');
    }
}
