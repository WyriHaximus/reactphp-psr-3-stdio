<?php

declare(strict_types=1);

namespace WyriHaximus\React\PSR3\Stdio;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;
use React\Stream\WritableResourceStream;
use React\Stream\WritableStreamInterface;
use Stringable;
use WyriHaximus\PSR3\Utils;

use const PHP_EOL;
use const STDOUT;

final class StdioLogger implements LoggerInterface
{
    use LoggerTrait;

    public const string NEW_LINE = PHP_EOL;

    private bool $hideLevel = false;

    private bool $newLine = false;

    public function __construct(private WritableStreamInterface $stdio)
    {
    }

    /** @api */
    public static function create(): StdioLogger
    {
        return new self(new WritableResourceStream(STDOUT));
    }

    /** @api */
    public function withHideLevel(bool $hideLevel): StdioLogger
    {
        $clone            = clone $this;
        $clone->hideLevel = $hideLevel;

        return $clone;
    }

    /** @api */
    public function withNewLine(bool $newLine): StdioLogger
    {
        $clone          = clone $this;
        $clone->newLine = $newLine;

        return $clone;
    }

    /**
     * @param array<string, mixed> $context
     *
     * @inheritDoc
     * @phpstan-ignore typeCoverage.paramTypeCoverage
     */
    public function log($level, string|Stringable $message, array $context = []): void
    {
        Utils::checkCorrectLogLevel(Utils::formatValue($level));
        $message = Utils::processPlaceHolders((string) $message, $context);
        if ($this->hideLevel === false) {
            $message = Utils::formatValue($level) . ' ' . $message;
        }

        if ($this->newLine) {
            $message .= self::NEW_LINE;
        }

        $this->stdio->write($message);
    }
}
