<?php
declare(strict_types=1);
namespace Regoldidealista\EsendexLaravel\Providers;

use Regoldidealista\EsendexLaravel\Contracts\DefaultSmsServiceInterface;
use Regoldidealista\EsendexLaravel\Contracts\SmsServiceInterface;
use Illuminate\Support\Facades\Http;

class EsendexService implements SmsServiceInterface, DefaultSmsServiceInterface
{
    private string $username;
    private string $password;
    private string $baseUrl;
    private string $smsUrl;
    private string $authUrl;
    private string $userKey;
    private string $accessToken;
    private string $smsType;

    private string $bodyMessage;
    private array $to;
    private string $from;

    public function __construct()
    {
        $this->username = config('sms.defaultProvider.username');
        $this->password = config('sms.defaultProvider.password');
        $this->baseUrl = config('sms.defaultProvider.url');
        $this->from = config('sms.defaultProvider.sender');
        $this->smsType = config('sms.defaultProvider.smsType');
        $this->setAuthUrl();
        $this->setSmsUrl();
    }

    public function send(): void
    {
        $this->auth();
        $payload = $this->makePayload();

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'user_key' => $this->userKey,
            'Access_token' => $this->accessToken
        ])->post($this->smsUrl, $payload);

        if ($response->status() !== 201) {
            throw new \Exception('Esendex send failed');
        }
    }
    public function setBodyMessage(string $bodyMessage): self
    {
        $this->bodyMessage = $bodyMessage;
        return $this;
    }
    public function setTo(array|string $to): self
    {
        $this->to = is_array($to) ? $to : [$to];
        return $this;
    }

    public function getTo(): array
    {
        return $this->to;
    }

    public function getBodyMessage(): string
    {
       return $this->bodyMessage;
    }

    private function auth(): void
    {
        $response = Http::withBasicAuth($this->username, $this->password)
            ->get($this->authUrl);

        if ($response->status() !== 200) {
            throw new \Exception('Esendex auth failed');
        }
        [$this->userKey, $this->accessToken] = explode(';', $response->body());
    }

    private function setAuthUrl(): void
    {
        $this->authUrl = $this->baseUrl . '/token';
    }

    private function setSmsUrl(): void
    {
        $this->smsUrl = $this->baseUrl . '/sms';
    }

    private function makePayload(): array
    {
        return [
            'message_type' => $this->smsType,
            'message' => $this->bodyMessage,
            'recipient' => $this->to,
            'sender' => $this->from,
            'returnCredits' => false
        ];
    }
}