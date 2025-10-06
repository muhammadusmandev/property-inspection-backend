<?php

namespace App\Enums;

enum OtpIdentifier: string
{
    case EMAIL = 'email';
    case PHONE = 'phone';

    public static function in(string $value): self
    {
        return match($value) {
            self::EMAIL->value => self::EMAIL,
            self::PHONE->value => self::PHONE,
            default => throw new \InvalidArgumentException("Invalid OTP identifier provided {$value}."),
        };
    }
}
