<?php
namespace taskforce\converter;
class CsvInSqlConverter{
    public $ss = 10;
    public string $dir;
    public array|false $arrFiles;
    const  CSV = '.csv';
    const INSERT = 'INSERT INTO ';
    const VALUE = 'values ';
    const DEL = 'DELETE FROM ';

    const DB = 'tasksforce';
    function __construct(string $d){
        $this->dir = $d;
        $this->arrFiles = scandir($this->dir);
        $this->checkDir();
    }

    function checkDir(){
        if(isset($this->arrFiles)&&count($this->arrFiles)){
            foreach($this->arrFiles as $k=>$v){
                if(preg_match('/'.self::CSV.'/',$v,$m)){
                
                  //  var_dump('files: ',mb_substr($v,0,stripos($v,self::CSV)));
                    $this->createSql($v,mb_substr($v,0,stripos($v,self::CSV)));
                }
                
            }
        }
    }

    function createSql(string $fName,string $name){

        $csv = file($this->dir.'/'.$fName);
        $sqlRequest = "USE ".self::DB."; ".PHP_EOL;
var_dump($csv[0][0]);
var_dump($csv[0][1]);
var_dump($csv[0][2]);
var_dump($csv[0][3]);
        $sqlRequest .= self::DEL.$name.'; '. PHP_EOL.self::INSERT.' '.$name;
        $sqlRequest .= '( '.$csv[0].')'.' '.self::VALUE.' ';
        for($i=1;$i<count($csv)-1;$i++){
            $valArr = explode(',',$csv[$i]);
           
            $sqlRequest .= "(";
            for($j=0;$j<count($valArr);$j++){
          
                $val = (float)$valArr[$j];
                if(!$val){
                    $sqlRequest .= "'".$valArr[$j]."'";
                }else{
                    $sqlRequest .= $val;
                }
                 $j != count($valArr)-1 ? $sqlRequest .= ',':null;
            }
            $sqlRequest .= ")";

            $i != count($csv)-2 ? $sqlRequest .= ','.PHP_EOL:null;
        };
        fwrite(fopen($this->dir.'/'.$name.'.sql',"w"),  $sqlRequest);
    //  var_dump(count(file($this->dir.'/'.$fName)));
    }

}