<?php

namespace app\index\model;

use think\Model;

/**
 * 前台新闻模型
 */
class News extends Model
{
    // 声明时间字段的自动完成
    protected $autoWriteTimestamp = true;
    protected $updateTime         = 'updated';
    protected $createTime         = 'created';

    /**
     * 通过相对关联关系,查看新闻的作者
     * 当前模型是 News
     * @return
     */
    public function author()
    {
        return $this->belongsTo('user', 'uid');
    }

    /**
     * 查看新闻的分类名称
     *
     * @return
     */
    public function category()
    {
        return $this->belongsTo('category', 'cid');
    }

    /**
     * 查询最新的新闻
     *
     * @param  integer $num 返回结果的数量
     *
     * @return 数组
     */
    public function getNewest($num = 5)
    {
        return $this->field('id, title')
            ->order('created DESC')
            ->limit($num)
            ->select();
    }

    /**
     * 查询最热新闻
     *
     * @param  integer $num 返回结果的数量
     *
     * @return array
     */
    public function getHotest($num = 5)
    {
        return $this->field("id, title, view")
            ->order('view DESC')
            ->limit($num)
            ->select();
    }

    /**
     * 根据分类id数组,查询推荐的新闻
     *
     * @param  array   $subIds 分类id数组
     * @param  integer $num    查询记录数
     *
     * @return array
     */
    public function getRecommend($subIds = null, $num = 10)
    {
        if (is_null($subIds)) {
            // 首页查询推荐
            return $this->field('id, title')
                ->where('recommend', 'eq', 1)
                ->where('online', 'eq', 1)
                ->order('created DESC')
                ->limit($num)
                ->select();
        } else {
            // 分类页面查询推荐
            return $this->field('id, title')
                ->where('cid', 'IN', $subIds)
                ->where('recommend', 'eq', 1)
                ->where('online', 'eq', 1)
                ->order('created DESC')
                ->limit($num)
                ->select();
        }
    }

    /**
     * 查询轮播图信息
     *
     * @param  array   $subIds 分类Id数组
     * @param  integer $num    查询记录数
     *
     * @return array
     */
    public function getSlide($subIds = null, $num = 5)
    {
        if (is_null($subIds)) {
            // 首页轮播
            return $this->field('id,title,image')
                ->where('image', 'neq', '')
                ->where('online', 'eq', 1)
                ->order('created DESC')
                ->limit($num)
                ->select();
        } else {
            // 分类详情页轮播
            return $this->field('id,title,image')
                ->where('cid', 'IN', $subIds)
                ->where('image', 'neq', '')
                ->where('online', 'eq', 1)
                ->order('created DESC')
                ->limit($num)
                ->select();
        }
    }

    /**
     * 根据分类id数组,查询上线新闻
     *
     * @param  array   $cids 分类id数组
     * @param  integer $num  查询结果的数量
     *
     * @return array
     */
    public function getNewsByCids($cids, $num = 10)
    {
        return $this->field('id, title')
            ->where('cid', 'IN', $cids)
            ->where('online', 'eq', 1)
            ->order('created DESC')
            ->limit($num)
            ->select();
    }
}
