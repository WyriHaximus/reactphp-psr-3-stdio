<?php declare(strict_types=1);

namespace WyriHaximus\React\Tests\PSR3\Stdio;

use Prophecy\Argument;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Psr\Log\Test\LoggerInterfaceTest;
use React\EventLoop\Factory;
use React\Stream\WritableStreamInterface;
use WyriHaximus\React\PSR3\Stdio\StdioLogger;

final class StdioLoggerTest extends LoggerInterfaceTest
{
    /**
     * @var array
     */
    private $logs = [];

    public function getLogger()
    {
        $stdio = $this->prophesize(WritableStreamInterface::class);
        $stdio->write(Argument::that(function ($message) {
            $this->logs[] = $message;

            return true;
        }))->shouldBeCalled();

        return new StdioLogger($stdio->reveal());
    }

    public function getLogs()
    {
        return $this->logs;
    }

    public function testWrite()
    {
        $level = LogLevel::INFO;
        $message = 'adasads';

        $stdio = $this->prophesize(WritableStreamInterface::class);
        $stdio->write($level . ' ' . $message)->shouldBeCalled();

        (new StdioLogger($stdio->reveal()))->log($level, $message);
    }

    public function testWriteHideLevel()
    {
        $level = LogLevel::INFO;
        $message = 'adasads';

        $stdio = $this->prophesize(WritableStreamInterface::class);
        $stdio->write($message)->shouldBeCalled();

        (new StdioLogger($stdio->reveal()))->withHideLevel(true)->log($level, $message);
    }

    public function testWriteNewLine()
    {
        $level = LogLevel::INFO;
        $message = 'adasads';

        $stdio = $this->prophesize(WritableStreamInterface::class);
        $stdio->write($level . ' ' . $message . StdioLogger::NEW_LINE)->shouldBeCalled();

        (new StdioLogger($stdio->reveal()))->withNewLine(true)->log($level, $message);
    }

    public function testWriteNewLineHideLevel()
    {
        $level = LogLevel::INFO;
        $message = 'adasads';

        $stdio = $this->prophesize(WritableStreamInterface::class);
        $stdio->write($message . StdioLogger::NEW_LINE)->shouldBeCalled();

        (new StdioLogger($stdio->reveal()))->withHideLevel(true)->withNewLine(true)->log($level, $message);
    }

    public function testWriteMultiline()
    {
        $level = LogLevel::INFO;
        $message = "a\r\nd\r\na\rs\na\r\nd\r\ns";

        $stdio = $this->prophesize(WritableStreamInterface::class);
        $stdio->write($level . ' ' . $message)->shouldBeCalled();

        (new StdioLogger($stdio->reveal()))->log($level, $message);
    }

    public function testImplements()
    {
        self::assertInstanceOf(LoggerInterface::class, StdioLogger::create(Factory::create()));
    }

    /**
     * @expectedException \Psr\Log\InvalidArgumentException
     */
    public function testThrowsOnInvalidLevel()
    {
        StdioLogger::create(Factory::create())->log('invalid level', 'Foo');
    }
}
