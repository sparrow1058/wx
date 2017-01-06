<?php

require_once dirname (__FILE__).'/../common/Common.php';
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
function get_ssq_data($fileName)
{
	$file = file($fileName);
	try{
		$ssqDb=new SingleTableOperation("ssqdata","SSQ");
		foreach($file as &$line){
			$line=str_replace(" ","",$line);
			$ssqdata=array('num'=>substr($line,0,5),'R1'=>substr($line,5,2),'R2'=>substr($line,7,2),'R3'=>substr($line,9,2),'R4'=>substr($line,11,2),
					'R5'=>substr($line,13,2),'R6'=>substr($line,15,2),'B1'=>substr($line,17,2));

		//	$ssqDb->addObject($ssqdata);
				
		}
		$ret=$ssqDb->getObject(array('_sortExpress'=>' id desc','_limit'=>"4"));
		//$ret=$ssqDb->getInsertId();
	//	var_dump($ret);
		//$ssqDb->getAll();
	}catch (DB_Exception $e){
		interface_log(ERROR,EC_DB_OP_EXCEPTION,"query db error".$e->getMessage());
	}
}
class SSQLottery{
	private $_content;
	private $_index;
	private $_oTable;	
	private $_newestNum;
	private $_newestId;
	public function init(){
	//try query database
		try{
			$this->_oTable=new SingleTableOperation("ssqdata","SSQ");
			$ret=$this->_oTable->getObject(array('_sortExpress'=>' id desc','_limit'=>1));
			$this->_newestNum=$ret[0]['Num'];
			$this->_newestId=$ret[0]['id'];
			set_time_limit(0);
		}catch(Exception $e){
			interface_log(ERROR,EC_DB_OP_EXCEPTION,$e->getMessage());
			return $this->makeFF_HINT(FF_HINT_INNER_ERROR);
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
		$line=str_replace(" ","",$ssqline);
		$ssqArray=array('id'=>$id,'num'=>substr($line,0,5),'R1'=>substr($line,5,2),'R2'=>substr($line,7,2),'R3'=>substr($line,9,2),'R4'=>substr($line,11,2),
					'R5'=>substr($line,13,2),'R6'=>substr($line,15,2),'B1'=>substr($line,17,2));
		$sum=$ssqArray['R1']+$ssqArray['R2']+$ssqArray['R3']+$ssqArray['R4']+$ssqArray['R5']+$ssqArray['R6'];
		for($i=1;$i<7;$i++){
			$Rnum='R'.$i;
			$OEC=$OEC+$ssqArray[$Rnum]%2;
		}
		$ssqArray['Sum']=$sum;
		$ssqArray['OEC']=$OEC;
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
				$this->updateBaseData($id++,$line);	
			}
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
			echo "no need update <BR>";
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
		for($i=1;$i<$maxLost;$i++)
			$result[$i]=$ret[$maxLost-$i-1]['id']-$ret[$maxLost-$i]['id']-1;
		$result[$maxLost]=$currentLost;
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
	
	
}