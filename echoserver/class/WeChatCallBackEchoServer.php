<?php
require_once dirname(__FILE__).'/WeChatCallBack.php';
class WeChatCallBackEchoServer extends WeChatCallBack{
	public function process(){
		if($this->_msgType!='text'){
			return $this->makeHint("only support text message");
		}
		return $this->makeHint($this->_postObject->Content);
	}
		
}
?>