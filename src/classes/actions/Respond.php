<?php 

namespace taskforce\actions;
use taskforce\actions\AbstractAction;

class Respond extends AbstractAction
{
    public static function getName():string
    {
        return 'Откликнуться';
    }

    public static function getInternalName():string
    {
        return 'respond';
    }

    public static function checkRights($performer_id, $customer_id, $user):bool
    {
        return $user == $performer_id;
    }
}