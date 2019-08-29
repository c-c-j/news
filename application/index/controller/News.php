<?php

namespace app\index\controller;

use app\common\controller\IndexBase;

/**
 * 前台新闻控制器
 */
class News extends IndexBase
{
    /**
     * 新闻详情页面
     *
     * @param  integer $id 新闻主键id
     *
     * @return
     */
    public function detail($id)
    {
        if (is_numeric($id) && $id > 0) {
            // 查看新闻详情
            $data = model('news')->find($id);

            // 浏览量递增
            db('news')->where('id', 'eq', $id)
                ->setInc('view');

            // 查询最新新闻
            $newest = model('news')->getNewest();

            // 查询最热新闻
            $hotest = model('news')->getHotest();

            $this->assign([
                'data'   => $data,
                'newest' => $newest,
                'hotest' => $hotest,
                'comments' => $data->comments()
            ]);
            return $this->fetch();
        } else {
            $this->error("参数非法");
        }
    }
}
