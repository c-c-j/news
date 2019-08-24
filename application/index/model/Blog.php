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
    
}
