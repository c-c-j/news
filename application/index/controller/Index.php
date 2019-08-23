<?php
namespace app\index\controller;

class Index
{
    /**
     * 访问路径:index.php/index/index/index
     */
    public function index()
    {
        // 模板路径: view/index/index.html
        return $this->fetch();
    }
}
