<?php

// config for Tvup/LaravelFejlvarp
return [
    'ipstack' => ['access_key' => env('INCIDENT_MANAGER_IPSTACK_ACCESS_KEY')],

    'pushover' => [
        'userkey' => env('INCIDENT_MANAGER_PUSHOVER_USER_KEY'),
        'apitoken' => env('INCIDENT_MANAGER_PUSHOVER_API_TOKEN'),
    ],

    'slack' => [
        'webhook_url' => env('INCIDENT_MANAGER_SLACK_WEBHOOK_URL'),
    ],

    'mail_recipient' => env('INCIDENT_MANAGER_EMAIL_RECIPIENT'),

];
