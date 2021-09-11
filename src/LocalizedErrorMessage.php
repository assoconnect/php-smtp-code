<?php

declare(strict_types=1);

namespace AssoConnect\SmtpCode;

use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class LocalizedErrorMessage implements TranslatableInterface
{
    private string $key;

    public function __construct(Code $code)
    {
        $this->key = 'x.' . $code->getSubject() . '.' . $code->getDetail();
    }

    public function trans(TranslatorInterface $translator, string $locale = null): string
    {
        return $translator->trans($this->key, [], 'smtp', $locale);
    }
}
