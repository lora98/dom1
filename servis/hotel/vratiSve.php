<?php

include '../../baza/broker.php';

$broker=Broker::getBroker();

$res=$broker->ucitaj("select h.*, p.naziv as 'naziv_planine' from hotel h inner join planina p on (p.id=h.planina)");
echo json_encode($res);
?>