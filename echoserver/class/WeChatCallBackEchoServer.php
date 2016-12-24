<?php
require_once dirname(__FILE__).'/WeChatCallBack.php';
class WeChatCallBackEchoServer extends WeChatCallBack{
	private $_event;
	private $_content;
	private $_eventKey;
	
	public function init($postObj){
		if(false==parent::init($postObj)){
			interface_log(ERROR,EC_OTHER,"init fail");
			return false;
		}
		if($this->_msgType=='event'){
			$this->_event=(string)$postObj->Event;
			$this->_eventKey=(string)$postObj->EventKey;
		}
		if($this->_msgType=='text'){
			$this->_content=(string)$postObj->Content;
		}
		return true;
	}
	
	
	public function process(){
		if(!($this->_msgType=='text'||($this->_msgType=='event'&&$this->event=='CLICK'))){
			interface_log(DEBUG,0,"msgType:".$this->_msgType."event:".$this->event);
			return $this->makeHint("not text message");
		}
		try{
			$STO=new SingleTableOperation("userinput","DB");
			if($this->_msgType=='event'&&$this->_event== 'CLICK'){
				$mode=$this->_eventKey;
				if($mode !='APPEND'&&$mode!='NORMAL'){
					return $this->makeHint("send error");
				}
				$ret=$STO->getObject(array("userId"=>$this->_fromUsername));
				if(!empty($ret)){
					$STO->updateObject(array("mode"=>$mode),array("userId"=>$this->_fromUserName));
				}else{
					$STO->addObject(array("userId"=>$this->_fromUserName,'mode'=>$mode));
				}
				return $this->makeHint("Mode set".$mode);
			}else{
				$text=$this->_content;
				$ret=$STO->getObject(array("userId"=>$this->_fromUserName));
				if(empty($ret)){
					$STO->addObject(array("userId"=>$this->_fromUserName));
					return $this->makeHint($text);
				}else{
					$mode=$ret[0]['mode'];
		
					$STO->updateObject(array('input'=>$ret[0]['input'].$text),array("userId"=>$this->_fromUserName));
					if($mode=='APPEND'){
						return $this->makeHint($ret[0]['input'].$text);
					}else{
					return $this->makeHint($text);
					//	return $this->makeHint($ret[0]['input'].$text);
					}
				}
			}
		}catch (DB_Exception $e){
			interface_log(ERROR,EC_DB_OP_EXCEPTION,"query db error".$e->getMessage());
		}
	}
	
}
		

?>