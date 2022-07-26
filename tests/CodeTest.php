<?php

declare(strict_types=1);

namespace AssoConnect\SmtpCode\Tests;

use AssoConnect\SmtpCode\Code;
use AssoConnect\SmtpCode\Exception\InvalidCodeException;
use PHPUnit\Framework\TestCase;

class CodeTest extends TestCase
{
    public function testInvalidCodeThrowsAnException(): void
    {
        $this->expectException(InvalidCodeException::class);
        Code::buildFromString('john doe');
    }

    public function testGettersWork(): void
    {
        $code = new Code($class = 4, $subject = 1, $detail = 2);
        self::assertSame($class, $code->getClass());
        self::assertSame($subject, $code->getSubject());
        self::assertSame($detail, $code->getDetail());
        self::assertSame('4.1.2', $code->getCode());
    }

    public function testIsPermanent(): void
    {
        self::assertTrue((new Code(5, 0, 0))->isPermanent());
        self::assertFalse((new Code(4, 0, 0))->isPermanent());
    }
}
