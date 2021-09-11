<?php

declare(strict_types=1);

namespace AssoConnect\SmtpCode;

use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class LocalizedErrorMessage implements TranslatableInterface
{
    public const TRANSLATION_DOMAIN = 'smtp';
    private TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function trans(Code $code): string
    {
        foreach ($this->getTranslations() as $codeRaw) {
            if ($codeRaw === $code->getCode()) {
                return $this->translator->trans($codeRaw, [], self::TRANSLATION_DOMAIN);
            }
        }
        return $this->translator->trans('unknown', [], self::TRANSLATION_DOMAIN);
    }

    private function getTranslations(): iterable
    {
        yield '2.2.1';
        yield '5.7.1';
        yield '4.7.1';
        yield '5.5.0';
    }
}
