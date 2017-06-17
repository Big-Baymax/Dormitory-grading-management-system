<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/4/8
 * Time: 10:51
 */
require_once 'background/Pages.class.php';
require_once 'libs/Smarty.class.php';

$smarty = new Smarty();


class returntable{
    public $arr;
    public $count;
    public $pages;
    public $upPage;
    function __construct($table, $c, $s,$page)
    {
        $p = new Pages($table, '*', $s);
        $count = $p->count($c);
        $arr = $p->select();
        $pages = $p->pages($page);
        $upPage = $p->upPage();
        $t = ($page - 1) * 15 + 1;
        for ($i = 0; $i < count($arr); $i++) {
            $arr[$i]['top'] = $t + $i;
        }
        $this->count = $count;
        $this->arr = $arr;
        $this->pages = $pages;
        $this->upPage = $upPage;
    }

    /**
     * @return array
     */
    public function getArr()
    {
        return $this->arr;
    }

    /**
     * @return float
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @return array
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * @return array
     */
    public function getUpPage()
    {
        return $this->upPage;
    }


}
