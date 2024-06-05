# Esendex Laravel

This is a Laravel package for integrating with the Esendex SMS service, and you can set you own backup provider.

## Installation

1. Add the package to your `composer.json` file:

```json
"require": {
    "php": "^8.3",
    "regoldidealista/esendex-laravel": "dev-main"
}
```

2. Add the GitHub repository to the `repositories` section:

```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/MirkoFarina/test-sms.git"
    }
]
```

3. Run `composer update` in your terminal.
## Publishing the Configuration File
   After installing the package, you should publish the configuration file to your Laravel application. This will allow you to modify the package's configuration options.  Run the following command in your terminal:
```bash 
php artisan vendor:publish --provider="Regoldidealista\EsendexLaravel\SmsServiceProvider" 
```
This command will publish the sms.php configuration file from the package to your Laravel application's config directory. You can find the published configuration file at config/sms.php.

## Usage

1. Register the service provider in your `config/app.php` file:

```php
'providers' => [
    // Other Service Providers...

    Regoldidealista\EsendexLaravel\SmsServiceProvider::class,
],
```

2. Use the `SmsNotification` class to send SMS notifications:

```php
use Regoldidealista\EsendexLaravel\Notification\SmsNotification;

class YourNotification extends SmsNotification
{
    // use the via method with the specific channel 
    public function via(object $notifiable): string
    {
        return $this->channel::class;
    }
    // also you can implement viaQueues method using the same channel.

    public function beforeSend(): void
    {
        // you can get notifiable object with $this->getNotifiable()
        $this->setTo(); // set the recipient phone number or array of phone numbers
        $this->setBodyMessage(); // set the body message as a string
    }
}
```