<?php

return [
    'email' => [
        'exists' => 'Your email doesn\'t exist.',
        'unique' => 'Already have an account on this email.',
        'email_verified' => 'Already have an account on this email.'
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
    'wrong_credentials' => 'The provided credentials are incorrect.'
];