<?php
declare(strict_types=1);

namespace Regoldidealista\EsendexLaravel\Notification;

use Regoldidealista\EsendexLaravel\Channel\ChannelInterface;
use Regoldidealista\EsendexLaravel\Channel\SmsChannel;
use Regoldidealista\EsendexLaravel\Contracts\SmsServiceInterface;
use Illuminate\Notifications\Notification;

abstract class SmsNotification extends Notification implements SmsNotificationInterface
{
    private object $notifiable;
    private string $bodyMessage;
    private array $to;
    protected ChannelInterface $channel;
    protected SmsServiceInterface $smsService;

    public function __construct()
    {
        $this->channel = new SmsChannel();
        $this->smsService = app(config('sms.defaultProvider.provider'));
    }

    abstract function beforeSend(): void;

    public function getNotifiable(): object
    {
        return $this->notifiable;
    }

    public function setTo(array|string $to): void
    {
        $this->to = is_array($to) ? $to : [$to];
    }

    public function setBodyMessage(string $bodyMessage): void
    {
        $this->bodyMessage = $bodyMessage;
    }

    public function toSms(object $notifiable): SmsServiceInterface
    {
        $this->notifiable = $notifiable;
        $this->beforeSend();
        return $this->smsService
            ->setBodyMessage($this->bodyMessage)
            ->setTo($this->to);
    }
}