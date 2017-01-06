<?php
require_once dirname (__FILE__)."./../html/htmlhead.php";
class ShowHtml{
	
	public function showWebHead()
	{
		echo HTML_HEAD;
	}
	public function showWebTail()
	{
		echo HTML_TAIL;
	}
	function echoOneTR($style,$array,$maxtd)
	{
		echo '<TR>';
		for($i=0;$i<$maxtd;$i++)
			echo '<TD class='.$style.'>'.$array[$i].'</TD>';
		echo '</TR>';
	}
	function echoMultTR($array,$start,$length)
	{
		//var_dump($array);
		$num=0;
		foreach ($array as $tdline)
		{
			$num++;
			$tdstr=array_values($tdline);
			$css='p'.($num%2);
		echo '<TR>';
			
		for($i=0;$i<$length;$i++){
			$tmpstr=str_pad($tdstr[$i+$start],2,"0",STR_PAD_LEFT);
			if($i>=7)
				$css='p'.$i;
			echo '<TD class='.$css.'>'.$tmpstr.'</TD>';
		}
	
		echo '</TR>';
		}
		
	}
	function showRLostHead($max){
		
	//	$this->showWebHead();
		$RLostHead=array("数字",'&nbspL01','&nbspL02','&nbspL03','&nbspL04','&nbspL05','&nbspL06','&nbspL07','&nbspL08',' L09','L10','L11','L12','L13','L14','L15','L16','L17','L18','L19','R20');
		$this->echoOneTR(CSS3,$RLostHead,$max);
	//	$this->showWebTail();
	}
	function showAllBallsHead(){
		$allBallsHead=array("List&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp",'&nbspR01','&nbspR02','&nbspR03','&nbspR04','&nbspR05','&nbspR06','&nbspB01','&nbspSUM','&nbspOED','&nbspLOST');
		$this->echoOneTR(CSS3,$allBallsHead,count($allBallsHead,COUNT_NORMAL));
		
	}
	function showProcessBar($cap){
		   $pos=$cap*439;	
		  $pos= round($pos)-420;
		  echo '<div class="percents" style=#000000>' .round($cap*100).'%</div>';
 		  echo '<div class="blocks" style="left: '.$pos.'px"> </div>';
	}
	
}


