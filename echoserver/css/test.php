<?php
require_once dirname (__FILE__).'./../common/Common.php';
require_once dirname (__FILE__).'./../class/SSQLottery.php';
$action = $_GET['action'];
$num=$_POST['num'];
$jssocket=new JSSocket();
	
switch ($action){
	case 'showrlost':
		$jssocket->showRLost($num);
		break;
	case 'shorblost':
		$jssocket->showBLost($num);
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
	case 'delnew':
		$password=$_POST['password'];
		$jssocket->delNewData($password);
		break;
	default :
		break;
}
class JSSocket{
	private $_htmlClass;
	private $_ssqDatabase;
	private $_LMax;
	public function __construct(){
		$this->_htmlClass=new ShowHtml();
		$this->_ssqDatabase=new SSQLottery();
		$this->_ssqDatabase->init();
		$this->_LMax=11;
	}
	public function showRLost($num){
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
		
}

