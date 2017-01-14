<?php
require_once dirname (__FILE__).'./../common/Common.php';
require_once dirname (__FILE__).'./../class/SSQLottery.php';
$action = $_GET['action'];
$num=$_POST['num'];
$jssocket=new JSSocket();
switch ($action){
	case 'showall':
		$jssocket->showAllBalls();
		break;
	case 'showsubrlost':
		$jssocket->showSubRLost($num);
		break;
	case 'showrlost':
		$jssocket->showRLost();
		break;	
	case 'showrange':
		$jssocket->showRange();
		break;
	case 'showblue':
		$jssocket->showBlue($num);
		break;
	case 'update':
		$jssocket->showThreeNums();
		break;
	case 'updateone':
		$user=$_POST['user'];
		$num=$_POST['num'];
		$data=$_POST['data'];		
		$jssocket->addOneNums($user,$num,$data);
		break;
	case 'updateFromFile':
		$jssocket->updateFromFile();
		break;
	case 'delnew':
		$password=$_POST['password'];
		$jssocket->delNewData($password);
		break;
	case 'test':
		$jssocket->getBlueBallChart();
		break;
	default :
		break;
}
class JSSocket{
	private $_htmlClass;
	private $_ssqDatabase;
	private $_LMax=11;
	private $_nper=6;
	private $_nmax=13;
	private $_ncol=10;
	public function __construct(){
		$this->_htmlClass=new ShowHtml();
		$this->_ssqDatabase=new SSQLottery();
		$this->_ssqDatabase->init();
		
	}
	public function showSubRLost($num){
		$nums=$this->_ssqDatabase->getRballs($num);
		$this->_htmlClass->showTableHead();
		$trStr='<TR><TD  class=p8 colspan='.$this->_LMax.'>'.$num.'</TD> </TR>';
		//$htmlClass->echoStr($trStr);
		echo $trStr;
		for($i=1;$i<7;$i++)
		{
		$RStr='R'.$i;
		$result=$this->_ssqDatabase->getRLost($nums[0][$RStr],$this->_LMax-1);
		$css='p'.($i%2);
		$this->_htmlClass->echoOneTR($css,$result,$this->_LMax);

		}	
		$this->_htmlClass->showTableTail();
	}
	public function showBlue(){
		$BLength=7;
		$this->_htmlClass->showTableHead();
		$trHead='<TR class=p7><TD>  </TD><TD>Num</TD><TD>DIFF</TD><TD>MOD0</TD><TD>MOD1</TD><TD>MOD2</TD><TD>MOD3</TD></TR>';
		echo $trHead;
		$result=$this->_ssqDatabase->getBballs($this->_LMax);
		$this->_htmlClass->echoMultTRS($result,0,$BLength);
		$this->_htmlClass->showTableTail();	
		
	}
	public function showThreeNums()
	{
		$result=$this->_ssqDatabase->getBalls(3);
		echo json_encode($result);
		//var_dump($result);
				
	}
	public function addOneNums($user,$num,$data){
		if($user=="leaf")
		{
			$numstr=$num.$data;
			$this->_ssqDatabase->addOneNums($numstr);
		}
	}
	public function delNewData($password){
		if($password=="leaf123")
		{
			$this->_ssqDatabase->delNewData($numstr);
			echo  1;
		}else{
			echo 0;
		}
	}
	public function updateFromFile(){
		$this->_ssqDatabase->updateBaseDataFromFile(SSQ_DATA);	
		$this->_ssqDatabase->updateLostRtable();
		$this->_ssqDatabase->updateBTable();
	}
		
	function showAllBalls()
	{
		$this->_htmlClass->showTableHead();
		$result=$this->_ssqDatabase->getAllBalls($this->_nper);
		$this->_htmlClass->echoMultTR($result,1,$this->_ncol);
		$this->_htmlClass->showTableTail();
	}
	function showRLost()
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
	function showRange()
	{
		$this->_htmlClass->showTableHead();
		$result=$this->_ssqDatabase->getRange($this->_nmax);
		$this->_htmlClass->echoMultTR($result,0,3);
		$this->_htmlClass->showTableTail();

	}
	function getBlueBallChart()
	{
		$result=$this->_ssqDatabase->getBballs(28);
		echo json_encode($result);
		
	}
}

