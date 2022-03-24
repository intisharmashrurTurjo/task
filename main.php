<?php

require_once './src/dbConfig.php';
$obj = new RowModel();
$obj2 = new SpreadModel();
$obj->select('customers','*',null,null,null,null);
$datas = $obj->getResult();
$keys = array_keys($datas[0]);
echo $obj2->SpreadSheet($datas,$keys);



?>