<?php
require_once dirname(__FILE__).'/../common/Common.php';
require_once dirname(__FILE__).'/../class/menuStub.php';
interface_log(DEBUG,0,"*************start menu***");
$menuData=array(
	'button'=>array(
			array(
				'type'=>'click',
				'name'=>'Today Music',
				'key'=>'V1001_TODAY_MUSIC'
				),
			array(
				'type'=>'click',
				'name'=>'Today Singer',
				'key'=>'V1001_TODAY_SINGER'
				),
			array(
				'name'=>"关于我们",
				'sub_button'=>array(
								array(
									'type'=>'click',
									'name'=>'web主页',
									'key'=>'V1001_HOME_KEY'
									),
								array(
									"type"=>"view",
									"name"=> "立足今日",
									"url"=>"http://www.haidiyun.top/info/today.html"
									),
								array(
									"type"=>"view",
									"name"=>"立足今日",
									"url"=>"http://www.haidiyun.top/info/tomorrow.html"
									)
								)
				),
			)
		);		// menuData
	$ret=menuStub::create('hdy',$menuData);
	if(false===$ret){
		interface_log(DEBUG,0,"Create menu fail!");
		echo "crate menu fail!\n";
	}else{
		interface_log(DEBUG,0,"create menu success");
		echo "crate menu success!\n";
	}
	interface_log(DEBUG,0,"**************end menu***************");
	
			
		

?>