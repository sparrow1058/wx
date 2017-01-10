<?php
define ('SSQ_DATA',dirname (__FILE__)."/image/data.txt");
require_once dirname (__FILE__).'/common/Common.php';
require_once dirname (__FILE__).'/class/SSQLottery.php';
$RLostHead=array("数字",'&nbspL01','&nbspL02','&nbspL03','&nbspL04','&nbspL05','&nbspL06','&nbspL07','&nbspL08',' L09','L10','L11','L12','L13','L14','L15','L16','L17','L18','L19','R20');
$allBallsHead=array("List&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp",'&nbspR01','&nbspR02','&nbspR03','&nbspR04','&nbspR05','&nbspR06','&nbspB01','&nbspSUM','&nbspOED','&nbspLOST');

class ssq {
	private $_webIndex;
	private $_htmlClass;	
	private $_ssqDatabase;
	private $_nper=6;
	private $_ncol=10;
	function init()
	{
		//$this->_webIndex=$index;
		$this->_htmlClass=new ShowHtml();
		$this->_ssqDatabase=new SSQLottery();
		$this->_ssqDatabase->init();
	}
	function showWeb($index)
	{
		 switch ($index)
		 {
			 case "allballs":
				$this->showAllBalls();
				break;
			case "rlost":
				$this->showRlost();
				break;
			case "blost":
				break;
			case "update":
				$this->_ssqDatabase->updateBaseDataFromFile(SSQ_DATA);	
				$this->_ssqDatabase->updateLostRtable();
				break;
		 }
	}
	function showAllBalls()
	{
		$this->_htmlClass->showTableHead();
		$result=$this->_ssqDatabase->getAllBalls($this->_nper);
		$this->_htmlClass->echoMultTR($result,1,$this->_ncol);
		$this->_htmlClass->showTableTail();
	}
	function showRlost()
	{
		$this->_htmlClass->showTableHead();
		for($i=1;$i<34;$i++)
		{
			$result=$this->_ssqDatabase->getRLost($i,$this->_ncol-1);
			$css='p'.($i%2);
			$this->_htmlClass->echoOneTR($css,$result,$this->_ncol);
		}
		$this->_htmlClass->showTableTail();
	}	
	
}





