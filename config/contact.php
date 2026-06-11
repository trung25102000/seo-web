<?php

return [
    'zalo_url' => env('CONTACT_ZALO_URL', 'https://zalo.me/0000000000'),
    'facebook_url' => env('CONTACT_FACEBOOK_URL', 'https://facebook.com'),
    'email' => env('CONTACT_EMAIL', env('MAIL_FROM_ADDRESS', 'hello@example.com')),
];
