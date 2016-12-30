<?php
define ('SSQ_DATA',"./image/data.txt");
require_once dirname (__FILE__).'/class/SSQLottery.php';
$ssq= new SSQLottery();
$ssq->init();
//$ret=$ssq->getLastId(1);
$ssq->updateBaseDataFromFile(SSQ_DATA);
$ssq->updateLostRtable(8);
//var_dump($ret);
//get_ssq_data(SSQ_DATA);