<?php

namespace app\admin\controller;

use app\common\controller\AdminBase;

/**
 * 后台Index控制器
 */
class Index extends AdminBase
{
    /**
     * 管理后台首页
     */
    public function index()
    {
        return $this->fetch();
    }
}
