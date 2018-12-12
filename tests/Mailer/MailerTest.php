<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12/12/18
 * Time: 4:21 PM
 */

namespace App\Tests\Mailer;


use App\Entity\User;
use App\Mailer\Mailer;
use PHPUnit\Framework\TestCase;

class MailerTest extends TestCase
{
    public function testConfirmationEmail()
    {
        $user = new User();
        $user->setEmail('john@snow.com');

        $swiftMailer = $this->getMockBuilder(\Swift_Mailer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $swiftMailer->expects($this->once())->method('send')
            ->with(
                $this->callback(
                    function ($subject) {
                        $messageStr = (string)$subject;

                        return strpos($messageStr, 'From: blah@blah.com') !== false
                            && strpos($messageStr, 'To: john@snow.com') !== false
                            && strpos($messageStr, 'Subject: Welcome abroad') !== false
                            && strpos($messageStr, 'This is a message body') !== false;
                    }
                )
            );

        $twigMock = $this->getMockBuilder(\Twig_Environment::class)
            ->disableOriginalConstructor()
            ->getMock();
        $twigMock->expects($this->once())->method('render')->with(
            'email/registration.html.twig',
            [
                'user' => $user,
            ]
        )->willReturn('This is a message body');

        $mailer = new Mailer($swiftMailer, $twigMock, 'blah@blah.com');
        $mailer->sendConfirmationEmail($user);
    }
}