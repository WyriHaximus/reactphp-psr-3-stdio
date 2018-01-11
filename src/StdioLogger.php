<?php declare(strict_types=1);

namespace WyriHaximus\React\PSR3\Stdio;

use Clue\React\Stdio\Stdio;
use Psr\Log\AbstractLogger;
use React\EventLoop\LoopInterface;
use React\Stream\WritableResourceStream;
use React\Stream\WritableStreamInterface;
use function WyriHaximus\PSR3\checkCorrectLogLevel;
use function WyriHaximus\PSR3\processPlaceHolders;

final class StdioLogger extends AbstractLogger
{
    const NEW_LINE = PHP_EOL;

    /**
     * @var Stdio
     */
    private $stdio;

    /**
     * @var bool
     */
    private $hideLevel = false;

    /**
     * @var bool
     */
    private $newLine = false;

    /**
     * @param WritableStreamInterface $stream
     *
     * @internal
     */
    public function __construct(WritableStreamInterface $stream)
    {
        $this->stdio = $stream;
    }

    /**
     * @param LoopInterface $loop
     */
    public static function create(LoopInterface $loop): StdioLogger
    {
        return new self(new WritableResourceStream(STDOUT, $loop));
    }

    public function withHideLevel(bool $hideLevel): StdioLogger
    {
        $clone = clone $this;
        $clone->hideLevel = $hideLevel;

        return $clone;
    }

    public function withNewLine(bool $newLine): StdioLogger
    {
        $clone = clone $this;
        $clone->newLine = $newLine;

        return $clone;
    }

    public function log($level, $message, array $context = [])
    {
        checkCorrectLogLevel($level);
        $message = (string)$message;
        $message = processPlaceHolders($message, $context);
        if ($this->hideLevel === false) {
            $message = $level . ' ' . $message;
        }
        if ($this->newLine === true) {
            $message .= self::NEW_LINE;
        }
        $this->stdio->write($message);
    }
}
