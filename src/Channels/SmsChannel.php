<?php
declare(strict_types=1);
namespace Regoldidealista\EsendexLaravel\Channels;

use Regoldidealista\EsendexLaravel\Notifications\SmsNotification;
use Regoldidealista\EsendexLaravel\Contracts\DefaultSmsServiceInterface;
use Regoldidealista\EsendexLaravel\Contracts\SmsServiceInterface;

class SmsChannel implements ChannelInterface
{
    private SmsServiceInterface $backupSmsService;
    private DefaultSmsServiceInterface $smsService;

    public function send(object $notifiable, SmsNotification $notification): void
    {
        try {
            $this->smsService = $notification->toSms($notifiable);
            $this->smsService->send();
        } catch (\Exception $e) {
            $this->instanceClassBackupSmsService(config('sms.backupProvider.provider'), $e->getMessage());
            $this->trySendWithBackupService();
        }
    }

    private function trySendWithBackupService(): void
    {
        $this->backupSmsService->setBodyMessage($this->smsService->getBodyMessage())
            ->setTo($this->smsService->getTo())
            ->send();
    }

    private function instanceClassBackupSmsService(string $pathBackupSmsService, string $message): void
    {
        $this->backupSmsService = class_exists($pathBackupSmsService)
            ?
            new $pathBackupSmsService()
            :
            throw new \Exception($message);
    }
}