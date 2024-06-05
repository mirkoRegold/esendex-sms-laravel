<?php
declare(strict_types=1);
namespace Regoldidealista\EsendexLaravel\Contracts;

interface DefaultSmsServiceInterface
{
    public function getTo(): array;
    public function getBodyMessage(): string;
}