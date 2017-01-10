<?php
$servername = "qdm165226386.my3w.com";
$username = "qdm165226386";
$password = "leaf12345";
$dbname="lottery";
// 创建连接
$con = mysql_connect($servername, $username, $password);
if(!$con)
	echo "connect db faile";
$db_selected=mysql_select_db($dbname, $con);
if(!$db_selected)
{
	echo "select db fail";
	mysql_query("CREATE DATABASE ".$dbname,$con);
}
mysql_select_db($dbname, $con);
//$conn = new mysqli($servername, $username, $password, $dbname);
// 使用 sql 创建数据表
$sql1 = "	CREATE TABLE `ssqdata` (
	`id` int(11) NOT NULL ,
	`Num` int(11) NOT NULL ,
	`R1` int(2) NOT NULL ,
	`R2` int(2) NOT NULL ,
	`R3` int(2) NOT NULL ,
	`R4` int(2) NOT NULL ,
	`R5` int(2) NOT NULL ,
	`R6` int(2) NOT NULL ,
	`B1` int(2) NOT NULL ,
	`Sum` int(3) NOT NULL,
	`OEC` char(4)NOT NULL,
	`RANGE` char(20) NOT NULL
	)";
$sql2="			
CREATE TABLE lostRTable(
	 id int(11) NOT NULL ,
	 Num int(11) NOT NULL,
	 RL1 int(3) NOT NULL,
	 RL2 int(3) NOT NULL,
	 RL3 int(3) NOT NULL,
	 RL4 int(3) NOT NULL,
	 RL5 int(3) NOT NULL,
	 RL6 int(3) NOT NULL,
	 RL7 int(3) NOT NULL,
	 RL8 int(3) NOT NULL,
	 RL9 int(3) NOT NULL,
	 RL10 int(3) NOT NULL,
	 RL11 int(3) NOT NULL,
	 RL12 int(3) NOT NULL,
	 RL13 int(3) NOT NULL,
	 RL14 int(3) NOT NULL,
	 RL15 int(3) NOT NULL,
	 RL16 int(3) NOT NULL,
	 RL17 int(3) NOT NULL,
	 RL18 int(3) NOT NULL,
	 RL19 int(3) NOT NULL,
	 RL20 int(3) NOT NULL,
	 RL21 int(3) NOT NULL,
	 RL22 int(3) NOT NULL,
	 RL23 int(3) NOT NULL,
	 RL24 int(3) NOT NULL,
	 RL25 int(3) NOT NULL,
	 RL26 int(3) NOT NULL,
	 RL27 int(3) NOT NULL,
	 RL28 int(3) NOT NULL,
	 RL29 int(3) NOT NULL,
	 RL30 int(3) NOT NULL,
	 RL31 int(3) NOT NULL,
	 RL32 int(3) NOT NULL,
	 RL33 int(3) NOT NULL,
	 CURLOST char(30) NOT NULL
)";

if (mysql_query($sql1) === TRUE) {
    echo "Table MyGuests created successfully";
} else {
    echo "Create table1 fail: " . $conn->error;
}
if (mysql_query($sql2) === TRUE) {
    echo "Table MyGuests created successfully";
} else {
    echo "Crate tabl2 fail " . $conn->error;
}
//　　mysql_close($con);
?> 