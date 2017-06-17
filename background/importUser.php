<?php
/**
 * Created by PhpStorm.
 * User: 10367
 * Date: 2017/4/15
 * Time: 15:08
 */
require_once 'Classes/PHPExcel.php';
require_once 'Classes/PHPExcel/IOFactory.php';
require_once 'Classes/PHPExcel/Reader/Excel5.php';
require_once '../libs/medoo.php';
$database = new medoo(['database_type' => 'mysql',
    'database_name' => 'dormitory',
    'server' => 'localhost',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8']);
//接收上传文件
if ($_FILES["file"]["error"] > 0)
{
    echo "Error: " . $_FILES["file"]["error"] . "<br />";
}
$file = 'file/'.$_FILES['file']['name'];
//print_r($_FILES["file"]);
move_uploaded_file($_FILES['file']['tmp_name'], 'file/'.$_FILES['file']['name']);
//$objReader = PHPExcel_IOFactory::createReader('Excel5');//use excel2007 for 2007 format
$extension = substr($file, strrpos($file, '.')+1);
if(!strstr($extension,'xls')){
    $arr['result'] = 0;
    $arr['mes'] = '文件格式错误';
    echo json_encode($arr,JSON_UNESCAPED_UNICODE);
    exit;
}
if( $extension =='xlsx' )
{
    $objReader = new PHPExcel_Reader_Excel2007();
}
else
{
    $objReader = new PHPExcel_Reader_Excel5();
}

$objPHPExcel = $objReader->load('file/'.$_FILES['file']['name']); //$filename可以是上传的文件，或者是指定的文件
$sheet = $objPHPExcel->getSheet(0);
$highestRow = $sheet->getHighestRow(); // 取得总行数
$highestColumn = $sheet->getHighestColumn(); // 取得总列数
$k = 0;

//循环读取excel文件,读取一条,插入一条
//for($j=2;$j<=$highestRow;$j++)
//{
//    $a = $objPHPExcel->getActiveSheet()->getCell("id".$j)->getValue();
//    //$b = $objPHPExcel->getActiveSheet()->getCell("name".$j)->getValue();
//    echo $a.'<br/>';
//    //echo $b.'<br/>';
//}
for($j=2;$j<=$highestRow;$j++)                        //从第二行开始读取数据
{
    $str=array();
    for($k='A';$k<=$highestColumn;$k++)            //从A列读取数据
    {
        $str[$k]=$objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();//读取单元格
    }
    //print_r($str);
    if($database->insert('users', ['username' => $str['A'], 'sex' => $str['B'], 'no' => $str['C'], 'password' => $str['D'], 'phone' => $str['E'], 'dormitory' => $str['F'], 'class' =>$str['G'], 'dates' =>$str['H'], 'instructor' => $str['I']])){
        $arr['result'] = 1;
    }
    else{
        $arr['result'] = 0;
        $arr['mes'] = '导入失败';
    }
    //$str=mb_convert_encoding($str,'GBK','auto');//根据自己编码修改
//    $strs = explode("|*|",$str);
//// echo $str . "<br />";
//    $sql = "insert into test (title,content,sn,num) values ('{$strs[0]}','{$strs[1]}','{$strs[2]}','{$strs[3]}')";
////echo $sql;
//    if(!mysql_query($sql,$conn))
//    {
//        echo 'excel err';
//    }

}
echo json_encode($arr,JSON_UNESCAPED_UNICODE);