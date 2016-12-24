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
function getMillisecond() {
	list($t1, $t2) = explode(' ', microtime());
	return (float)sprintf('%.0f',(floatval($t1)+floatval($t2))*1000);
}
function doCurlGetRequest($url,$data,$timeout=5){
	if($url=="" || $timeout<=0){
		return false;
	}
	$url=$url.'?'.http_build_query($data);
	$con=curl_init((string)$url);
	curl_setopt($con,CURLOPT_HEADER,false);
	curl_setopt($con,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($con,CURLOPT_TIMEOUT,(int)$timeout);
	return curl_exec($con);
}
function doCurlPostRequest($url,$requestString,$timeout=5){
	if($url==""||$requestString==""||$timeout<=0){
		return false;
	}
	$con=curl_init((string)$url);
	curl_setopt($con,CURLOPT_HEADER,false);
	curl_setopt($con,CURLOPT_POSTFIELDS,$requestString);
	curl_setopt($con,CURLOPT_POST,true);
	curl_setopt($con,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($con,CURLOPT_TIMEOUT,(int)$timeout);
	return curl_exec($con);
}



?>