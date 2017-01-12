<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Lottery</title>
	<link rel="stylesheet" type="text/css" href="html/mycss.css">
	<link rel="stylesheet" type="text/css" href="html/list.css">
	<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<script src="./css/jquery.min.js" type="text/javascript"></script>
	<script src="./css/Global.js" type="text/javascript"></script>

</script>	
</head>
<body>
<div class="page">
<div class="controls_ui">
	<a href="index.php?index=allballs"><button type="button" class="button squarebig" id="bt_red">红球分析</button></a>
	<a href="index.php?index=rlost"><button type="button" class="button squarebig" id="bt_blue">篮球分析</button></a>
	<a href="index.php?index=blost"><button type="button" class="button squarebig" id="bt_range">区间分布</button></a>
	<button type="button" class="button squarebig" id="bt_update">数据更新</button>
</div >
<div id="maintable" class="datatable">
<?php
	require_once dirname (__FILE__).'/ssq.php';
	$webIndex=$_GET['index'];
	$ssq=new ssq();
	$ssq->init();
	$ssq->showWeb($webIndex);	
?>

</div>
<div id="updatetable" style="width:520px;height:34px">
	<div>
		<ol class="rounded-list">
			<li id="ssqnum1"><a href="#">List item</a><span></li>
			<li id="ssqnum2"><a href="#">List item</a></li>
			<li id="ssqnum3"><a href="#">List item</a></li>	
			<span  id="bt_del" class="blueStyle" >删除最新行</span>
			<input id="t_password" type="text" placeholder="验证密码"  style="height:30px"/>
			
		</ol>
			
	</div>
	<div>
    <a href="#" class="blueStyle" style="height:30px">从文件更新数据</a><br><br>
	</div>
	<div>
	<input id="t_user" type="text" placeholder="更新密钥"  style="height:30px"/><BR>
	<input id="t_num" type="text" placeholder="期数"  style="height:30px"/><BR>
	<input id="t_data" type="text" placeholder="数据"  style="height:30px"/><br><BR>
	<a href="#" id="bt_ok" class="blueStyle" >确认更新</a>
	</div>

	
</div>
<div  id="subtable">

</div>

<div style="text-align:center;clear:both">
</div>

</body>
</html>