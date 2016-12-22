<?php
/*** echo server**/
require_once "./menu.php";
//define ("TOKEN","luoyefeihua");
//define ("APPID","wx7a6961ece3321fb8");
//define ("APPSECRET","11267260f1c632023db7ccf281f50a8a");		luoyefeihua
define ("TOKEN","haidiyuntest");
define ("APPID","wx9dc85eb8cd0752fc");
define ("APPSECRET","7b09b4e138cb37a1b1b4a1413451a72d");		//haidiyun520 ,Zediel168168...


//Get the param
$wecharObj=new wechatCallbackapiTest();


if(isset($_GET['echostr'])){
	$wecharObj->valid();
}else
{
	$wecharObj->responseMsg();
}
class wechatCallbackapiTest
{
	public function valid()
	{
		$echostr=$_GET["echostr"];
		if($this->checkSignature()){
			echo $echostr;
			exit;
		}
	}
	public function checkSignature()
	{
		$signature=$_GET["signature"];
		$timestamp=$_GET["timestamp"];
		$nonce=$_GET["nonce"];

		$token=TOKEN;
		$tmpArr=array($token,$timestamp,$nonce);
		sort($tmpArr);
		$tmpStr=implode($tmpArr);
		$tmpStr=sha1($tmpStr);

		if($tmpStr==$signature){
			return true;
		}else
		{
			return false;
		}
	}
	public function responseMsg()
	{
		//$posStr=$GLOBALS["HTTP_RAW_POST_DATA"];
		$postStr = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : file_get_contents("php://input");
		if(!empty($postStr)){
		//	$posObj=simplexml_load_string($postStr,'SimpleXMLElement',LIBXML_NOCDATA);
			$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
			$RX_TYPE=trim($postObj->MsgType);
			switch ($RX_TYPE)
			{
				case "event":
					$result=$this->receiveEvent($postObj);
					break;
				case "text":
					$result=$this->receiveText($postObj);
					break;
				case "image":
					$result=$this->receiveImage($postObj);
					break;
				case "voice":
					$result=$this->receiveVoice($postObj);
					break;
				case "location":
					$result=$this->receiveLocation($postObj);
					break;
				case "link":
					$result=$this->receiveLink($postObj);
					break;
				default:
					$result="unknow msg type: ".$RX_TYPE;
					break;
			}
			echo $result;
		}
		else{
			echo "";
			exit;
		}
	}
	private function receiveEvent($object)
	{
		$content="";
		switch($object->Event)
		{
			case "subscribe":
				$content="wellcome";
				break;
			case "unsubscribe":
				$content="bye";
				break;
		}
		$result=$this->transmitText($object,$content);
		return $result;
	}

	private function receiveText($object)
	{
		$keyword=trim($object->Content);
		if($keyword=="text")
		{
			$content="this is a text message";
			$result=$this->transmitText($object,$content);
		}
		else if($keyword=="pp1"||$keyword=="pp2")
		{
			$content[]=array("Title"=>"图文标题","Description"=>"","PicUrl"=>"./image/Product_19.gif","Url"=>"http://m.cnblogs.com/?u=txw1958");
		//	$content[]=array("Title"=>"多图文1Title","Description"=>"","PicUrl"=>"./image/Product_19.gif","Url"=>"http://m.cnblogs/?u=txw1958");
			$result=$this->transmitNews($object,$content);
		}
		else if($keyword=="pp3")
		{
			$content=array();
			$content[]=array("Title"=>"多图文1Title","Description"=>"",
			"PicUrl"=>"./image/Product_19.gif","Url"=>"http://m.cnblogs/?u=txw1958");
			$content[]=array("Title"=>"多图文2","Description"=>"",
			"PicUrl"=>"./image/Product_20.gif","Url"=>"http://m.cnblogs/?u=txw1958");
			$content[]=array("Title"=>"多图文3","Description"=>"",
			"PicUrl"=>"./image/Product_21.gif","Url"=>"http://m.cnblogs/?u=txw1958");
			$result=$this->transmitNews($object,$content);
		}else if($keyword=="music")
		{
			$content=array("Title"=>"little apple",
				"Description"=>"aaaa",
				"MusicUrl"=>"http://121.199.4.61/music/zxmzf.mp3",
				"HQMusicUrl"=>"http://121.199.4.61/music/zxmzf.mp3");
				$result=$this->transmitMusic($object,$content);
		}else
			$result=$keyword;
		return $result;
	}
	private function receiveImage($object)
	{
		$content=array("MediaId"=>$object->MediaId);
		$result=$this->transmitImage($object,$content);
		return $result;
	}
	private function receiveVoice($object)
	{
		$content=array("MediaId"=>$object->MediaId);
		$result=$this->transmitVoice($object,$content);
		return $result;
	}
	private function receiveVideo($object)
	{
		$content=array("MediaId"=>$object->MediaId,"ThumbMediaId"=>$object->ThumbMediaId,
		"Title"=>"","Description"=>"");
		$result=$this->transmitVideo($object,$content);
		return $result;
	}
	private function receiveLocation($object)
	{
		$content="your location\n"."posX:".$object->Location_X."\nposY:".$object->Location_Y."\n Scal:"
			.$object->Scale."Location:".$object->Label;
		$result=$this->transmitText($object,$content);
		return $result;
	}
	private function receiveLink($object)
	{
		$content="You Link \n Title:".$object->Title."\nContent:".$object->Description."\nUrl:".$object->Url;
		$result=$this->transmitText($object,$content);
		return $result;
	}
	private function transmitText($object,$content)
	{
		$textTpl="<xml>
		<ToUserName><![CDATA[%s]]></ToUserName>
		<FromUserName><![CDATA[%s]]></FromUserName>
		<CreateTime>%s</CreateTime>
		<MsgType><![CDATA[%s]]></MsgType>
		<Content><![CDATA[%s]]></Content>
		</xml>";
		$result=sprintf($textTpl,$object->FromUserName,$object->ToUserName,time(),$object->MsgType,$content);
		return $result;
	}
	private function transmitImage($object,$imageArray)
	{
		$itemTpl="<Image><MediaId><![CDATA[%s]]></MediaId></Image>";
		$item_str=sprintf($itemTpl,$imageArray['MediaId']);
		$textTpl="<xml>
		<ToUserName><![CDATA[%s]]></ToUserName>
		<FromUserName><![CDATA[%s]]></FromUserName>
		<CreateTime>%s</CreateTime>
		<MsgType><![CDATA[image]]</MsgType>
		$item_str
		</xml>";
		$result=sprintf($textTpl,$object->FromUserName,$object->ToUserName,time());
		return $result;
	}
	private function transmitVoice($object,$voiceArray)
	{
		$itemTpl="<Voice>
		<MediaId><![CDATA[%s]]></MediaId>
		</Voice>";
		$item_str=sprintf($itemTpl,$voiceArray['MediaId']);
		$textTpl="<xml>
		<ToUserName><![CDATA[%s]]></ToUserName>
		<FromUserName><![CDATA[%s]]></FromUserName>
		<CreateTime>%s</CreateTime>
		<MsgType><![CDATA[voice]]></MsgType>
		$item_str
		</xml>";
		$result=sprintf($textTpl,$object->FromUserName,$object->ToUserName,time());
		return $result;
	}
	private function transmitVideo($object,$videoArray)
	{
		$itemTpl="<Video>
		<MediaId><![CDATA[%s]]></MediaId>
		<ThumbMediaId><![CDATA[%s]]></ThumbMediaId>
		<Title><![CDATA[%s]]></Title>
		<Description><![CDATA[%s]]></Description>
		</Video>";
		$item_str=sprintf($itemTpl,$videoArray['MediaId'],$videoArray['ThumbMediaId'],
			$videoArray['Title'],$videoArray['Description']);
		$textTpl="<xml>
		<ToUserName><![CDATA[%s]]></ToUserName>
		<FromUserName><![CDATA[%s]]></FromUserName>
		<CreateTime>%s</CreateTime>
		<MsgType><![CDATA[%s]]></MsgType>
		$item_str
		</xml>";
		$resut=sprintf($textTpl,$object->FromUserName,$object->ToUserName,time());
		return $result;
	}
	//reply for news
	private function transmitNews($object,$arr_item)
	{
		if(!is_array($arr_item))
			return ;
		$itemTpl="<item>
		<Title><![CDATA[%s]]></Title>
		<Description><![CDATA[%s]]></Description>
		<PicUrl><![CDATA[%s]]></PicUrl>
		<Url><![CDATA[%s]]></Url>
		</item>";
		$item_str="";
		foreach ($arr_item as $item)
			$item_str .=sprintf($itemTpl,$item['Title'],$item['Description'],$item['PicUrl'],$item['Url']);
		$newsTpl="<xml>
			<ToUserName><![CDATA[%s]]></ToUserName>
			<FromUserName><![CDATA[%s]></FromUserName>
			<CreateTime>%s</CreateTime>
			<MsgType><![CDATA[news]]></MsgType>
			<Content><![CDATA[]]></Content>
			<ArticleCount>%s</ArticleCount>
			<Articles>$item_str</Articles>
			</xml>";
			$result=sprintf($newsTpl,$object->FromUserName,$object->ToUserName,time(),count($arr_item));
			return $result;
	}
	private function transmitMusic($object,$musicArray)
	{
		$itemTpl="<Music><Title><![CDATA[%s]]></Title>
		<Description><![CDATA[[%s]]></Description>
		<MusicUrl><!CDATA[%s]]></MusicUrl>;
		<HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
		</Music>";
		$item_str=sprintf($itemTpl,$musicArray['Title'],$musicArray['Description'],
			$musicArray['MusicUrl'],$musicArray['HQMusicUrl']);
		$textTpl="<xml>
		<ToUserName><![CDATA[%s]]></ToUserName>
		<FromUserName><![CDATA[%s]]></FromUserName>
		<CreateTime>%s</CreateTime>
		<MsgType><![CDATA[music]]></MsgType>
		$item_str
		</xml>";
		$result=sprintf($textTpl,$object->FromUserName,$object->ToUserName,time());
		return $result;
	}


}

?>

