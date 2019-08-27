<?php

namespace app\admin\model;

use think\Model;

/**
 * 后台博客模型
 */
class Blog extends Model
{
    // 声明时间字段的自动完成
    protected $autoWriteTimestamp = true;
    protected $updateTime         = 'updated';
    protected $createTime         = 'created';

    /**
     * 查询博客列表
     */
    public function getList()
    {
        return $this->field("id,uid,title,view,created")
            ->order('created DESC')
            ->paginate(10);
    }

    /**
     * 查询某篇博客的作者
     * 当前模型是: Blog
     */
    public function author()
    {
        return $this->belongsTo('user', 'uid');
    }
}
