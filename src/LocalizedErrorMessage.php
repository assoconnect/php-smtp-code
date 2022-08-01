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
        foreach (self::getTranslations() as $codeRaw) {
            if ($codeRaw === $this->code) {
                return $translator->trans($this->code, [], self::TRANSLATION_DOMAIN);
            }
        }
        return $translator->trans('unknown', [], self::TRANSLATION_DOMAIN);
    }

    public static function getTranslations(): \Generator
    {
        yield '2.2.1';
        yield '4.1.1';
        yield '4.2.1';
        yield '4.3.1';
        yield '4.3.2';
        yield '4.4.1';
        yield '4.4.2';
        yield '4.4.5';
        yield '4.5.1';
        yield '4.7.0';
        yield '4.7.1';
        yield '5.1.1';
        yield '5.2.1';
        yield '5.2.2';
        yield '5.5.0';
        yield '5.7.1';
        yield '6.0.2';
        yield '6.0.5';
    }
}
