<?php
define ("TOKEN","haidiyuntest");
define ("APPID","wx9dc85eb8cd0752fc");
define ("APPSECRET","7b09b4e138cb37a1b1b4a1413451a72d");		//haidiyun520 ,Zediel168168...
$menuObj=new myMenu();
$access_token=$menuObj->getAccessToken(APPID,APPSECRET);
$menuObj->createMenu();

class myMenu{
	//public $appid="wx7a6961ece3321fb8";
	//public $appsecret="11267260f1c632023db7ccf281f50a8a";
	public $tokenUrl="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential";
	//"&appid=".$appid."&secret=".$appsecret;
	public $access_token="";
	public $setMenuUrl="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=";
	public $getMenuUrl="https://api.weixin.qq.com/cgi-bin/menu/get?access_token=";
	public function getAccessToken($appid,$appsecret)
	{
		$ch=curl_init();
		//$tokenUrl=$tokenUrl.$appid."&secret=".$appsecret;
		$pathUrl=$this->tokenUrl."&appid=".$appid."&secret=".$appsecret;
		curl_setopt($ch,CURLOPT_URL,$pathUrl);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		$output=curl_exec($ch);
		curl_close($ch);
		$json_info=json_decode($output,true);
		$result=$json_info["access_token"];
		$this->access_token=$result;
		return $result;
	}
	public  function createMenu()
	{
		$jsonmenu='{
		"button": [
		{
			"type": "click",
			"name": "客户展示",
			"sub_button": [
				{
					"type": "click",
					"name": "大目牛肉",
					"key": "BUTTON_1_1"
				},
				{
					"type": "click",
					"name": "苏堂晓月",
					"key": "BUTTON_1_2"
				},
				{
					"type": "view",
					"name": "御前寿司",
					"url": "http://www.haidiyun.top/yuqian.html"
				}
			]
		},
		{
			"type": "click",
			"name": "产品介绍",
			"sub_button": [
				{
					"type": "click",
					"name": "智能手表",
					"key": "BUTTON_2_1"
				},
				{
					"type": "click",
					"name": "点餐平板",
					"key": "BUTTON_2_2"
				},
				{
					"type": "click",
					"name": "一体POS",
					 "key": "BUTTON_2_3"
				}
			]
		},
		{
			"type": "click",
			"name": "关于我们",
			"sub_button": [
				{
					"type": "view",
					"name": "回顾过去",
					"url": "http://www.haidiyun.top/info/yestoday.html"
				},
				{
					"type": "view",
					"name": "立足今日",
					"url": "http://www.haidiyun.top/info/today.html"
				},
				{
					"type": "view",
					"name": "展望未来",
					"url": "http://www.haidiyun.top/info/tomorrow.html"                }
			]
		}
		]
		}';		//jsonmenu struct
		$url=$this->setMenuUrl.$this->access_token;
		$result=$this->httpsRequest($url,$jsonmenu);
		var_dump($result);
	}
	private function httpsRequest($url,$data=null)
	{
		$curl=curl_init();
		curl_setopt($curl,CURLOPT_URL,$url);
		curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,FALSE);
		curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,FALSE);
		if(!empty($data)){
			curl_setopt($curl,CURLOPT_POST,1);
			curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
		}
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
		$output=curl_exec($curl);
		curl_close($curl);
		return $output;
	}

}
?>