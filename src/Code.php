<?php

declare(strict_types=1);

namespace AssoConnect\SmtpCode;

use AssoConnect\SmtpCode\Exception\InvalidCodeException;

/**
 * SMTP Code
 *
 * @link https://en.wikipedia.org/wiki/List_of_SMTP_server_return_codes
 * @link https://datatracker.ietf.org/doc/html/rfc3463
 * @link https://www.iana.org/assignments/smtp-enhanced-status-codes/smtp-enhanced-status-codes.xhtml
 */
class Code
{
    public const CLASS_SUCCESS = 2;
    public const CLASS_PERSISTENT_TRANSIENT_FAILURE = 4;
    public const CLASS_PERMANENT_FAILURE = 5;

    private int $class;
    private int $subject;
    private int $detail;

    public function __construct(int $class, int $subject, int $detail)
    {
        $this->class = $class;
        $this->subject = $subject;
        $this->detail = $detail;
    }

    public static function buildFromString(string $code): self
    {
        if (preg_match('/^(2|4|5)\.([0-7]{1,3})\.([0-9]{1,3})$/', $code, $matches) !== 1) {
            throw new InvalidCodeException($code);
        }

        return new self(intval($matches[1]), intval($matches[2]), intval($matches[3]));
    }

    public function getCode(): string
    {
        return $this->class . '.' . $this->subject . '.' . $this->detail;
    }

    public function __toString(): string
    {
        return $this->getCode();
    }

    public function getClass(): int
    {
        return $this->class;
    }

    public function getSubject(): int
    {
        return $this->subject;
    }

    public function getDetail(): int
    {
        return $this->detail;
    }

    public function isPermanent(): bool
    {
        return self::CLASS_PERMANENT_FAILURE === $this->class;
    }
}
