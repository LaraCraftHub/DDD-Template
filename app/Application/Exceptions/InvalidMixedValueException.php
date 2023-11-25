<?php

declare(strict_types=1);

namespace App\Application\Exceptions;

use Exception;

use function array_slice;
use function count;
use function gettype;
use function is_array;
use function is_object;
use function is_scalar;

final class InvalidMixedValueException extends Exception
{
    private const DEFAULT_ARRAY_DEPTH = 20;

    public function __construct(string $message, mixed $value)
    {
        $valueString = $this->castValueToString($value);

        // Replace "%s" with the string representation of $value in the message
        $message = str_replace('%s', $valueString, $message);

        // Call the parent constructor with the modified message
        parent::__construct($message);
    }

    private function castValueToString(mixed $value): string
    {
        if ($value === null) {
            return 'null';
        }

        if (is_array($value)) {
            /** @var array<int|string, mixed> $value */
            return $this->castNestedArrayToString($value, self::DEFAULT_ARRAY_DEPTH);
        }

        if (is_scalar($value) || (is_object($value) && method_exists($value, '__toString'))) {
            return (string) $value;
        }

        return gettype($value);
    }

    /**
     * @param array<int|string, mixed> $arrayToCast
     */
    private function castNestedArrayToString(array $arrayToCast, int $arrayDepth): string
    {
        $result = [];

        $reducedArray = array_slice($arrayToCast, 0, $arrayDepth);

        foreach ($reducedArray as $item) {
            if (is_scalar($item) || (is_object($item) && method_exists($item, '__toString'))) {
                $result[] = (string) $item;
            } elseif (is_array($item)) {
                // Recursively cast nested arrays to string.
                /** @var array<int|string, mixed> $item */
                $result[] = $this->castNestedArrayToString($item, $arrayDepth);
            } else {
                // For other non-scalar types, return the type as a string.
                $result[] = '(non-scalar-type): ' . gettype($item);
            }
        }

        $closingTag = count($reducedArray) > $arrayDepth ? ', ... ]' : ' ]';

        return '[ ' . implode(', ', $result) . $closingTag;
    }
}
