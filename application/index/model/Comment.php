<?php

namespace app\index\model;

use think\Model;

/**
 * 前台评论模型
 */
class Comment extends Model
{
    // 开启时间的自动完成
    protected $autoWriteTimestamp = true;
    protected $updateTime         = false;
    protected $createTime         = "created";

    /**
     * 查看评论的作者信息
     * 当前模型是: Comment
     */
    public function author()
    {
        return $this->belongsTo('user', 'uid');
    }
}
