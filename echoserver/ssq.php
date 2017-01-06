<?php
define ('SSQ_DATA',"./image/data.txt");
require_once dirname (__FILE__).'/common/Common.php';
require_once dirname (__FILE__).'/class/SSQLottery.php';
$rtimes=11;
$numTimes=10;
$webIndex=$_GET['index'];
$html_class=new ShowHtml();
$html_class->showWebHead();

$ssq= new SSQLottery();
$ssq->init();


if($webIndex=='allballs'||$webIndex==''){
	echo 'allballs';
	$html_class->showAllBallsHead();
	$result=$ssq->getAllBalls($numTimes);
	$html_class->echoMultTR($result,1,11);
	
}else if($webIndex=='rballs'){
	$html_class->showRLostHead($rtimes);
	for($i=1;$i<34;$i++)
	{
		$result=$ssq->getRLost($i,$rtimes-1);
		$css='p'.($i%2);
		$html_class->echoOneTR($css,$result,$rtimes);
	}
}else if($webIndex=='bballs'){
	
	echo 'bballs';
}else if($webIndex=='update'){
	//$html_class->showProcessBar();
	$ssq->updateBaseDataFromFile(SSQ_DATA);	
	$ssq->updateLostRtable();	
}


$html_class->showWebTail();

/*
$ssq= new SSQLottery();
$ssq->init();
//$ret=$ssq->getLastId(1);
$ssq->updateBaseDataFromFile(SSQ_DATA);
$ssq->updateLostRtable(8);
*/
