<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Event\LogoutEvent;

class SecurityLoginCounterSubscriber implements EventSubscriberInterface
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function onLoginSuccessEvent(LoginSuccessEvent $event): void
    {
        /** @var User */
        $user = $event->getUser();
        $user->setConnectionCounter($user->getConnectionCounter() + 1);
        $user->setLastConnectionAt(new \DateTimeImmutable());

        $this->em->persist($user);
        $this->em->flush();
    }

    public static function getSubscribedEvents(): array
    {
        return [
            LoginSuccessEvent::class => 'onLoginSuccessEvent'
        ];
    }
}
