<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Exceptions;

use App\Application\Exceptions\InvalidMixedValueException;
use PHPUnit\Framework\TestCase;
use stdClass;

class InvalidMixedValueExceptionTest extends TestCase
{
    public function test_exception_message_replacement_for_integer(): void
    {
        $value = 42;
        $exception = new InvalidMixedValueException('Invalid value given: %s.', $value);

        $expectedMessage = 'Invalid value given: 42.';
        $actualMessage = $exception->getMessage();

        $this->assertSame($expectedMessage, $actualMessage);
    }

    public function test_exception_message_replacement_for_null(): void
    {
        $value = null;
        $exception = new InvalidMixedValueException('Invalid value given: %s.', $value);

        $expectedMessage = 'Invalid value given: null.';
        $actualMessage = $exception->getMessage();

        $this->assertSame($expectedMessage, $actualMessage);
    }

    public function test_exception_message_replacement_for_array(): void
    {
        $value = [
            'lastname',
            'email',
            [
                'phone',
                new stdClass(),
                new class {
                    public function __toString(): string
                    {
                        return 'custom_string';
                    }
                },
            ],
        ];
        $exception = new InvalidMixedValueException('Invalid value given: %s.', $value);

        $expectedMessage = 'Invalid value given: [ lastname, email, [ phone, (non-scalar-type): object, custom_string ] ].';
        $actualMessage = $exception->getMessage();

        $this->assertSame($expectedMessage, $actualMessage);
    }

    public function test_exception_message_for_non_scalar_value(): void
    {
        $value = new stdClass(); // An object without __toString method
        $exception = new InvalidMixedValueException('Value must be of type %s.', $value);

        $expectedMessage = 'Value must be of type object.';
        $actualMessage = $exception->getMessage();

        $this->assertSame($expectedMessage, $actualMessage);
    }

    public function test_exception_message_for_object_with_to_string(): void
    {
        $value = new class {
            public function __toString(): string
            {
                return 'custom_string';
            }
        };

        $exception = new InvalidMixedValueException('Value must be %s.', $value);

        $expectedMessage = 'Value must be custom_string.';
        $actualMessage = $exception->getMessage();

        $this->assertSame($expectedMessage, $actualMessage);
    }
}
