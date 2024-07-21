<?php 

namespace taskforce\actions;
use taskforce\actions\AbstractAction;

class Complete extends AbstractAction
{
    public static function getName():string
    {
        return 'Принять';
    }

    public static function getInternalName():string
    {
        return 'complete';
    }

    public static function checkRights($performer_id, $customer_id, $user):bool
    {
        return $customer_id == $user;
    }
}