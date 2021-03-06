<?php
/**
 * Created by PhpStorm.
 * User: andreyfilenko
 * Date: 2018-12-05
 * Time: 18:29
 */

namespace App\Event;

use App\Entity\UserPreferences;
use App\Mailer\Mailer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserSubscriber implements EventSubscriberInterface
{
    /**
     * @var Mailer
     */
    private $mailer;
    /**
     * @var EntityManager
     */
    private $entityManager;
    /**
     * @var string
     */
    private $defaultLocale;

    public function __construct(
        Mailer $mailer,
        EntityManagerInterface $entityManager,
        string $defaultLocale
    )
    {
        $this->mailer = $mailer;
        $this->entityManager = $entityManager;
        $this->defaultLocale = $defaultLocale;
    }

    public static function getSubscribedEvents()
    {
        return [
            UserRegisterEvent::NAME => 'onUserRegister'
        ];
    }

    public function onUserRegister(UserRegisterEvent $event)
    {
        $preferences = new UserPreferences();
        $preferences->setLocale($this->defaultLocale);

        $this->entityManager->flush();

        $this->mailer->sendConfirmationEmail($event->getRegisteredUser());
    }
}