<?php

declare(strict_types=1);

namespace AssoConnect\SmtpCode;

use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class LocalizedErrorMessage implements TranslatableInterface
{
    public const TRANSLATION_DOMAIN = 'smtp';

    private string $code;

    public function __construct(Code $code)
    {
        $this->code = $code->getCode();
    }

    public function trans(TranslatorInterface $translator, string $locale = null): string
    {
        foreach ($this->getTranslations() as $codeRaw) {
            if ($codeRaw === $this->code) {
                return $translator->trans($this->code, [], self::TRANSLATION_DOMAIN);
            }
        }
        return $translator->trans('unknown', [], self::TRANSLATION_DOMAIN);
    }

    private function getTranslations(): iterable
    {
        yield '2.2.1';
        yield '5.7.1';
        yield '4.7.1';
        yield '5.5.0';
    }
}
