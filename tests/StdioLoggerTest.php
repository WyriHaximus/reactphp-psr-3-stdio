<?php declare(strict_types=1);

namespace WyriHaximus\React\Tests\PSR3\Stdio;

use Clue\React\Stdio\Stdio;
use Prophecy\Argument;
use Psr\Log\LogLevel;
use Psr\Log\Test\LoggerInterfaceTest;
use React\EventLoop\Factory;
use WyriHaximus\React\PSR3\Stdio\StdioLogger;

final class StdioLoggerTest extends LoggerInterfaceTest
{
    /**
     * @var array
     */
    private $logs = [];

    public function getLogger()
    {
        $stdio = $this->prophesize(Stdio::class);
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

        $stdio = $this->prophesize(Stdio::class);
        $stdio->write($level . ' ' . $message)->shouldBeCalled();

        (new StdioLogger($stdio->reveal()))->log($level, $message);
    }

    public function testImplements()
    {
        self::assertInstanceOf('Psr\Log\LoggerInterface', StdioLogger::create(Factory::create()));
    }

    /**
     * @expectedException \Psr\Log\InvalidArgumentException
     */
    public function testThrowsOnInvalidLevel()
    {
        StdioLogger::create(Factory::create())->log('invalid level', 'Foo');
    }
}
