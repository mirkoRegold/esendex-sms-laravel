<?php
declare(strict_types=1);
namespace Regoldidealista\EsendexLaravel\Channel;

use Regoldidealista\EsendexLaravel\Notification\SmsNotification;

interface ChannelInterface
{
    public function send(object $notifiable, SmsNotification $notification): void;
}