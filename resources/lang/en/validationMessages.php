<?php

return [
    'email' => [
        'exists' => 'Your email doesn\'t exist.',
        'unique' => 'Already have an account on this email.',
        'email_verified' => 'Your are not email verified.'
    ],
    'phone_number' => [
        'phone' => 'Please enter a valid phone number.',
    ],
    'password' => [
        'min' => 'Password must be at least :character characters.',
        'max' => 'Password must be under :character characters.',
        'regex' => 'Password must be mix (uppercase, lowercase, number, and special character).'
    ],
    'gender' => [
        'in' => 'Gender should be male, female or other.',
    ],
    'date_of_birth' => [
        'before' => 'Date of birth should be before :date.',
    ],
    'role' => [
        'in' => 'Role must be (realter)',
    ],
    'user_id' => [
        'exists' => 'User doesn\'t exists.',
    ],
    'otp' => [
        'digits' => 'Otp must be :digits long.',
        'token_expired_invalid' => 'OTP verification session expired or invalid. Try again.'
    ],
    'identifier' => [
        'in' => 'Identifier type is invalid.',
    ],
    'wrong_credentials' => 'The provided credentials are incorrect.',
    'inactive_account' => 'Your account is inactive. Contact support for further details.'
];