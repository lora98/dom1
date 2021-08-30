<?php

include '../../baza/broker.php';
$broker=Broker::getBroker();

$naziv=$_POST["naziv"];
$opis=$_POST["opis"];
$zvezdice=$_POST["zvezdice"];
$planina=$_POST["planina"];


$res=$broker->izmeni("insert into hotel (naziv,opis,zvezdice,planina) values ('".$naziv."','".$opis."',".$zvezdice.",".$planina.")");
echo json_encode($res);
?>