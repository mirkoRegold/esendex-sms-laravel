<?php
declare(strict_types=1);
namespace Regoldidealista\EsendexLaravel\Contracts;

interface SmsServiceInterface
{
    public function setBodyMessage(string $bodyMessage): self;
    public function setTo(string $to): self;
    public function send(): void;
}