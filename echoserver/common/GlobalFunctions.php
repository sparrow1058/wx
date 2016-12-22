<?php
include_once dirname(__FILE__).'/GlobalDefine.php';
include_once dirname(__FILE__).'/MiniLog.php';
define("DEBUG","DEBUG");
define("INFO","INFO");
define("ERROR","ERROR");
function isLogLevelOff($logLevel)
{
	$swithFile=ROOT_PATH.'/log/'.'NO_'.$logLevel;
	if(file_exists($swithFile)){
		return true;
	}else{
		return false;
	}
}
//log function 
function wxmp_log($confName,$logLevel,$errorCode,$logMessage="no error msg")
{
	if(isLogLevelOff($logLevel)){
		return ;
	}
	$st=debug_backtrace();
	$function='';
	$file='';
	$line='';
	foreach($st as $item){
		if($file){
			$function=$item['function'];
			break;
		}
		if($item['function']=='interface_log'){
			$file=$item['file'];
			$line=$item['line'];
		}
	}
	$function=$function ? $function : 'main';
	$file=explode("/",rtrim($file,'/'));
	$file=$file[count($file)-1];
	$prefix="[$file][$function][$line][$logLevel][$errorCode]";
	if($logLevel==INFO||$logLevel==STAT){
		$prefix="[$logLevel]";
	}
	$logFileName=$confName."_".strtolower($logLevel);
	MiniLog::instance(ROOT_PATH."/log/")->log($logFileName,$prefix.$logMessage);
	if(isLogLevelOff("DEBUG")||$logLevel=="DEBUG"){
		return ;
	}else{
		MiniLog::instance(ROOT_PATH."/log/")->log($confName."_"."debug",$prefix.$logMessage);
	}
}
function interface_log($logLevel,$errorCode,$logMessage="no error msg")
{
	wxmp_log('interface',$logLevel,$errorCode,$logMessage);
}
function getIp()
{
	if (isset($_SERVER)){
		if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
			$realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		} else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
			$realip = $_SERVER["HTTP_CLIENT_IP"];
		} else {
			$realip = $_SERVER["REMOTE_ADDR"];
		}
	} else {
		if (getenv("HTTP_X_FORWARDED_FOR")){
			$realip = getenv("HTTP_X_FORWARDED_FOR");
		} else if (getenv("HTTP_CLIENT_IP")) {
			$realip = getenv("HTTP_CLIENT_IP");
		} else {
			$realip = getenv("REMOTE_ADDR");
		}
	}
	return $realip;
}	





?>