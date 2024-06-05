<?php
return [
    /*
    | Set all variables for the default provider to be used for sending SMS
    | The provider must implement the SmsServiceInterface and DefaultSmsServiceInterface.
    | Required.
    */
    'defaultProvider' =>
        [
            'provider' => Regoldidealista\EsendexLaravel\Provider\EsendexService::class,
            'url' => env('SMS_ESENDEX_URL'),
            'smsType' => env('SMS_ESENDEX_SMS_TYPE'),
            'sender' => env('SMS_ESENDEX_SENDER'),
            'username' => env('SMS_ESENDEX_USERNAME'),
            'password' => env('SMS_ESENDEX_PASSWORD')
        ],
    /*
    | Set all variables for the backup provider to be used for sending SMS when the default option does not work.
    | The provider must implement the SmsServiceInterface.
    | Not required.
    */
    'backupProvider' =>
        [
            'provider' => 'PathOfYourClass'

            // Use this space for set all variables for the backup provider
        ]
];
