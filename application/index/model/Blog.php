<?php

namespace app\index\model;

use think\Model;

/**
 * 前台博客模型
 */
class Blog extends Model
{
    // 声明时间字段的自动完成
    protected $autoWriteTimestamp = true;
    protected $updateTime         = 'updated';
    protected $createTime         = 'created';

    protected $insert = [
        'view' => 1,
        'uid',
    ];

    /**
     * 修改器    set字段名Attr()
     */
    public function setUidAttr()
    {
        return session('user.id');
    }


    /**
     * 查看某篇博客的作者信息
     *
     * 当前模型是Blog
     */
    public function author()
    {
        // 通过相对关联关系,查看博客作者信息
        //                  相对关联模型
        return $this->belongsTo('user', 'uid');
    }

    /**
     * 根据用户id,查询博客信息
     *
     * @param  integer $uid 用户id
     *
     * @return 对象
     */
    public function getBlogsByUid($uid)
    {
        return $this->where('uid', $uid)
            ->order('created DESC')
            ->paginate(5);
    }

    /**
     * 获取轮播图数据
     *
     * @param  integer $num 返回记录数
     * @return 对象
     */
    public function getSlide($num = 5)
    {
        return $this->field("id,title,image")
            ->where('image', 'neq', '')
            ->order('created DESC')
            ->limit($num)
            ->select();
    }

    /**
     * 查询博客下的评论 (多态一对多)
     *
     * 当前模型是 Blog
     */
    public function comments()
    {
        return $this->morphMany('Comment',['comment_type', 'comment_id'],$this->name)
            ->order('created DESC')
            ->paginate(5);
    }
    
}
