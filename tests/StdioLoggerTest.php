<?php

declare(strict_types=1);

namespace WyriHaximus\React\Tests\PSR3\Stdio;

use Psr\Log\InvalidArgumentException;
use Psr\Log\LogLevel;
use React\Stream\WritableStreamInterface;
use WyriHaximus\React\PSR3\Stdio\StdioLogger;
use WyriHaximus\TestUtilities\TestCase;

final class StdioLoggerTest extends TestCase
{
    public function testWrite(): void
    {
        $level   = LogLevel::INFO;
        $message = 'adasads';

        $stdio = $this->prophesize(WritableStreamInterface::class);
        $stdio->write($level . ' ' . $message)->shouldBeCalled();

        (new StdioLogger($stdio->reveal()))->log($level, $message);
    }

    public function testWriteHideLevel(): void
    {
        $level   = LogLevel::INFO;
        $message = 'adasads';

        $stdio = $this->prophesize(WritableStreamInterface::class);
        $stdio->write($message)->shouldBeCalled();

        (new StdioLogger($stdio->reveal()))->withHideLevel(true)->log($level, $message);
    }

    public function testWriteNewLine(): void
    {
        $level   = LogLevel::INFO;
        $message = 'adasads';

        $stdio = $this->prophesize(WritableStreamInterface::class);
        $stdio->write($level . ' ' . $message . StdioLogger::NEW_LINE)->shouldBeCalled();

        (new StdioLogger($stdio->reveal()))->withNewLine(true)->log($level, $message);
    }

    public function testWriteNewLineHideLevel(): void
    {
        $level   = LogLevel::INFO;
        $message = 'adasads';

        $stdio = $this->prophesize(WritableStreamInterface::class);
        $stdio->write($message . StdioLogger::NEW_LINE)->shouldBeCalled();

        (new StdioLogger($stdio->reveal()))->withHideLevel(true)->withNewLine(true)->log($level, $message);
    }

    public function testWriteMultiline(): void
    {
        $level   = LogLevel::INFO;
        $message = "a\r\nd\r\na\rs\na\r\nd\r\ns";

        $stdio = $this->prophesize(WritableStreamInterface::class);
        $stdio->write($level . ' ' . $message)->shouldBeCalled();

        (new StdioLogger($stdio->reveal()))->log($level, $message);
    }

    public function testThrowsOnInvalidLevel(): void
    {
        self::expectException(InvalidArgumentException::class);

        StdioLogger::create()->log('invalid level', 'Foo');
    }
}
