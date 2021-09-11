<?php

declare(strict_types=1);

namespace AssoConnect\SmtpCode\Parser;

use AssoConnect\SmtpCode\Code;

class TextSearchParser
{
    public function parse(string $message, bool $permanent): ?Code
    {
        foreach ($this->getNeedles($permanent) as $needle => $code) {
            $message = strtolower($message);
            $needle = strtolower($needle);

            if (strpos($message, $needle) === false) {
                continue;
            }

            // Failure is permanent but found code is not
            if (substr($code, 0, 1) === '4' && $permanent === true) {
                continue;
            }

            // Failure is not permanent but found code is
            if (substr($code, 0, 1) === '5' && $permanent === false) {
                continue;
            }

            return Code::buildFromString($code);
        }

        return null;
    }

    private function getNeedles(bool $permanent): iterable
    {
        // X.1.1 Bad destination mailbox address
        yield 'mailbox not found' => '5.1.1';
        yield 'No Such User Here' => '5.1.1';
        yield 'unknown user account' => '5.1.1';
        yield 'Unknown user' => '5.1.1';
        yield 'User unknown' => '5.1.1';
        yield 'Utilisateur inconnu' => '5.1.1';
        // Used by Gmail
        yield 'smtp; The email account that you tried to reach does not exist' => '5.1.1';
        // Used by IBM - Domino Directory
        yield 'Domino Directory' => '5.1.1';

        // X.2.1 Mailbox disabled, not accepting messages
        yield 'mailbox unavailable' => $permanent ? '5.2.1' : '4.2.1';
        yield 'This address no longer accepts mail' => $permanent ? '5.2.1' : '4.2.1';

        // X.2.2 Mailbox full
        yield 'account is full' => $permanent ? '5.2.2' : '4.2.2';
        yield 'over quota' => $permanent ? '5.2.2' : '4.2.2';

        // X.4.2 Bad connection
        yield 'Connection timed out' => $permanent ? '5.4.2' : '4.4.2';
        yield 'timeout' => $permanent ? '5.4.2' : '4.4.2';

        // X.4.6 Routing loop detected
        yield 'hop count exceeded' => $permanent ? '5.4.6' : '4.4.6';

        // X.5.0 Other or undefined protocol status
        yield 'No MX' => '5.5.0';

        // X.7.1 Delivery not authorized, message refused
        yield 'message has been greylisted' => '4.7.1';
        yield 'Your message looks like SPAM or has been reported as SPAM' => $permanent ? '5.7.1' : '4.7.1';
        // Used by Free
        yield 'Too many spams from your IP' => $permanent ? '5.7.1' : '4.7.1';
        yield 'spam detected' => $permanent ? '5.7.1' : '4.7.1';
        // User by Mimecast
        yield 'Envelope blocked - User Entry - https://community.mimecast.com/docs/DOC-1369#550' => '5.7.1';
        yield 'Envelope blocked - User Domain Entry - https://community.mimecast.com/docs/DOC-1369#550' => '5.7.1';

        // X.7.13 User Account Disabled
        yield 'deactivated' => '5.7.13';
        // Used by Orange
        yield 'disabled mailbox' => '5.7.13';
        // Used by Yahoo
        yield 'This mailbox is disabled' => '5.7.13';

        // X.7.28 Mail flood detected
        // Used by Free
        yield 'Server busy, too many connections from your IP' => '4.7.28';
        // Used by Orange
        yield 'OFR004_104 [104]' => '4.7.28';
    }
}
