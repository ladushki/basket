<?php declare(strict_types = 1);

namespace Netrebel\Exceptions;

class ImmutableObjectException extends \LogicException
{
    /**
     * @param object      $object  Object.
     * @param string|null $message Message.
     * @return self
     */
    public static function new(object $object, ?string $message): self
    {
        $class = get_class($object);
        $message ??= 'Object of class '.$class.' is immutable after construction at';
        $message .= self::buildCaller(debug_backtrace()[1]);

        return new self($message);
    }

    /**
     * @param array $trace Exception trace.
     * @return string
     */
    private static function buildCaller(array $trace): string
    {
        if (!empty($trace['class'])) {
            return "{$trace['class']}{$trace['type']}{$trace['function']}():{$trace['line']}";
        }

        return "{$trace['file']} at function {$trace['function']}() on line {$trace['line']}";
    }
}