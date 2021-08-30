<?php

include '../../baza/broker.php';

$broker=Broker::getBroker();

$res=$broker->ucitaj('select * from planina');
echo json_encode($res);
?>