<?php

declare(strict_types=1);

namespace AssoConnect\SmtpCode;

use AssoConnect\SmtpCode\Parser\RegexParser;
use AssoConnect\SmtpCode\Parser\TextSearchParser;

class Parser
{
    private RegexParser $regexParser;
    private TextSearchParser $textSearchParser;

    public function __construct()
    {
        $this->regexParser = new RegexParser();
        $this->textSearchParser = new TextSearchParser();
    }

    public function parse(string $message, bool $permanent): ?Code
    {
        // Search with a regex
        if (null !== $code = $this->regexParser->parse($message)) {
            return $code;
        }

        // Search with a string
        if (null !== $code = $this->textSearchParser->parse($message, $permanent)) {
            return $code;
        }

        return null;
    }
}
