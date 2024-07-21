<?php
 namespace taskforce\actions;

 abstract class AbstractAction{
    abstract public static function getName();
    abstract public static function getInternalName();
    abstract public static function checkRights($performer_id, $customer_id, $user);
 }
