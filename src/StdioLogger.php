<?php declare(strict_types=1);

namespace WyriHaximus\React\PSR3\Stdio;

use Clue\React\Stdio\Stdio;
use Psr\Log\AbstractLogger;
use Psr\Log\InvalidArgumentException;
use Psr\Log\LogLevel;
use React\EventLoop\LoopInterface;
use function WyriHaximus\PSR3\processPlaceHolders;

final class StdioLogger extends AbstractLogger
{
    /**
     * Logging levels PSR-3 LogLevel enum
     *
     * @var array $levels Logging levels
     */
    const LOG_LEVELS = [
        LogLevel::DEBUG     => 'DEBUG',
        LogLevel::INFO      => 'INFO',
        LogLevel::NOTICE    => 'NOTICE',
        LogLevel::WARNING   => 'WARNING',
        LogLevel::ERROR     => 'ERROR',
        LogLevel::CRITICAL  => 'CRITICAL',
        LogLevel::ALERT     => 'ALERT',
        LogLevel::EMERGENCY => 'EMERGENCY',
    ];

    /**
     * @var Stdio
     */
    private $stdio;

    /**
     * @var bool
     */
    private $hideLevel = false;

    /**
     * LogglyLogger constructor.
     * @param LoopInterface $loop
     */
    public static function create(LoopInterface $loop)
    {
        return new self(new Stdio($loop));
    }

    /**
     * @param Stdio $stdio
     *
     * @internal
     */
    public function __construct(Stdio $stdio)
    {
        $this->stdio = $stdio;
    }

    public function withHideLevel(bool $hideLevel): StdioLogger
    {
        $clone = clone $this;
        $clone->hideLevel = $hideLevel;
        return $clone;
    }

    public function log($level, $message, array $context = [])
    {
        $levels = self::LOG_LEVELS;
        if (!isset($levels[$level])) {
            throw new InvalidArgumentException(
                'Level "' . $level . '" is not defined, use one of: ' . implode(', ', array_keys(self::LOG_LEVELS))
            );
        }

        $message = (string)$message;
        $message = processPlaceHolders($message, $context);
        if ($this->hideLevel === false) {
            $message = $level . ' ' . $message;
        }
        $this->stdio->write($message);
    }
}
