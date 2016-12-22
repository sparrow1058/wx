<?php
define ("TOKEN","echo_server");

function checkSignature(){
	$signature=$_GET['signature'];
	$nonce=$_GET['nonce'];
	$timestamp=$_GET['timestamp'];
	$tmpArr=array($nonce,$timestamp,TOKEN);
	sort($tmpArr);
	$tmpArr=implode($tmpArr);
	$tmpArr=sha1($tmpArr);
	if($tmpStr==$signature){
		return true;
	}
	return false;
}
if(false==checkSignature(){
	exit(0);
}
$echostr=$_GET['echostr'];
if($echostr){
	echo $$echostr;
	exit(0);
}


?>