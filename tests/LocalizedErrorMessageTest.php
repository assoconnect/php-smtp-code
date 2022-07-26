<?php

declare(strict_types=1);

namespace AssoConnect\SmtpCode\Tests;

use AssoConnect\SmtpCode\Code;
use AssoConnect\SmtpCode\LocalizedErrorMessage;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\Translation\TranslatorInterface;

class LocalizedErrorMessageTest extends TestCase
{
    public function providerEvents(): \Generator
    {
        yield [4, 1, 2, 'unknown'];
        yield [5, 7, 1, '5.7.1'];
    }

    /**
     * @dataProvider providerEvents
     */
    public function testTransWorks(int $class, int $subject, int $detail, string $expected): void
    {
        $translator = $this->createMock(TranslatorInterface::class);
        $translator->expects(self::once())->method('trans')
            ->with($expected, [], 'smtp')->willReturn($expected);
        $code = new Code($class, $subject, $detail);
        $localizedErrorMessage = new LocalizedErrorMessage($code);
        $translated = $localizedErrorMessage->trans($translator);

        self::assertSame($expected, $translated);
    }
}
