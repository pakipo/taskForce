<?php 

namespace taskforce\actions;
use taskforce\actions\AbstractAction;

class Deny extends AbstractAction
{
    public static function getName():string
    {
        return 'Отказаться';
    }

    public static function getInternalName():string
    {
        return 'deny';
    }

    public static function checkRights($performer_id, $customer_id, $user):bool
    {
        return $performer_id == $user;
    }
}