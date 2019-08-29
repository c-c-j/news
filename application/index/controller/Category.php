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
        $subs[] = $id;//增加当前分类

        // 当前分类的推荐新闻
        $recommend = model('news')->getRecommend($subs);

        // 当前分类的轮播图
        $slide = model('news')->getSlide($subs);

        // 查询当前分类下的儿子分类
        $son = model('category')->getSon($id);

        // 查看子分类下的新闻
        $news = [];
        foreach ($son as $s) {

            // 查询子分类下的新闻id,包括当前分类
            $cids   = [];
            $cids   = model('category')->getSubs($s->id);
            $cids[] = $s->id;

            // 根据分类id数组,查看分类下的新闻
            $news[$s->id] = model('news')->getNewsByCids($cids);
        }

        $this->assign([
            'recommend' => $recommend,
            'slide'     => $slide,
            'son'       => $son,
            'news'      => $news,
        ]);

        return $this->fetch();
    }
}
