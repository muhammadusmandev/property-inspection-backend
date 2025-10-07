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
    'inactive_account' => 'Your account is inactive. Contact support for further details.',
    'something_went_wrong' => 'Oops! Something went wrong.',
    'otp_verification_api_failed' => 'OTP Verification API request failed.',
    'forget_password_api_failed' => 'Forgot password request API request failed',
    'register_api_request_failed' => 'Register API request failed',
    'data_saved_failed' => 'Oops! Something went wrong while saving your data. Please try again.',
    'user_registered_successfully' => 'Great! User register successfully.',
    'user_logout_successfully' => 'User logout successfully.',
    'logout_api_failed' => 'Logout API request failed.',
    'login_api_failed' => 'Login API request failed.',
    'login_successfully' => 'Great! User login successfully.',
    'otp_resend_api_failed' => 'OTP resend API request failed.',
    'passwsord_change_successfully' => 'Password changed successfully.',
    'reset_link_sent_successfully' => 'Reset link and OTP sent to your email successfully.',
    'otp_sent_successfully' => 'OTP sent successfully.',
];