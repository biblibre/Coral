<?php

$fundid = $_GET['fundid'];
$ilsClient = (new ILSClientSelector())->select();
$fund = $ilsClient->getFund($fundid);
print $fund['shortName'] . " [" . $fund['fundCode'] . "]";

?>
