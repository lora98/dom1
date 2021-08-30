<?php

include '../../baza/broker.php';
$broker=Broker::getBroker();

$naziv=$_POST["naziv"];
$opis=$_POST["opis"];
$id=$_POST["id"];


$res=$broker->izmeni("update planina set naziv='".$naziv."', opis='".$opis."' where id=".$id);
echo json_encode($res);
?>