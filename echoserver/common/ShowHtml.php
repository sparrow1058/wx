<?php
//require_once dirname (__FILE__)."./../html/htmlhead.php";
define('TABLE_HEAD','<TABLE style="BORDER-COLLAPSE: collapse" borderColor=#31659c cellSpacing=0 cellPadding=0 align="center"   height:50px; width="100%" bgColor=#ffffff border=1>');
define('TABLE_TAIL','</TABLE>');
define('TBODY_HEAD','<TBODY id="test" >');
define('TBODY_TAIL','</TBODY>');
class ShowHtml{
	public function showTableHead()
	{
		echo TABLE_HEAD;
		echo TBODY_HEAD;
	}
	public function showTableTail()
	{
		echo TABLE_TAIL;
		echo TBODY_TAIL;
	}
	function echoStr($str)
	{
		echo $str;
	}
	function echoOneTR($style,$array,$maxtd)
	{
		echo '<TR id='.$array[0].'>';
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
		echo '<TR id='.$tdstr[$start].'>';
			
		for($i=0;$i<$length;$i++){
			$tmpstr=str_pad($tdstr[$i+$start],2,"0",STR_PAD_LEFT);
			if($i>=7)
				$css='p'.$i;
			echo '<TD class='.$css.'>'.$tmpstr.'</TD>';
		}
	
		echo '</TR>';
		}
		
	}
	function echoMultTRS($array,$start,$length)
	{
		//var_dump($array);
		$num=0;
		foreach ($array as $tdline)
		{
			$num++;
			$tdstr=array_values($tdline);
			$css='p'.($num%2);
		echo '<TR id='.$tdstr[$start].'>';
			
		for($i=0;$i<$length;$i++){
			$tmpstr=str_pad($tdstr[$i+$start],2," ",STR_PAD_LEFT);
			if($i>=7)
				$css='p'.$i;
			echo '<TD class='.$css.'>'.$tmpstr.'</TD>';
		}
	
		echo '</TR>';
		}
		
	}
	function showRLostHead($max){
		
	//	$this->showWebHead();
		echo TABLE_HEAD;
		$this->echoOneTR(CSS3,$RLostHead,$max);
	//	$this->showWebTail();
	}
	function showAllBallsHead(){
		$this->echoOneTR(CSS3,$allBallsHead,count($allBallsHead,COUNT_NORMAL));
		
	}
	
}


