<?php

// NOTE: Only add record but don't modify or delete

return [

    'roles' => [
        'realtor' => 'realtor',
        'admin' => 'admin',
    ],

    'permissions' => [
        'forget password',
    ],

    'role_permissions' => [
        'admin' => [
            'forget password',
        ],
        'realtor' => [
            'forget password',
        ],
    ],

];
