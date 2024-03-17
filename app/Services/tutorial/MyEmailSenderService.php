<?php

namespace App\Services\tutorial;

use App\Models\DemoEmail;
use Symfony\Component\Mailer\Transport\Smtp\SmtpTransport;

class MyEmailSenderService
{
    public function sendTrackedEmail($email, $id)
    {
        $head = '<head>' . 'Email Tracker' . '</head>';
        $body = '<body' >
            $body .= '<img alt="" src="' . 'https://emailmarketing.queleadscrm.com' . '/track/user/' . $id . '">';
        $body .= 'Tanjib' . '</body>';
        $html = '<html>' . $head . $body . '</html>';

        $transport = (new Swift_SmtpTransport('smtp.gmail.com', 467, 'tls'))
            ->setUsername('tanjib@quadque.tech')
            ->setPassword('viez bbwu zyxy wvhc');

        $mailer = new Swift_Mailer($transport);

        $message = (new Swift_Message('My Email Subject'))
            ->setFrom('tanjib@quadque.tech', 'This is my company name')
            ->setTo($email)
            ->setBody($html, 'text/html');

        $mailer->send($message);
    }
}
