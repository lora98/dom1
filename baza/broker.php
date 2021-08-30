<?php

class Broker{
   
    private $mysqli;
    private static $broker;
    
    
    
    private function __construct(){
        $this->mysqli = new mysqli("localhost", "root", "", "planine");
        $this->mysqli->set_charset("utf8");
    }

    public static function getBroker(){
        if(!isset($broker)){
            $broker=new Broker();
        }
        return $broker;
    }
    
    function ucitaj($upit){
        $rezultat=$this->mysqli->query($upit);
        $rez=[];
        if(!$rezultat){
            $rez['status']=false;
            $rez['greska']=$this->mysqli->error;
        }else{
            $rez['status']=true;
            while($red=$rezultat->fetch_object()){
                $rez['podaci'][]=$red;
            }
        }
        return $rez;
    }
    function izmeni($upit){
        $rezultat=$this->mysqli->query($upit);
        $rez=[];
        if(!$rezultat){
            $rez['status']=false;
            $rez['greska']=$this->mysqli->error;
        }else{
            $rez['status']=true;
           
        }
        return $rez;
    }
   
}

?>
