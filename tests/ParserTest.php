<?php

declare(strict_types=1);

namespace AssoConnect\SmtpCode\Tests;

use AssoConnect\SmtpCode\Parser;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    public function providerEvents(): iterable
    {
        yield ['4.2.2 The email account that you tried to reach is over quota.', false, '4.2.2'];
        yield ['smtp; 5.3.0 - Other mail system problem', true, '5.3.0'];
        yield ['SMTP; 451 4.4.4 Temporary server error.', false, '4.4.4'];
        yield ['SMTP;451 4.4.4 Temporary server error.', false, '4.4.4'];
        yield ['SMTP; 550 #5.1.0 Address rejected.', true, '5.1.0'];
        yield ['smtp; 550-5.2.1 The email account that you tried to reach is disabled. Learn more at', true, '5.2.1'];
        yield ['smtp; 550 sorry, user over quota [mail129] (#5.1.1)', true, '5.1.1'];
        yield ['#5.1.0 Address rejected.', true, '5.1.0'];
        yield ['SMTP blablabla Error 550 5.2.1 https://support.google.com/mail/ - gsmtp', true, '5.2.1'];
        yield ['1 Requested mail action aborted, mailbox not found', true, '5.1.1'];
        yield ['No Such User Here', true, '5.1.1'];
        yield ['smtp; 550 rene.huchet@paris.notaires.fr unknown user account', true, '5.1.1'];
        yield ['pibandet@airfrance.fr not listed in Domino Directory (Unknown user.)', true, '5.1.1'];
        yield ['smtp; The email account that you tried to reach does not exist. Please try double-...', true, '5.1.1'];
    }

    /** @dataProvider providerEvents */
    public function testParserWorks(string $message, bool $permanent, ?string $expectedSmtpCode): void
    {
        $parser = new Parser();
        $actualCode = $parser->parse($message, $permanent);

        if (null === $expectedSmtpCode) {
            $this->assertNull($actualCode);
        } else {
            $this->assertNotNull($actualCode, 'Code not parsed');
            $this->assertSame($expectedSmtpCode, $actualCode->getCode());
        }
    }
}
