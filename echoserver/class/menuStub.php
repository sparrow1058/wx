<?php
require_once dirname(__FILE__).'/../common/Common.php';
require_once dirname(__FILE__).'/tokenStub.php';
function wphp_urlencode($data){
	if(is_array($data)||is_object($data)){
		foreach($data as $k=>$v){
			if(is_scalar($v)){
				if(is_array($data)){
					$data[$k]=urlencode($v);
				}else if(is_object($data)){
					$data->$k=urldecode($v);
				}
			}else if (is_array($data)){
				$data[$k]=wphp_urlencode($v);
			}else if (is_object($data)){
				$data->$k=wphp_urlencode($v);
			}
		}
	}
	return $data;
}
function ch_json_encode($data){
	$ret=wphp_urlencode($data);
	$ret=json_encode($data);
	return urldecode($ret);
}
class menuStub{
	public static function reqMenu($account,$interface,$data){
		$token=tokenStub::getToken($account);
		echo "\n leaf ".$token."\n";
		$retry=3;
		while($retry){
			$retry--;
			if(false ===$token){
				interface_log(DEBUG,EC_OTHER,"get token error");
				return false;
			}
			$url=WX_API_URL."$interface?access_token=".$token;
			interface_log(DEBUG,0,"req url:".$url."req data:".ch_json_encode($data));
			$ret=doCurlPostRequest($url,ch_json_encode($data));
			interface_log(DEBUG,0,"response:".$ret);
			
			$retData=json_decode($ret,true);
			if(!$retData||$retData['errcode']){
				interface_log(DEBUG,EC_OTHER,"req create menu error");
			if($retData['errcode']==40014){
				$token=tokenStub::getToken($account,true);
				}
			}else {
				return $retData;
			}
		}
		return false;
	}
	public static function create($account,$data){
		$ret=menuStub::reqMenu($account,"menu/create",$data);
		if(false===$ret){
			return false;
		}
		return true;
	}
	public static function get($account){
		$ret=menuStub::reqMenu($account,"menu/get",array());
		if(false===$ret){
			return false;
		}
		return $ret;
	}
	public static function delete($account){
		$ret=menuStub::reqMenu($account,"menu/delete",array());
		if(false===$ret){
			return false;
		}
		return true;
	}
}
			
				


?>