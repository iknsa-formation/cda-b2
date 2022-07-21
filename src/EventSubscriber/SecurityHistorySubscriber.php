<?php

namespace App\EventSubscriber;

use App\Entity\SecurityHistory;
use App\Model\SecurityHistoryFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\LoginFailureEvent;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;
use Symfony\Component\Security\Http\Event\LogoutEvent;

class SecurityHistorySubscriber implements EventSubscriberInterface
{
    private SecurityHistoryFactory $history;
    private $em;

    public function __construct(SecurityHistoryFactory $history, EntityManagerInterface $em)
    {
        $this->history = $history;
        $this->em = $em;
    }

    public function onLogoutEvent(LogoutEvent $event): void
    {
        if (!$event->getToken() || !$event->getToken()->getUser()) {
            return;
        }

        $history = $this->history->getLogoutEvent();

        $history->setUser($event->getToken()->getUser());

        $this->em->persist($history);

        $this->em->flush();
    }

    public function onLoginFailureEvent(LoginFailureEvent $event)
    {
        if (!$event->getPassport() || $event->getPassport()->getUser()) {
            return;
        }

        $history = $this->history->getLoginFailureEvent();
        $history->setUser($event->getPassport()->getUser());

        $this->em->persist($history);

        $this->em->flush();
    }

    public function onLoginSuccessEvent(LoginSuccessEvent $event)
    {
        $history = $this->history->getLoginSuccessEvent();

        $history->setUser($event->getUser());

        $this->em->persist($history);

        $this->em->flush();
    }

    public static function getSubscribedEvents(): array
    {
        return [
            LogoutEvent::class => 'onLogoutEvent',
            LoginSuccessEvent::class => 'onLoginSuccessEvent',
            LoginFailureEvent::class => 'onLoginFailureEvent'
        ];
    }
}
