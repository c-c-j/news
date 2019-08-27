<?php

namespace app\common\controller;

use think\Controller;

/**
 * 后台控制器基类
 */
class AdminBase extends Controller
{
    /**
     * 初始化方法
     */
    public function _initialize()
    {
        if (!session('?admin')) {
            // 如果管理员没有登陆,则跳转到登录页
            $this->error("请先登陆...", url('admin/user/login'));
        }
    }
}
