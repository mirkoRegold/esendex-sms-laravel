<?php
namespace Regoldidealista\EsendexLaravel;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
class SmsServiceProvider extends BaseServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/sms.php' => config_path('sms.php'),
        ]);
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/sms.php', 'sms'
        );
    }
}