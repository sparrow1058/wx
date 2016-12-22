<?php
require_once dirname(__FILE__).'/DbException.php';
require_once dirname(__FILE__).'/GlobalFunctions.php';
require_once dirname(__FILE__) .'/GlobalDefine.php';
/**
 * mysql类型数据库的访问类 
 *
 * @author pacozhong 
 * @version v1.0.0 
 * @package common
 */
class MysqliDb{
	const DB_FETCH_ASSOC	= MYSQLI_ASSOC;		//use key-value to fetch
	const DB_FETCH_NUM		=MYSQLI_NUM;		// use num to fetch
	const DB_FETCH_BOTH		=MYSQLI_BOTH;		// both
	const DB_FETCH_DEFAULT	=self::DB_FETCH_ASSOC;
	
	private 	$_autoCommitTime=0;
	protected 	$_conn;
	protected	$_dbKey;
	protected	$_fetchMode;

	//Construct function  
	//param array $dbInfo  //database config
	//param string $dbKey	//db key
	//param return $fetchMode;
	public function __construct($dbKey,$fetchMode=self::DB_FETCH_ASSOC){
		$this->_dbKey=$GLOBALS['DB'][$dbKey];
		$this->_fetchMode=$fetchMode;
	}
	// Return boolean  success or fail
	public function connect(){
		$dbHost=$this->_dbKey["HOST"];
		$dbName=$this->_dbKey["DBNAME"];
		$dbUser=$this->_dbKey["USER"];
		$dbPass=$this->_dbKey["PASSWD"];
		$dbPort=(int)$this->_dbKey["PORT"];
		
		//init the datebase
		$this->_conn=mysqli_init();
		if(!$this->_conn){
			throw new DB_Exception('mysqli_init fail!');
			return false;
		}
		//Connect the datebase
		if(!mysqli_real_connect($this->_conn,$dbHost,$dbUser,$dbPass,$dbName,$dbPort,NULL,
			MYSQLI_CLIENT_FOUND_ROWS)){
				throw new DB_Exception('connect to db faile');
				return false;
			}
		$sql="SET NAMES latin1";
		$this->update($sql);
		return true;
	}
	public function close(){
		if(is_object($this->_conn)){
			mysqli_close($this->_conn);
		}
	}
	/*
	// an sql query
	//Just for SELECT SQL command
	@param string $sql  SQL Query cmd
	@param mixed $limit  int or string type
	@param boolen $quick   normal or quickly
	@return resource   return the query handle
	*/
	public function query($sql,$limit=null,$quick=false){
		interface_log(DEBUG,0,$sql);
		if($limit!=null){
			if(!preg_match('/^\s*SHOW/i',$sql)&&!preg_match('/FOR UPDATE\s*$/i',$sql)&&!preg_match('/LOCK IN SHARE MODE\s*$/i',$sql)){
					$sql=$sql."LIMIT".$limit;
				}
		}
		if(!$this->_conn||!$this->ping($this->_conn)){
			if($this->_autoCommitTime){
				throw new DB_Exception("auto commit time is not zero when reconnect to db");
			}else{
				$this->connect();
			}
		}
		$startTime=getMillisecond();
		echo $sql;
		$qrs=mysqli_query($this->_conn,$sql,$quick ? MYSQLI_USE_RESULT : MYSQLI_STORE_RESULT);
		if(!$qrs){
			throw new DB_Exception('Query fail:'.mysqli_error($this->conn));
		}else{
			interface_log(DEBUG,EC_OK,"excute time: ".getMillisecond($startTime)."(ms)SQL[$sql]");
			return $qrs;
		}
	}
	/* get the result
	@param resource $rs  query result handle
	@param const $fetchMode   return data struct
	@return array.  return every date 
	*/
	public function fetch($rs,$fetchMode=self::DB_FETCH_DEFAULT){
		$fields=mysqli_fetch_fields($rs);
		$values=mysqli_fetch_array($rs,$fetchMode);
		if($values){
			foreach ($fields as $field){
				switch ($field->type){
					case MYSQLI_TYPE_TINY:
					case MYSQLI_TYPE_SHORT:
					case MYSQLI_TYPE_INT24:
					case MYSQLI_TYPE_LONG:
						if($field->type==MYSQLI_TYPE_TINY&& $field->length==1){
							$values[$field->name]=(boolean)$values[$field->name];
						}else{
							$values[$field->name]=(int)$values[$field->name];
						}
						break;
					case MYSQLI_TYPE_DECIMAL:
					case MYSQLI_TYPE_FLOAT:
					case MYSQLI_TYPE_DOUBLE:
					case MYSQLI_TYPE_LONGLONG:
						$values[$field->name]=(float)$values[$field->name];
						break;
				}
			}
		}
		return $values;
	}
	// for  SQL update
	//@param string $sql   ----$sql  sql cmd
	//@return boolean 		
	public function update($sql){
		interface_log(INFO,EC_OK,"SQL[$sql]");
		if(!$this->_conn||!$this->ping($this->_conn)){
			if($this->_autoCommitTime){
				throw new DB_Exception('auto commit time is not zero when reconnect to db');
			}else{
				$this->connect();
			}
		}
		$startTime=getMillisecond();
		$urs=mysqli_query($this->_conn,$sql);
		if(!$urs){
			throw new DB_Exception('update fail'.mysqli_error($this->_conn));
		}else{
			interface_log(INFO,EC_OK,"excute time: ".getMillisecond($startTime)."ms SQL[$sql]");
			return $urs;
		}
	}
	
	//return SQL CMD  result  the first line fist row data
	//@param string $sql 
	//@return mixed  query result 
	public function getOne($sql){
		if(!$rs=$this->query($sql,1,true)){
			return false;
		}
		$row=$this->fetch($rs,self::DB_FETCH_NUM);
		$this->free($rs);
		return $row[0];
	}
	public function getCol($sql,$limit=null){
		if(!$rs=$this->query($sql,$limit,true)){
			return false;
		}
		$result=array();
		while(($rows=$this->fetch($rs,self::DB_FETCH_NUM))!=null){
			$result[]=$rows[0];
		}
		$this->free($rs);
		return $result;
	}
	public function getRow($sql,$fetchMode=self::DB_FETCH_DEFAULT){
		if(!$rs=$this->query($sql,1,true)){
			return false;
		}
		$row=$this->fetch($rs,$fetchMode);
		$this->free($rs);
		return $row;
	}
	public function getAll($sql,$limit=null,$fetchMode=self::DB_FETCH_DEFAULT){
		if(!$rs=$this->query($sql,$limit,true)){
			return false;
		}
		$allRows=array();
		while(($row=$this->fetch($rs,$fetchMode))!=null){
			$allRows[]=$row;
		}
		$this->free($rs);
		return $allRows;
	}
	/**/
	public function autoCommit($mode=false){
		if(!$this->_conn||!$this->ping($this->_conn)){
			if($this->_autoCommitTime){
				throw new DB_Exception('auto commit cnt is not zero when connect to db');
			}else{
				$this->connect();
			}
		}
		if($mode){
			if($this->_autoCommitTime)
			{
				throw new DB_Exception('auto commit cnt is not zeror when set autocommit  to true');
				return false;
			}else{
				$this->_autoCommitTime++;
			}
			return mysqli_autocommit($this->_conn,$mode);
		}
	}
	public function commit($mode=true){
		$result=mysqli_commit($this->_conn);
		mysqli_autocommit($this->_conn,$mode);
		return $result;
	}
	public function tryCommit($mode=true){
		$this->_autoCommitTime--;
		if($this->_autoCommitTime<=0){
			$this->_autoCommitTime=0;
			return $this->commit($mode);
		}else{
			return true;
		}
	}
	public function rollback(){
		return mysqli_rollback($this->_conn);
	}
	public function rows($rs){
		return mysqli_num_rows($rs);
	}
	public function affectedRows(){
		return mysqli_affected_rows($this->_conn);
	}
	public function lastID(){
		return mysqli_insert_id($this->_conn);
	}
	public function free($rs){
		if($rs){
			return mysqli_free_result($rs);
		}
	}
	public function ping ($conn){
		return mysqli_ping($conn);
	}
	public function escape($str){
		if(is_array($str)){
			foreach($str as $key=>$value){
				$str[$key]=$this->escape($value);
			}
		}else{
			return addslashes($str);
		}
		return $str;
	}
	public function unescape($str){
		if(is_array($str)){
			foreach ($str as $key=>$value){
				$str[$key]=$this->unescape($value);
			}
		}else{
			return stripcslashes($str);
		}
		return $str;
	}
	public function __destruct(){
	}
	public function getErrorNum(){
		return mysqli_errno($this->_conn);
	}
	public function getErrorInfo(){
		return mysqli_error($this->_conn);
	}

}
?>