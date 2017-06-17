<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/2/25
 * Time: 16:26
 */
require_once 'background/Database.func.php';

class Pages{
    private $table;
    private $columns;
    private $where;
    private $database;
    private $c;
    private $page;
    function __construct($table,$columns,$where)
    {
        $this->database = Database();
        $this->table = $table;
        $this->columns = $columns;
        $this->where = $where;
    }

    //查找
    function select(){
        if(!empty($this->columns)) {
            $arr = $this->database->select($this->table, $this->columns, $this->where);
        }
        else{
            $arr = $this->database->select($this->table, $this->where);
        }
        return $arr;
    }

    //页数
    function count($where){
        $c = ceil($this->database->count($this->table,$where)/15);
        $this->c = $c;
        return $c;
    }

    //页码信息
    function pages($page){
        $c =$this->c;
        $pages = array();
        $n = 0;
		$this->page = $page;
        //如果到最后4页
        if(($c - $page) < 4) {
            for ($i = $page + 1; $i <= $c; $i++) {
                $pages[$n] = $i;
                $n++;
            }
            $this->page = $page;
            return $pages;
        }

        //否则
        else{
            for($i=1;$i<4;$i++){
                $pages[$n] = $this->page+$i;
                $n++;
            }
            $this->page = $page;
            return $pages;
        }
    }

    //返回上几页页码
    function upPage(){
    	$upPage = array();
        if($this->page <= 4 && $this->page != 1){
            for($i=1;$i<$this->page;$i++){
                $upPage[$i] = $i;
            }
        }
        if($this->page > 4){
            $a = $this->page-3;
            for($i=1;$i<3;$i++){
                $upPage[$i] = $a;
                $a++;
            }
        }
		return $upPage;
    }
}