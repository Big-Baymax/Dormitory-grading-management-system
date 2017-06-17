<?php
/**
 * Created by PhpStorm.
 * User: 10367
 * Date: 2017/4/14
 * Time: 16:11
 */
// 输出Excel文件头，可把user.csv换成你要的文件名
require_once '../libs/medoo.php';
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="user.csv"');
header('Cache-Control: max-age=0');

session_start();
// 从数据库中获取数据，为了节省内存，不要把数据一次性读到内存，从句柄中一行一行读即可
$database = new medoo(['database_type' => 'mysql',
    'database_name' => 'dormitory',
    'server' => 'localhost',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8']);
$s = $_SESSION['s3'];
unset($s['LIMIT']);
$stmt = $database->select('grade', ['weekly', 'dormitory', 'year', 'department', 'sex', 'points'], $s);

// 打开PHP文件句柄，php://output 表示直接输出到浏览器
$fp = fopen('php://output', 'a');

// 输出Excel列名信息
$head = array( '周次', '宿舍号', '年纪', '系别', '性别', '扣分');
foreach ($head as $i => $v) {
// CSV的Excel支持GBK编码，一定要转换，否则乱码
    $head[$i] = iconv('utf-8', 'gbk', $v);
}

// 将数据通过fputcsv写到文件句柄
fputcsv($fp, $head);

// 计数器
$cnt = 0;
// 每隔$limit行，刷新一下输出buffer，不要太大，也不要太小
$limit = 100000;

// 逐行取出数据，不浪费内存
foreach($stmt as $value) {

    $cnt ++;
    if ($limit == $cnt) { //刷新一下输出buffer，防止由于数据过多造成问题
        ob_flush();
        flush();
        $cnt = 0;
    }

    foreach ($value as $i => $v) {
        $row[$i] = iconv('utf-8', 'gbk', $v);
    }
    fputcsv($fp, $row);
}