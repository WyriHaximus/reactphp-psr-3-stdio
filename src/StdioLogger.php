<?php

declare(strict_types=1);

namespace WyriHaximus\React\PSR3\Stdio;

use Psr\Log\AbstractLogger;
use React\Stream\WritableResourceStream;
use React\Stream\WritableStreamInterface;

use function WyriHaximus\PSR3\checkCorrectLogLevel;
use function WyriHaximus\PSR3\formatValue;
use function WyriHaximus\PSR3\processPlaceHolders;

use const PHP_EOL;
use const STDOUT;

final class StdioLogger extends AbstractLogger
{
    public const NEW_LINE = PHP_EOL;

    private WritableStreamInterface $stdio;

    private bool $hideLevel = false;

    private bool $newLine = false;

    /**
     * @internal
     */
    public function __construct(WritableStreamInterface $stream)
    {
        $this->stdio = $stream;
    }

    public static function create(): StdioLogger
    {
        return new self(new WritableResourceStream(STDOUT));
    }

    public function withHideLevel(bool $hideLevel): StdioLogger
    {
        $clone            = clone $this;
        $clone->hideLevel = $hideLevel;

        return $clone;
    }

    public function withNewLine(bool $newLine): StdioLogger
    {
        $clone          = clone $this;
        $clone->newLine = $newLine;

        return $clone;
    }

    /**
     * @param array<mixed> $context
     *
     * @psalm-suppress MissingParamType
     * @inheritDoc
     */
    public function log($level, $message, array $context = []): void
    {
        checkCorrectLogLevel(formatValue($level));
        $message = (string) $message;
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
