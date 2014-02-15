<?php

/**
 * Created by PhpStorm.
 * User: shart
 * Date: 14.01.14
 * Time: 21:05
 */
class TicketStatus
{

    const DRAFT = 'draft';
    const NEW_TICKET = 'new';
    const ASSIGNING = 'assigning';
    const ASSIGNED = 'assigned';
    const IN_PROGRESS = 'in_progress';
    const CHECKING = 'checking';
    const DONE = 'done';
    const REJECTED = 'rejected';


    public static function isValid($status)
    {
        return in_array($status, array(
            self::DRAFT,
            self::NEW_TICKET,
            self::ASSIGNING,
            self::ASSIGNED,
            self::IN_PROGRESS,
            self::CHECKING,
            self::DONE,
            self::REJECTED,

        ));
    }

}
