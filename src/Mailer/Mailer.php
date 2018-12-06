<?php
/**
 * Created by PhpStorm.
 * User: andreyfilenko
 * Date: 2018-12-05
 * Time: 18:49
 */

namespace App\Mailer;


use App\Entity\User;

class Mailer
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var \Twig_Environment
     */
    private $twig;
    /**
     * @var string
     */
    private $mailFrom;

    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $twig, string $mailFrom)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->mailFrom = $mailFrom;
    }

    public function sendConfirmationEmail(User $user)
    {
        $message = (new \Swift_Message())
            ->setSubject('Welcome abroad!')
            ->setFrom($this->mailFrom)
            ->setTo($user->getEmail())
            ->setBody($this->twig->render('email/registration.html.twig', [
                'user' => $user
            ]), 'text/html');

        $this->mailer->send($message);
    }
}