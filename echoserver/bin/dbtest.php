<?php
require_once dirname(__FILE__).'/../common/Common.php';
try{
	$objSTO=new SingleTableOperation();
	$objSTO->setTableName('test');
	$objSTO->addObject(array('id'=>1,'name'=>'tom'));
	
	$ret=$objSTO->getObject();
	foreach ($ret as $item){
		echo "id: " .$item['id'] . "<BR>";
		echo "name: " .$item['name'] ."<BR>";
	}
}catch (DB_EXception $e){
	echo "sdb error!";
	echo $e->getMessage();
}

?>