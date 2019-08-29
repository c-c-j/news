<?php

namespace app\common\controller;

use think\Controller;

/**
 * 前台控制器基础类
 */
class IndexBase extends Controller
{
    /**
     * 初始化方法
     *
     * 前台所有的方法调用之前,都需要完成的公共的功能
     */
    public function _initialize()
    {
        // 查询推荐的分类
        $cs = model('category')->getNav();
        
        $this->assign('cs', $cs);
    }
}