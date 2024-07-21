<?php
namespace taskforce;
use taskforce\actions\Cancel;
use taskforce\actions\Complete;
use taskforce\actions\Respond;
use taskforce\actions\Deny;
use taskforce\exeptions\TaskForceExeption;
class TaskCore
{
    private $performer_id;
    private $customer_id;
    private $current_status = self::STATUS_NEW;

    //новая задача
    const STATUS_NEW = 'new_task';
    //задача отменена
    const STATUS_CANCELLED = 'cancelled';
    //задача в работе
    const STATUS_IN_PROGRESS = 'in_progress';
    //задача выполнена
    const STATUS_COMPLETED = 'completed';
    //задача провалена
    const STATUS_FAILED = 'failed';

    //заказчик отменил
    // const ATIONS_CANCEL = 'cancel';
    // //исполнитель откликнулся

    // const ATIONS_RESPOND = 'respond';
    // //заказчик принял

    // const ATIONS_COMPLETE = 'complete'; 
    // //исполнитель отказался

    // const ATIONS_DENY = 'deny';
const LOCALE = [
   self::STATUS_NEW => 'Новое задание', 
   self::STATUS_CANCELLED => 'Задание отменено', 
   self::STATUS_IN_PROGRESS => 'Задание в работе',
   self::STATUS_COMPLETED => 'Задание выполнено',
   self::STATUS_FAILED => 'Задание провалено',
];

    // //исполнитель
    // const ROLE_PERFORMER = 'performer';
    // //заказчик
    // const ROLE_CUSTOMER = 'customer';


    const AVAILABLE_ACTIONS = [
        self::STATUS_NEW =>[ Cancel::class,Respond::class],
        self::STATUS_IN_PROGRESS => [ Complete::class,Deny::class],
        self::STATUS_CANCELLED =>[],
        self::STATUS_COMPLETED =>[],
        self::STATUS_FAILED =>[],

    ];

    const NEXT_STATUS = [
        Complete::class => self::STATUS_COMPLETED,
        Cancel::class => self::STATUS_CANCELLED,
        Respond::class => self::STATUS_IN_PROGRESS,
        Deny::class => self::STATUS_FAILED
    ];
    function __construct(string $status,int $cus_id,int $per_id)
    {
        $this ->performer_id = $per_id;
        $this ->customer_id = $cus_id;
        $this->setStatus($status);
    }

   private function setStatus(string $status):void{
    try{
        $this->checkStatus($status);
        if(in_array($status,$this->getAllStatuses())){
            $this->current_status = $status;
        }
    }catch(TaskForceExeption $e){
        var_dump('catch$e');
        var_dump($e);
    }
      
   }

    function getAvailabelActions(string $status):string{
       return self::AVAILABLE_ACTIONS[$status];
    }

    function getCurrentAvailabelActions(int $user):string|null{
        $fltr = function($cl)use($user){ return $cl::checkRights($this->performer_id, $this->customer_id, $user);};
        $arr = array_filter(self::AVAILABLE_ACTIONS[$this->current_status],$fltr);
      //  var_dump(self::AVAILABLE_ACTIONS[$this->current_status]);
       //  var_dump($arr);
        $cls='';
        foreach($arr as $k=>$v) {
           return $v;
        }

       return null;
     }
 

    function getNextStatus(string $actions){
       if(isset(self::NEXT_STATUS[$actions])){
           return self::NEXT_STATUS[$actions];
       }
    }
    
    function getCurrentStatus(){
        return $this->current_status;
     }
     function getAllActions(){
        return [
            Cancel::class,
            Respond::class,
            Complete::class,
            Deny::class,
        ];
     }
     function getAllStatuses(){
        return [
            self::STATUS_CANCELLED,
            self::STATUS_IN_PROGRESS,
            self::STATUS_COMPLETED,
            self::STATUS_NEW,
            self::STATUS_FAILED,
        ];
     }
     function getName($const){
        if(isset(self::LOCALE[$const])){
            return self::LOCALE[$const];
        }
     }
    function checkStatus($status){
        $arrStatus = $this->getAllStatuses();
        if(!in_array($status, $arrStatus)){
            throw new TaskForceExeption("Unknown status: $status");
        }
     }
}
