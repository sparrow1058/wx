<?php
require_once dirname (__FILE__).'./../common/Common.php';
require_once dirname (__FILE__).'./../class/SSQLottery.php';

$LMax=11;
$action = $_GET['action'];
$num=$_POST['num'];
$htmlClass=new ShowHtml();
$ssqDatabase=new SSQLottery();
$ssqDatabase->init();
$nums=$ssqDatabase->getRballs($num);
$htmlClass->showTableHead();
$trStr='<TR><TD  class=p8 colspan='.$LMax.'>'.$num.'</TD> </TR>';
//$htmlClass->echoStr($trStr);
echo $trStr;
for($i=1;$i<7;$i++)
{
	$RStr='R'.$i;
	$result=$ssqDatabase->getRLost($nums[0][$RStr],$LMax-1);
	$css='p'.($i%2);
	$htmlClass->echoOneTR($css,$result,$LMax);

}	
$htmlClass->showTableTail();	
	
switch ($action){
	case 'showrlost':
		showRLost($nums);
		break;
	case 'shorblost':
		showBLost($nums);
		break;
	default :
		break;
}




function showRLost($nums)
{
	
		
		
  

	
}
