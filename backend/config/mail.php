<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Mailer
    |--------------------------------------------------------------------------
    |
    | Laravel sử dụng một vài mailer để gửi thư. Bạn có thể chọn mailer mặc
    | định ở đây, Laravel sẽ sử dụng mailer này khi bạn không chỉ định mailer.
    |
    */
    'default' => env('MAIL_MAILER', 'smtp'),

    /*
    |--------------------------------------------------------------------------
    | Mailer Configurations
    |--------------------------------------------------------------------------
    |
    | Bạn có thể cấu hình nhiều mailer ở đây, nếu bạn muốn sử dụng nhiều mailer
    | với các thông số khác nhau. Đảm bảo cấu hình đúng các driver ở đây.
    |
    */
    'mailers' => [

        'smtp' => [
            'transport' => 'smtp',
            'host' => env('MAIL_HOST', 'smtp.mailtrap.io'),
            'port' => env('MAIL_PORT', 587),
            'encryption' => env('MAIL_ENCRYPTION', 'tls'),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'timeout' => null,
            'auth_mode' => null,
        ],

        'sendmail' => [
            'transport' => 'sendmail',
            'path' => '/usr/sbin/sendmail -bs',
        ],

        'mailgun' => [
            'transport' => 'mailgun',
        ],

        'postmark' => [
            'transport' => 'postmark',
            'token' => env('POSTMARK_TOKEN'),
        ],

        'amazon' => [
            'transport' => 'ses',
        ],

        'log' => [
            'transport' => 'log',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Global "From" Address
    |--------------------------------------------------------------------------
    |
    | Địa chỉ email này sẽ được sử dụng cho tất cả email gửi đi, trừ khi
    | bạn có chỉ định khác trong một email cụ thể.
    |
    */
    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'foxtalesweb@gmail.com'),
        'name' => env('MAIL_FROM_NAME', env('APP_NAME')),
    ],

    /*
    |--------------------------------------------------------------------------
    | Markdown Mail Settings
    |--------------------------------------------------------------------------
    |
    | Nếu bạn muốn sử dụng email dạng Markdown, bạn có thể cấu hình ở đây.
    |
    */
    'markdown' => [
        'theme' => 'default',
        'paths' => [
            resource_path('views/vendor/mail'),
        ],
    ],

];
