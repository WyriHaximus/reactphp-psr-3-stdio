<?php declare(strict_types=1);

namespace WyriHaximus\React\PSR3\Stdio;

use Clue\React\Stdio\Stdio;
use Psr\Log\AbstractLogger;
use React\EventLoop\LoopInterface;
use function WyriHaximus\PSR3\checkCorrectLogLevel;
use function WyriHaximus\PSR3\processPlaceHolders;

final class StdioLogger extends AbstractLogger
{
    /**
     * @var Stdio
     */
    private $stdio;

    /**
     * @var bool
     */
    private $hideLevel = false;

    /**
     * @param Stdio $stdio
     *
     * @internal
     */
    public function __construct(Stdio $stdio)
    {
        $this->stdio = $stdio;
    }

    /**
     * LogglyLogger constructor.
     * @param LoopInterface $loop
     */
    public static function create(LoopInterface $loop)
    {
        return new self(new Stdio($loop));
    }

    public function withHideLevel(bool $hideLevel): StdioLogger
    {
        $clone = clone $this;
        $clone->hideLevel = $hideLevel;

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
        $this->stdio->write($message);
    }
}
