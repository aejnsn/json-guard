<?php

namespace Yuloh\JsonGuard\Constraints;

use Yuloh\JsonGuard;
use Yuloh\JsonGuard\ErrorCode;
use Yuloh\JsonGuard\ValidationError;

class MultipleOf implements PropertyConstraint
{
    /**
     * {@inheritdoc}
     */
    public static function validate($value, $multiple, $pointer = null)
    {
        if (!is_numeric($value)) {
            return null;
        }

        // for some reason fmod does not return 0 for cases like fmod(0.0075,0.0001) so I'm doing this manually.
        $quotient = $value / $multiple;
        $mod      = $quotient - floor($quotient);
        if ($mod == 0) {
            return null;
        }

        $message = sprintf(
            'Number "%d" is not a multiple of "%d"',
            JsonGuard\asString($value),
            JsonGuard\asString($multiple)
        );
        return new ValidationError(
            $message,
            ErrorCode::INVALID_MULTIPLE,
            $value,
            $pointer,
            ['multiple_of' => $multiple]
        );
    }
}
