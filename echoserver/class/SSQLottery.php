<?php

require_once dirname (__FILE__).'/../common/Common.php';
define ('SSQ_DATA',dirname (__FILE__)."/../image/Data.txt");
$ip=gethostbyname($_ENV['COMPUTERNAME']);
if($ip=="192.168.1.146")
	define("SSQDATA","SSQLOCAL");
else
	define("SSQDATA","SSQREMOTE");

$ssqdata=array(
	'num'=>001,
	'R1'=>1,
	'R2'=>2,
	'R3'=>3,
	'R4'=>1,
	'R5'=>2,
	'R6'=>3,
	'B1'=>7
	);
class SSQLottery{
	private $_content;
	private $_index;
	private $_oTable;	
	private $_newestNum;
	private $_newestId;
	public function init(){
	//try query database
		try{
			$this->_oTable=new SingleTableOperation("ssqdata",SSQDATA);
			$ret=$this->_oTable->getObject(array('_sortExpress'=>' id desc','_limit'=>1));
			$this->_newestNum=$ret[0]['Num'];
			$this->_newestId=$ret[0]['id'];
			set_time_limit(0);
		}catch(Exception $e){
			//interface_log(ERROR,EC_DB_OP_EXCEPTION,$e->getMessage());
			echo "database can't connected";
			//return $this->makeFF_HINT(FF_HINT_INNER_ERROR);
		}
		return true;
	}
	public function getLastNum($n){
		
		try{
			$ret=$this->_oTable->getObject(array('_sortExpress'=>' id desc','_limit'=>$n));
		}catch (Exception $e){
			
			interface_log(DEBUG,0,$e->getMessage());
		}
		return $ret;
	}
	public function updateBaseData($id,$ssqline)
	{
		$OEC=0;
		$Rang7=array (0,0,0,0,0,0,0);
		$line=str_replace(" ","",$ssqline);
		$ssqArray=array('id'=>$id,'num'=>substr($line,0,5),'R1'=>substr($line,5,2),'R2'=>substr($line,7,2),'R3'=>substr($line,9,2),'R4'=>substr($line,11,2),
					'R5'=>substr($line,13,2),'R6'=>substr($line,15,2),'B1'=>substr($line,17,2));
		$sum=$ssqArray['R1']+$ssqArray['R2']+$ssqArray['R3']+$ssqArray['R4']+$ssqArray['R5']+$ssqArray['R6'];
		for($i=1;$i<7;$i++){
			$Rnum='R'.$i;
			$OEC=$OEC+$ssqArray[$Rnum]%2;
			$rIndex=floor(($ssqArray[$Rnum]-1)/5);
			$Rang7[$rIndex]=$Rang7[$rIndex]+1;
		}
		for($i=0;$i<7;$i++)
			$rangeStr=$rangeStr." ".$Rang7[$i];
		$ssqArray['Sum']=$sum;
		$ssqArray['OEC']=$OEC;
		$ssqArray['RANGE']=$rangeStr;
		
		
		
		
		try{
			
			$ret=$this->_oTable->addObject($ssqArray);
		}catch (Exception $e){
		
		}
	}
	public function updateBaseDataFromFile($fileName)
	{
		$file = file($fileName);
		$id=$this->_newestId+1;
		foreach($file as &$line){

			if($this->_newestNum<(int)(substr($line,0,5)))
			{	
				$this->_newestNum=substr($line,0,5);
				$this->_newestId=$id;
				$this->updateBaseData($id++,$line);	
			}
		}
		
	}
	public function updateBBData($bbArray)
	{

		try{			
			$ret=$this->_oTable->addObject($bbArray);
		}catch (Exception $e){
		
		}
	}
	public function updateBTable()
	{
		try{
			$this->_oTable->setTableName("ssqbtable");
			$bNums=$this->getLastNum(1);
			
			$this->_oTable->setTableName("ssqdata");
			$dataNums=$this->getLastNum(1);
			//var_dump($lostNums);
			//var_dump($dataNums);
			if(!($bNums[0]['Num']<$dataNums[0]['Num'])){
				echo "no need update BlueBalls <BR>";
				return 0;
			}else{
				$gap=$dataNums[0]['id']-$bNums[0]['id'];
				$id=$bNums[0]['id'];
				//echo "****gap **id********".$gap." -- ".$id."<BR>";
			}
			$ret=$this->_oTable->getObject(array('id'=>$bNums[0]['id'],'_logic'=>">"));
			$this->_oTable->setTableName("ssqbtable");
			for($i=0;$i<$gap;$i++)
			{
				//$lostB[$i+$id+1]['id
			//	$lostB[$i]['BB']=$ret[$i]['B1'];
					
				$range=	($ret[$i]['B1'])%4;
				if($i<1)
				{
					$diff=$ret[$i]['B1']-$bNums[0]['BB'];
				}else{
					$diff=$ret[$i]['B1']-$ret[$i-1]['B1'];
				}
				$blueStr=array('id'=>$id+$i+1,'Num'=>$ret[$i]['Num'],'BB'=>$ret[$i]['B1'],
								'RANGE'=>$range,'DIFF'=>$diff);
								
			//	var_dump($blueStr);
				
				$this->_oTable->addObject($blueStr);		
			}
		}catch (Exception $e){
			
		}
		
	}
	public function updateLostRtable(){
//		if($num<$this->_newest)
	//		return 0;
		$lost = array();
	//	$shtml=new ShowHtml();
//		for($j=1;$j<34;$j++)
	//		echo $lost[$j];
		try{
		//	$ret=$this->_oTable->getObject(array('R1'=>1'));
		$this->_oTable->setTableName("lostRTable");
		$lostNums=$this->getLastNum(1);
		
		$this->_oTable->setTableName("ssqdata");
		$dataNums=$this->getLastNum(1);
		//var_dump($lostNums);
		//var_dump($dataNums);
		if(!($lostNums[0]['Num']<$dataNums[0]['Num'])){
			echo "no need update  Rlost <BR>";
			return 0;
		}else{
			$gap=$dataNums[0]['id']-$lostNums[0]['id'];
			$id=$lostNums[0]['id'];
			
		//	echo "****gap **id********".$gap."  ".$id."<BR>";
			
		}
		//$ret=$this->_oTable->getObject(array('_sortExpress'=>' id '));
		
		
		//$ret=$this->_oTable->getObject(array('id'=>$lostNums[0]['id'],'_sortExpress'=>' id desc','_logic'=>">"));
		$ret=$this->_oTable->getObject(array('id'=>$lostNums[0]['id'],'_logic'=>">"));
		$this->_oTable->setTableName("lostRTable");

		//foreach ($ret[i] as list($id,$num,$r1,$r2,$r3, $r4,$r5, $r6))
			//echo $id.$num.$r1.$r2.$r3.$r4.$r5.$r6;
		for ($i=0;$i<$gap;$i++)
		{
		//	echo $ret[$i]['R1']."  ".$ret[$i]['R2']."  ".$ret[$i]['R3']."  ".$ret[$i]['R4']."  ".$ret[$i]['R5']."  ".$ret[$i]['R6']." <BR>";
			$curLost="";
			for($j=1;$j<34;$j++){
				if($j==$ret[$i]['R1']||$j==$ret[$i]['R2']||$j==$ret[$i]['R3']||$j==$ret[$i]['R4']||$j==$ret[$i]['R5']||$j==$ret[$i]['R6'])
				{
					if($i==0){
						$RLStr='RL'.$j;
						$lost[$j]=$lostNums[0][$RLStr];
					}
					$curLost= $curLost.' '.str_pad($lost[$j],2,'0',STR_PAD_LEFT);
					$lost[$j]=0;
					
				}else{
					if($i==0){
						$RLStr='RL'.$j;
						$lost[$j]=$lostNums[0][$RLStr]+1;
						
					}else{
						$lost[$j]++;
					}
				}
			}
			//$shtml->showProcessBar($i/$gap);
			
			$lostR=array('id'=>$id+$i+1,"Num"=>$ret[$i]['Num'],
						"RL1"=>$lost[1],"RL2"=>$lost[2],"RL3"=>$lost[3],"RL4"=>$lost[4],"RL5"=>$lost[5],
						"RL6"=>$lost[6],"RL7"=>$lost[7],"RL8"=>$lost[8],"RL9"=>$lost[9],"RL10"=>$lost[10],
						"RL11"=>$lost[11],"RL12"=>$lost[12],"RL13"=>$lost[13],"RL14"=>$lost[14],"RL15"=>$lost[15],
						"RL16"=>$lost[16],"RL17"=>$lost[17],"RL18"=>$lost[18],"RL19"=>$lost[19],"RL20"=>$lost[20],
						"RL21"=>$lost[21],"RL22"=>$lost[22],"RL23"=>$lost[23],"RL24"=>$lost[24],"RL25"=>$lost[25],
						"RL26"=>$lost[26],"RL27"=>$lost[27],"RL28"=>$lost[28],"RL29"=>$lost[29],"RL30"=>$lost[30],
						"RL31"=>$lost[31],"RL32"=>$lost[32],"RL33"=>$lost[33],"CURLOST"=>$curLost
						);
			$this->_oTable->addObject($lostR);
			//var_dump($lost);
		}
		
		
			
		//$ret=$this->_oTable->executeSql("SELECT * FROM ssqdata where R1={$num} OR R2={$num} OR  R3={$num} OR R4={$num} OR R5={$num} OR R6={$num} ORDER BY id");
		//var_dump($ret);
			
			//$ret=$this->_oTable->executeSql("SELECT * FROM ssqdata WHERE 1 AND `Num` > {$num} ORDER BY id desc limit 10");
			//echo count($ret,COUNT_NORMAL);
			//var_dump($ret);
			//$ret=$this->_oTable->getObject(array('Num'=>$num,'_sortExpress'=>' id desc','_limit'=>$n,'_logic'=>">"));
		
		}catch (Exception $e){
			
		}
		
	}
	public function getRLost($num,$max){
		$field='RL'.$num;
		$result[0]=$num;
		$this->_oTable->setTableName("lostRTable");	
		$ret=$this->_oTable->getObject(array('_limit'=>$max,'_sortExpress'=>' id desc'));
		$currentLost=$ret[0][$field];
		
		$ret=$this->_oTable->getObject(array($field=>0,'_limit'=>$max,'_sortExpress'=>' id desc'));
		$maxLost=count($ret,COUNT_NORMAL);
		//var_dump($ret);
		for($i=1;$i<$maxLost;$i++){
			
			$result[$i]=$ret[$maxLost-$i-1]['id']-$ret[$maxLost-$i]['id']-1;
			$result[$i]=str_pad($result[$i],2,'0',STR_PAD_LEFT);
		}
		$result[$maxLost]=str_pad($currentLost,2,'0',STR_PAD_LEFT);
		return $result;
	}
	public function getAllBalls($max){
		$this->_oTable->setTableName("ssqdata");	
		$ret=$this->_oTable->getObject(array('_limit'=>$max,'_sortExpress'=>' id desc'));
		
		$preNum=$ret[1]['Num'];
		$this->_oTable->setTableName("lostRTable");	//get the lost 
		$lost=$this->_oTable->getObject(array('_limit'=>$max,'_sortExpress'=>' id desc'));
		for($i=0;$i<$max;$i++)
		{
			$ret[$i]['lost']=$lost[$i]['CURLOST'];
		}
		return $ret;		
	}
	public function getRange($max){
		$this->_oTable->setTableName("lostRTable");	//get the lost 
		$lost=$this->_oTable->getObject(array('_limit'=>$max,'_sortExpress'=>' id desc'));
		$this->_oTable->setTableName("ssqdata");	//get the lost 
		$range=$this->_oTable->getObject(array('_limit'=>$max,'_sortExpress'=>' id desc'));
		
		for($i=0;$i<$max;$i++)
		{
			$result[$i]['Num']=$range[$i]['Num'];
			$result[$i]['range']=$range[$i]['RANGE'];
			$result[$i]['lost']=$lost[$i]['CURLOST'];
		}
		//var_dump($result);
		return $result;		
	}
	public function getBballs($max){
		$this->_oTable->setTableName("ssqbtable");	//get the lost 
		$ret=$this->_oTable->getObject(array('_limit'=>$max,'_sortExpress'=>' id desc'));
		for($i=0;$i<$max;$i++)
		{
			$result[$i]['Num']=$ret[$i]['Num'];
			$result[$i]['BB']=$ret[$i]['BB'];
			$result[$i]['DIFF']=$ret[$i]['DIFF'];
			$result[$i]['RA0']="";
			$result[$i]['RA1']="";
			$result[$i]['RA2']="";
			$result[$i]['RA3']="";
			$RAN='RA'.$ret[$i]['RANGE'];
			$result[$i][$RAN]="★";
		}
		//var_dump($result);
		return $result;
	}			
	
	
	public function getRballs($num){
		$this->_oTable->setTableName("ssqdata");	
		$ret=$this->_oTable->getObject(array('num'=>$num,'_sortExpress'=>' id desc'));
		return $ret;
	}
	function getBalls($nums)
	{
		$this->_oTable->setTableName("ssqdata");	
		$ret=$this->_oTable->getObject(array('_limit'=>$nums,'_sortExpress'=>' id desc'));
		//var_dump($ret);
		return $ret;
	}
	function addOneNums($numstr)
	{
		$numstr=str_replace(" ","",$numstr);
		$newNum=(int)(substr($numstr,0,5));
		//echo "leaf ".$numstr."  ".strlen($numstr)." 1 ".$this->_newestNum." 2 ".$newNum;
		if($this->_newestNum<$newNum)
		{
	
			$this->_newestNum=$newNum;
			$this->updateBaseData(++$this->_newestId,$numstr);
			$this->updateLostRtable();
			$this->updateBTable();
			
		}
			
	}
	function delNewData()
	{
		$this->_oTable->setTableName("ssqdata");
		$this->_oTable->delObject(array('Num'=>$this->_newestNum));
		$this->_oTable->setTableName("lostRTable");
		$this->_oTable->delObject(array('Num'=>$this->_newestNum));
		$this->_newestNum--;
		$this->_newestId--;
		return 1;
	}
}






















