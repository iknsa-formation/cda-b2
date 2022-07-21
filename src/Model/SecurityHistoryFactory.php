<?php

namespace App\Model;

use App\Entity\SecurityHistory;


class SecurityHistoryFactory
{
    private SecurityHistory $history;

    public function __construct(SecurityHistory $history)
    {
        $this->history = $history;
        $this->history->setEventAt(new \DateTimeImmutable);
    }

    public function getLoginSuccessEvent()
    {
        return $this->history->setEvent(SecurityHistory::ON_LOGIN_SUCCESS_EVENT);
    }

    public function getLogoutEvent()
    {
        return $this->history->setEvent(SecurityHistory::ON_LOGOUT_EVENT);
    }

    public function getAuthenticationFailureEvent()
    {
        return $this->history->setEvent(SecurityHistory::ON_AUTHENTICATION_FAILURE_EVENT);
    }
}
