<?php

include '../../baza/broker.php';
$broker=Broker::getBroker();

$naziv=$_POST["naziv"];
$opis=$_POST["opis"];
$filename =(isset($_FILES['slika']))?$_FILES['slika']['name']:"";
$location = "../../assets/".$filename;
if(!move_uploaded_file($_FILES['slika']['tmp_name'],$location)){
    $location="";
}

$res=$broker->izmeni("insert into planina (naziv,opis,slika) values ('".$naziv."','".$opis."','".$_FILES['slika']['name']."')");
echo json_encode($res);
?>