<?php

declare(strict_types=1);

namespace AssoConnect\SmtpCode;

use AssoConnect\SmtpCode\Parser\RegexParser;
use AssoConnect\SmtpCode\Parser\TextSearchParser;

class Parser
{
    public static function parse(string $message, bool $permanent): ?Code
    {
        // Search with a regex
        if (null !== $code = (new RegexParser())->parse($message)) {
            return $code;
        }

        // Search with a string
        if (null !== $code = (new TextSearchParser())->parse($message, $permanent)) {
            return $code;
        }

        return null;
    }
}
