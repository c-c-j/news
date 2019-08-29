<?php

namespace app\index\controller;

use app\common\controller\IndexBase;

class Index extends IndexBase
{
    /**
     *新闻首页
     */
    public function index()
    {
        // 查询首页的轮播图
        $slide = model('news')->getSlide();

        // 查询首页的推荐新闻
        $recommend = model('news')->getRecommend();

        // 查询一级分类 parentid=0
        $son = model('category')->getSon(0);

        // 查询一级分类下的新闻
        $news = [];
        // $son = [体育, 娱乐]
        foreach ($son as $s) {
            # 第一次遍历 $s 是体育
            // 查询体育下的新闻
            // 1. 获取体育的后台分类id
            $cids   = [];
            $cids   = model('category')->getSubs($s->id);
            $cids[] = $s->id;

            // 2. 根据分类id数组,查询新闻
            //    $news[体育的id] = 体育下的新闻
            $news[$s->id] = model('news')->getNewsByCids($cids);

            # 第二次遍历 $s 是娱乐
        }

        $this->assign([
            'slide'     => $slide,
            'recommend' => $recommend,
            'son'       => $son,
            'news'      => $news,
        ]);

        // 模板路径: view/index/index.html
        return $this->fetch();
    }

}
