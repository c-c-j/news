<?php

namespace app\index\controller;

use app\common\controller\IndexBase;

/**
 * 前台分类控制器
 */
class Category extends IndexBase
{
    /**
     * 分类详情页面
     *
     * 访问地址: index/category/detail/id/数字
     *
     * @param  integer $id 分类id
     * @return
     */
    public function detail($id)
    {
        // 查询体育的后代分类id;
        $subs = model('category')->getSubs($id);
        // $subs是当前分类的后台分类数组(缺少当前分类id)
        $subs[] = $id;
        print_r($subs);

        // 当前分类的推荐新闻
        $recommend = model('news')->getRecommend($subs);
        $this->assign([
            'recommend' => $recommend,
        ]);

        return $this->fetch();
    }
}
