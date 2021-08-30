<?php

include '../../baza/broker.php';

$broker=Broker::getBroker();

$res=$broker->izmeni('delete from hotel where id='.$_POST['id']);
echo json_encode($res);
?>