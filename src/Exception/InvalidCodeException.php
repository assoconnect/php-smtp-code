<?php

declare(strict_types=1);

namespace AssoConnect\SmtpCode\Exception;

class InvalidCodeException extends \DomainException
{
    public function __construct(string $code)
    {
        parent::__construct(sprintf('The code "%s" is not a valid SMTP code', $code));
    }
}
