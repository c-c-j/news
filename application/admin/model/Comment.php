<?php

namespace app\admin\model;

use think\Model;

/**
 * 后台评论模型
 */
class Comment extends Model
{
    // 开启时间字段的自动完成
    protected $autoWriteTimestamp = true;
    protected $updateTime         = false;
    protected $createTime         = 'created';

    /**
     * 查看新闻列表
     */
    public function getList()
    {
        return $this->field('*')
            ->order('created DESC')
            ->paginate();
    }

    /**
     * 查询评论的作者
     * 当前模型是 Comment
     */
    public function author()
    {
        return $this->belongsTo('user', 'uid');
    }

    /**
     * 转换评论类型
     *
     * @param  string $value 评论类型
     *
     * @return string
     */
    public function getCommentTypeAttr($value)
    {
        $status = [
            'Blog' => '博客',
            'News' => '新闻',
        ];

        return $status[$value];
    }
}
