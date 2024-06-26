<?php
declare(strict_types=1);
namespace Regoldidealista\EsendexLaravel\Notifications;

use Regoldidealista\EsendexLaravel\Channels\ChannelInterface;
use Regoldidealista\EsendexLaravel\Contracts\SmsServiceInterface;

interface SmsNotificationInterface
{
    public function toSms(object $notifiable): SmsServiceInterface;
    public function setTo(array|string $to): void;
    public function setBodyMessage(string $bodyMessage): void;
    public function getNotifiable(): object;
    public function via(object $notifiable): string;
}