<?php


namespace App\notification ;

use App\Entity\User;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class Sender{

    public function __construct(private MailerInterface $mailer)
    {

    }


    public function sendMailNewUser(User $user){
        $message = new Email();
        $message->from('account@serie.com')
            ->to('admin@serie.com')
            ->subject('new account')
            ->html("<h1>new user</h1> email : " . $user->getEmail()  );

    }
}