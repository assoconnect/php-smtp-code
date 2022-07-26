<?php

declare(strict_types=1);

namespace AssoConnect\SmtpCode\Tests\Parser;

use AssoConnect\SmtpCode\Parser\TextSearchParser;
use PHPUnit\Framework\TestCase;

class TextSearchParserTest extends TestCase
{
    public function providerInconsistentMessage(): \Generator
    {
        yield ['mailbox not found', false];
        yield ['greylisted', true];
    }

    /** @dataProvider providerInconsistentMessage */
    public function testSeverityIsConsistent(string $message, bool $permanent): void
    {
        $parser = new TextSearchParser();
        self::assertNull($parser->parse($message, $permanent));
    }
}
