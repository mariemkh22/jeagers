<?php
// src/Notification/NotificationMailer.php

namespace App\Notification;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;
use App\Controller\NotificationManager;

class NotificationMailer
{
    
        private $mailer;
    
        public function __construct(MailerInterface $mailer)
        {
            $this->mailer = $mailer;
        }
    
        public function sendEmail($recipient, $subject, $content)
        {
            $email = (new Email())
                ->from('mariem.khelifi3@gmail.com')
                ->to($recipient)
                ->subject($subject)
                ->text($content);
    
            $this->mailer->send($email);
        }
    }
