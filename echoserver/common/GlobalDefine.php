<?php 
define('ROOT_PATH', dirname(__FILE__) . '/../');
define('DEFAULT_CHARSET', 'utf-8');
define('COMPONENT_VERSION', '1.0');
define('COMPONENT_NAME', 'wxmp');


//关闭NOTICE错误日志
error_reporting(E_ALL ^ E_NOTICE);

define('USERNAME_FINDFACE', 'gh_fd4633de8852');
//define('USERNAME_MR', 'gh_a8b0ebbe91f5');
define('USERNAME_ES', "gh_oaco6ff491914c");		//haidiyun
//define('USERNAME_MR', "gh_be79e9451c82");	//luoyefeihua
define('USERNAME_MR', "gh_f2674742aefd");		//test
define('USERNAME_MYZL', "gh_XXX");
define('WX_API_URL', "https://api.weixin.qq.com/cgi-bin/");
define('WX_API_APPID', "");
define('WX_API_APPSECRET', "");
define('WEIXIN_TOKEN', "haidiyuntest");
define('HINT_NOT_IMPLEMEMT', "未实现");
define('HINT_TPL', "<xml>
  <ToUserName><![CDATA[%s]]></ToUserName>
  <FromUserName><![CDATA[%s]]></FromUserName>
  <CreateTime>%s</CreateTime>
  <MsgType><![CDATA[%s]]></MsgType>
  <Content><![CDATA[%s]]></Content>
</xml>
");
//  <FuncFlag>0</FuncFlag>
/**config for meiri10futu**/
define('MR_HINT_HELLO', "***每日十幅内涵图
***meiri10futu
1.输入?     获取下一张内涵图");
define('MR_HINT_INPUT', "***每日十幅内涵图
***meiri10futu
1.输入?获取下一张内涵图");
define('MR_HINT_NO_NEW_PIC', "你已经看完了所有的内涵图，请等待更新");
define('MR_HINT_LIMITED', "您是受限用户，一天只能看10幅内涵图。若要变成非受限用户:推荐好友添加本账号（meiri10futu），并让他发送以下验证码到本帐号为您激活：");
define('MR_HINT_NO_QUOTA', "你的激活名额已经使用完，如需更多的名额，请联系微信号：pacozhong");
define('MR_HINT_ALREADY_ACTIVE', "该用户已经激活");
define('MR_HINT_ACTIVE_SUCC', "激活成功");
define('MR_HINT_INNER_ERROR', "内部错误");
define('MR_HINT_ACTIVE_SELF', "不能激活自己");

define('PIC_OF_DAY', 100);

define('SUCC_TPL_MR', "<xml>
 <ToUserName><![CDATA[%s]]></ToUserName>
 <FromUserName><![CDATA[%s]]></FromUserName>
 <CreateTime>%s</CreateTime>
 <MsgType><![CDATA[news]]></MsgType>
 <ArticleCount>1</ArticleCount>
 <Articles>
 <item>
 <Title><![CDATA[内涵图**序号:%d**]]></Title> 
 <Description><![CDATA[如果图片没有完全展示，轻触图片查看全图]]></Description>
 <PicUrl><![CDATA[%s]]></PicUrl>
 <Url><![CDATA[%s]]></Url>
 </item>
 </Articles>
 <FuncFlag>1</FuncFlag>
 </xml>");

define('URL_HEADER', 'http://hdy.tunnel.qydev.com/weixin/echoserver');
define('FF_URL_HEADER', './image/');
define('IMAGE_URL','http://hdy.tunnel.qydev.com/weixin/echoserver/image/');		

$GLOBALS['APPID_APPSECRET']=array(
	'leaf'=>array(
		'appId'=>"",
		'appSecret'=>"",
		'appToken'=>""
		),
	'hdy'=>array(
		'appUser'=>"gh_oaco6ff491914c",
		'appId'=>"wx9dc85eb8cd0752fc",
		'appSecret'=>"7b09b4e138cb37a1b1b4a1413451a72d",
		'appToken'=>""
		),
		);

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
		'DBNAME'=>'mrten',
		'USER'=>'root',
		'PASSWD'=>'',
		'PORT'=>3306
		),
	'SSQLocal'=>array(
		'HOST'=>'localhost',
		'DBNAME'=>'ssq',
		'USER'=>'root',
		'PASSWD'=>'',
		'PORT'=>3306
		),	
	'SSQREMOTE'=>array(
		'HOST'=>'qdm165226386.my3w.com',
		'DBNAME'=>'qdm165226386_db',
		'USER'=>'qdm165226386',
		'PASSWD'=>'leaf12345',
		'PORT'=>3306
		),
		
	);
 
 /*****************************************************/
//For find face
define('API_KEY', '69727bbe2424f4d740c9532963');
define('API_SECRET', 'skt2kwE6gMDS5U_RBbqysIl_yLF');
define('FACE_URL', "https://api.faceplusplus.com/");
define('FACE_TIMEOUT', 5);
define('GROUP_NAME', 'findface');
define('SUCC_TPL_FINDFACE', "<xml>
 <ToUserName><![CDATA[%s]]></ToUserName>
 <FromUserName><![CDATA[%s]]></FromUserName>
 <CreateTime>%s</CreateTime>
 <MsgType><![CDATA[news]]></MsgType>
 <ArticleCount>1</ArticleCount>
 <Articles>
 <item>
 <Title><![CDATA[findface找到了！]]></Title> 
 <Description><![CDATA[如果照片没有完全展示，轻触图片查看全图]]></Description>
 <PicUrl><![CDATA[%s]]></PicUrl>
 <Url><![CDATA[%s]]></Url>
 </item>
 </Articles>
 <FuncFlag>1</FuncFlag>
 </xml>");
 define('FF_HINT_HELLO', "请自拍一张您的正面大头照发给我们，我们将为您找到微信世界里和你最像的人。
请注意：自拍时不要佩戴眼镜，否则我们不保证能完成任务。");
define('FF_HINT_INPUT_ERROR', "内部错误，请稍后再试。");
define('FF_HINT_TYPE_ERROR', "您发的不是照片。");
define('FF_HINT_FACE_ERROR', '内部错误，请稍后再试。');
define('FF_HINT_MULTIPLE_FACE', '请确保照片里只有您自己，否则我们无法确定要找和谁相似的脸。');
define('FF_HINT_NO_FACE', '在您发的照片中没有检测到脸。***请您在自拍时摘掉眼镜。');
define('FF_HINT_FACE_NO_CANDIDATE', '抱歉，在微信世界里还没有和您长得像的人。每秒有5个人加入微信，也许你要找的就是他们，请稍后再试。');
define('FF_HINT_INNER_ERROR', '内部错误，请稍后再试。');
 
 /*****************************************************/
	
	
	
	
	
	
	
	
	
	