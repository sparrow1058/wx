<?php
include_once dirname(__FILE__).'/DbFactory.php';
/**
	@desc:封装了对表单的增，删，改，查，取列等操作
*/
class STO{
	private $_tableName;
	private $_db;
	function __construct($tableName='',$dbKey='DB'){
		$this->_tableName=$tableName;
		$this->_db=DbFactory::getInstance($dbKey);
	}
	function setTableName($tableName){
		$this->_tableName=$tableName;
	}
	function getObject(array $args=array(),$or=0){
		$fetch=$args['_fetch'];
		$fetch||$fetch='getAll';
		
		$field=$args['_field'];
		$field||$field="*";
		
		$tableName=$this->getTableName($args);
		if($or){
			$where=$args['_where'] ? $args['_where'] : '0';
		}else{
			$where=$args['_where'] ? $args['_where'] : '1';
		}
		$sql="SELECT $field FROM {$tableName} WHERE {$where}";
		$args=$this->_db->escape($args);
		foreach ($args as $key=>$value){
			if($key[0]=='_'){ continue;}
			if(is_array($value)){
				if($or){
					$sql .="OR `{$key}` IN ('".implode("','",$value)."')";
				}else{
					$sql .="AND `{$key}` IN ('".implode("','",$value)."')";
				}
			}else {
				if($or){
				//	$sql .="OR `{$key}`=`{$value}`";
					$sql.="OR `{$key}` ='{$value}' ";
				}else {
					$sql .= "AND `{$key}` = '{$value}'";
				}
			}
		}
		//sort 
		if($args['_sortExpress']){
			$sql .= "ORDER BY {$args['_sortExpress']} ";
			$sql .= $args['_sortDirection']. ' ';
		}
		$args['_lockRow'] && $sql .= "FOR UPDATE";
		return $this->_db->$fetch($sql,$args['_limit']);
	}
	function getAll(array $args=array()){
		return $this->getObject($args);
	}
	function getCount(array $args= array()){
		$args['_field']='COUNT(*)';
		return $this->getOneField($args);
	}
	//insert one line
	function addObject(array $args){
		return $this->_addObject($args,'add');
	}
	private function _addObject(array $args,$type = 'add'){
		$sql=($type=='add' ? 'INSERT INTO ' : 'REPLACE INTO ');
		$tableName=$this->getTableName($args);
		$args=$this->_db->escape($args);
		
		$sql .= "{$tableName} SET " . $this->genBackSql($args,', ');
		echo $sql . '<BR>';
		return $this->_db->update($sql);
	}
	function addObjects(array $cols,array $args){
		return $this->_addObjects($cols,$args,'add');
	}
	private function _addObjects(array $cols,array $args,$type='add'){
		$sql=($type=='add' ? 'INSERT' : 'REPLACE');
		$tableName=$this->getTableName($args);
		$args=$this->_db->escape($args);
		$sql .="`{$tableName}`(`".join("`,`",$cols)."`) VALUES";
		foreach($args as $value){
			$sql .= "('".join("', '",$value) . "'),";
		}
		$sql= substr($sql,0,-1);
		return $this->_db->update($sql);
	}
	function getInsertId(){
		return $this->_db->lastID();
	}
	function updateObject(array $args,array $where){
		$args=$this->_db->escape($args);
		$where=$this->_db->escape($where);
		$tableName=$this->getTableName($args);
		
		$sql="UPDATE `{$tableName}` SET" . $this->genBackSql($args,', '). ' WHERE 1 '. $this->genFrontSql($where,'AND ');
		return $this->_db->udpate($sql);
	}
	function delObject(array $where){
		$where =$this->_db->escape($where);
		$tableName=$this->getTableName($where);
		$sql= "DELETE FROM `{$tableName}` WHERE 1 " . $this->genFrontSql($where, 'AND ');
		return $this->_db->update($sql);
	}
	// 把key=>Value 的数组转化成后置连接字符串
	function genBackSql(array $args,$connect=', '){
		$str='';
		foreach($args as $key=>$value){
			if($key[0]=='_'){
				continue;
			}
			if(is_array($value)){
				$str .="`$key` IN('" . join("','",$value) . "') " .$connect;
			}else{
				$str .= "`$key` = '$value'" . $connect;
			}
		}
		return substr($str,0,-strlen($connect));
	}
	function genFrontSql(array $args,$connect= 'AND'){
		$str ='';
		foreach ( $args as $key =>$value){
			if ($key[0]=='_'){
				continue;
			}
			if(is_array($value)){
				$str .="$connect `$key` IN ('" .join("','",$value) . "')";
			}else {
				$str .="$connect `$key` = `$value` ";
			}
		}
		return $str;
	}
	private function getTableName(&$args){
		if(isset($args['_tableName'])){
			$tableName=$args['_tableName'];
		}else{
			$tableName=$this->_tableName;
		}
		return $tableName;
	}
	function affectedRowsCnt(){
		return $this->_db->affectedRows();
	}
	function getErrorNum(){
		return $this->_db->getErrorNum();
	}
	function getErrorInfo(){
		return $this->_db->getErrorInfo();
	}
}
	
?>