<?php
declare(strict_types=1);
namespace Regoldidealista\EsendexLaravel\Channels;

use Regoldidealista\EsendexLaravel\Notifications\SmsNotification;

interface ChannelInterface
{
    public function send(object $notifiable, SmsNotification $notification): void;
}