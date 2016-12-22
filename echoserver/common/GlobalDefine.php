<?php 
define('ROOT_PATH', dirname(__FILE__) . '/../');
define('DEFAULT_CHARSET', 'utf-8');
define('COMPONENT_VERSION', '1.0');
define('COMPONENT_NAME', 'wxmp');

//关闭NOTICE错误日志
error_reporting(E_ALL ^ E_NOTICE);

define('USERNAME_FINDFACE', 'gh_fd4633de8852');
define('USERNAME_MR', 'gh_a8b0ebbe91f5');
define('USERNAME_ES', "gh_oaco6ff491914c");		//haidiyun
define('USERNAME_MYZL', "gh_XXX");
define('WX_API_URL', "https://api.weixin.qq.com/cgi-bin/");
define('WX_API_APPID', "");
define('WX_API_APPSECRET', "");
define("WEIXIN_TOKEN", "weixin");

define("HINT_NOT_IMPLEMEMT", "未实现");
define('HINT_TPL', "<xml>
  <ToUserName><![CDATA[%s]]></ToUserName>
  <FromUserName><![CDATA[%s]]></FromUserName>
  <CreateTime>%s</CreateTime>
  <MsgType><![CDATA[%s]]></MsgType>
  <Content><![CDATA[%s]]></Content>
  <FuncFlag>0</FuncFlag>
</xml>
");
$GLOBALS['DB']=array(
	'DB'=>array(
		'HOST'=>'localhost',
		'DBNAME'=>'test',
		'USER'=>'root',
		'PASSWD'=>'',
		'PORT'=>3306
		),
	'MR'=>array(
		'HOST'=>'localhost',
		'DBNAME'=>'mr',
		'USER'=>'root',
		'PASSWD'=>'root',
		'PORT'=>3306
		)
	);
function getMillisecond() {
list($t1, $t2) = explode(' ', microtime());
return (float)sprintf('%.0f',(floatval($t1)+floatval($t2))*1000);
}
?>