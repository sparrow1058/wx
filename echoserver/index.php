<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Lottery</title>
	<link rel="stylesheet" type="text/css" href="html/mycss.css">
	<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<script src="./css/jquery.min.js" type="text/javascript"></script>
	<script src="./css/Global.js" type="text/javascript"></script>

</script>	
</head>
<body>
<div class="page">
<div class="controls_ui">
	<a href="index.php?index=allballs"><button type="button" class="button squarebig" id="btn1">红球分析</button></a>
	<a href="index.php?index=rlost"><button type="button" class="button squarebig" id="btn2">篮球分析</button></a>
	<a href="index.php?index=blost"><button type="button" class="button squarebig" id="btn3">区间分布</button></a>
	<a href="index.php?index=update"><button type="button" class="button squarebig" id="btn4">数据更新</button></a>
</div >
<div class="datatable">
<?php
	require_once dirname (__FILE__).'/ssq.php';
	$webIndex=$_GET['index'];
	$ssq=new ssq();
	$ssq->init();
	$ssq->showWeb($webIndex);	
?>

</div>
<div  id="subtable">

</div>

<div style="text-align:center;clear:both">
</div>
</body>
</html>