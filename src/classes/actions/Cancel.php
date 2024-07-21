<?php 

namespace taskforce\actions;
use taskforce\actions\AbstractAction;

class Cancel extends AbstractAction
{
    public static function getName():string
    {
        return 'Отменить';
    }

    public static function getInternalName():string
    {
        return 'cancel';
    }

    public static function checkRights($performer_id, $customer_id, $user):bool
    {
        return $user == $customer_id;
    }
}