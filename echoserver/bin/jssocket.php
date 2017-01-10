<?php
$action = $_GET['action'];
$num=$_GET['num'];
echo $action."   "$num;
switch($action){
	case "showrlost":
		showrlost($num);
		break;
	case "showother":
		break;
}
function showRLost($num)
{
	
	$arr = array('id'=>$insertid,'title'=>$title,'success'=>1);
   echo json_encode($arr);
   break;
	
}
