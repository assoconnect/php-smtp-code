<?php

declare(strict_types=1);

namespace AssoConnect\SmtpCode\Parser;

use AssoConnect\SmtpCode\Code;

class RegexParser
{
    private const REGEXP = '(2|4|5)\.(0\.0|1\.[0-9]{1,2}|2\.[0-4]|3\.[0-5]|4\.[0-7]|5\.[0-5]|6\.[0-9]|7\.[0-9]{1,2})';

    public function parse(string $message): ?Code
    {
        foreach ($this->getPatterns() as $pattern) {
            if (preg_match($pattern, $message, $matches) === 1) {
                return new Code(
                    intval($matches[1]),
                    intval(substr($matches[2], 0, 1)),
                    intval(substr($matches[2], 2))
                );
            }
        }

        return null;
    }

    private function getPatterns(): iterable
    {
        // 4.2.2 The email account that you tried to reach is over quota.
        yield sprintf('/^%s /', self::REGEXP);

        // smtp; 5.3.0 - Other mail system problem
        yield sprintf('/^smtp; %s /i', self::REGEXP);

        // SMTP; 451 4.4.4 Temporary server error.
        // SMTP;451 4.4.4 Temporary server error.
        // SMTP; 550 #5.1.0 Address rejected.
        // smtp; 550-5.2.1 The email account that you tried to reach is disabled. Learn more at
        yield sprintf('/^smtp; ?[0-9]{3}[ #-]+%s /i', self::REGEXP);

        // smtp; 550 sorry, user over quota [mail129] (#5.1.1)
        // sorry, no mailbox here by that name. (#5.1.1)
        yield sprintf('/ \(#%s\)$/', self::REGEXP);

        // #5.1.0 Address rejected.
        yield sprintf('/^#%s /', self::REGEXP);

        // Used by Google
        // X-Notes; Erreur de transfert vers aspmx.l.google.COM  ; SMTP Protocol Returned a Permanent Error 550 5.2.1
        // https://support.google.com/mail/?p=DisabledUser d191si5186880wmd.218 - gsmtp
        yield sprintf('/[0-9]{3} %s.* - gsmtp$/', self::REGEXP);
    }
}
