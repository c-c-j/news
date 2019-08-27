<?php

namespace app\admin\controller;

use app\common\controller\AdminBase;

/**
 * 后台博客控制器
 */
class Blog extends AdminBase
{
    /**
     * 后台博客列表
     */
    public function index()
    {
        $list = model('blog')->getList();
        $this->assign('list', $list);

        return $this->fetch();
    }

    /**
     * 添加博客
     */
    public function add()
    {
        # code...
    }

    /**
     * 编辑博客
     */
    public function edit()
    {
        # code...
    }
}
