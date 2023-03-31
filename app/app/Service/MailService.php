<?php declare(strict_types=1);

namespace App\Service;

use App\Mail\EmailInterface;
use Illuminate\Support\Facades\Mail;

class MailService
{
    public function send(string $email, EmailInterface $template): void
    {
        Mail::to($email)->send($template);
    }
}