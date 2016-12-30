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
	private $_newest;
	public function init(){
	//try query database
		try{
			$this->_oTable=new SingleTableOperation("ssqdata","SSQ");
			$ret=$this->_oTable->getObject(array('_sortExpress'=>' id desc','_limit'=>1));
			$this->_newest=$ret[0]['Num'];
		}catch(Exception $e){
			interface_log(ERROR,EC_DB_OP_EXCEPTION,$e->getMessage());
			return $this->makeFF_HINT(FF_HINT_INNER_ERROR);
		}
		return true;
	}
	public function getLastId($n){
		
		try{
			$ret=$this->_oTable->getObject(array('_sortExpress'=>' id desc','_limit'=>$n));
		}catch (Exception $e){
			
			interface_log(DEBUG,0,$e->getMessage());
		}
		return $ret;
	}
	public function updateBaseData($ssqline)
	{
		$line=str_replace(" ","",$ssqline);
		$ssqArray=array('num'=>substr($line,0,5),'R1'=>substr($line,5,2),'R2'=>substr($line,7,2),'R3'=>substr($line,9,2),'R4'=>substr($line,11,2),
					'R5'=>substr($line,13,2),'R6'=>substr($line,15,2),'B1'=>substr($line,17,2));
		try{
			
			$ret=$this->_oTable->addObject($ssqArray);
		}catch (Exception $e){
		
		}
	}
	public function updateBaseDataFromFile($fileName)
	{
		$file = file($fileName);
		foreach($file as &$line){

			if($this->_newest<(int)(substr($line,0,5)))
			{	
				$this->_newest=substr($line,0,5);
				$this->updateBaseData($line);	
			}
		}
	}
	public function updateLostRtable($num){
//		if($num<$this->_newest)
	//		return 0;
		$lost = array();
//		for($j=1;$j<34;$j++)
	//		echo $lost[$j];
		try{
		//	$ret=$this->_oTable->getObject(array('R1'=>1'));
		$ret=$this->_oTable->getObject(array('_sortExpress'=>' id '));
		{
			$this->_oTable->setTableName("lostRTable");
			
			//foreach ($ret[i] as list($id,$num,$r1,$r2,$r3, $r4,$r5, $r6))
				//echo $id.$num.$r1.$r2.$r3.$r4.$r5.$r6;
			for ($i=0;$i<3;$i++)
			{
			//	echo $ret[$i]['R1']."  ".$ret[$i]['R2']."  ".$ret[$i]['R3']."  ".$ret[$i]['R4']."  ".$ret[$i]['R5']."  ".$ret[$i]['R6']." <BR>";
				for($j=1;$j<34;$j++){
					if($j==$ret[$i]['R1']||$j==$ret[$i]['R2']||$j==$ret[$i]['R3']||$j==$ret[$i]['R4']||$j==$ret[$i]['R5']||$j==$ret[$i]['R6'])
					{
						$lost[$j]=0;
					}
					else
						$lost[$j]++;
				}

				echo "<BR>";
				for($j=1;$j<34;$j++)
				{	
					echo $lost[$j]."  ";
					
				}
				echo "<BR>";
				$lostR=array("Num"=>$ret[$i]['Num'],"RL1"=>$lost[1],"RL2"=>$lost[2],"RL3"=>$lost[3],"RL4"=>$lost[4],"RL5"=>$lost[5],
													"RL6"=>$lost[6],"RL7"=>$lost[7],"RL8"=>$lost[8],"RL9"=>$lost[9],"RL10"=>$lost[10],
													"RL11"=>$lost[11],"RL12"=>$lost[12],"RL13"=>$lost[13],"RL14"=>$lost[14],"RL15"=>$lost[15],
													"RL16"=>$lost[16],"RL17"=>$lost[17],"RL18"=>$lost[18],"RL19"=>$lost[19],"RL20"=>$lost[20],
													"RL21"=>$lost[21],"RL22"=>$lost[22],"RL23"=>$lost[23],"RL24"=>$lost[24],"RL25"=>$lost[25],
													"RL26"=>$lost[26],"RL27"=>$lost[27],"RL28"=>$lost[28],"RL29"=>$lost[29],"RL30"=>$lost[30],
													"RL31"=>$lost[31],"RL32"=>$lost[32],"RL33"=>$lost[33]
							);
				$this->_oTable->addObject($lostR);
				//var_dump($lost);
			}
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
	
	
	
	
}