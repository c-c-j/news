<?php

namespace app\admin\model;

use think\Model;

/**
 * 后台新闻模型
 */
class News extends Model
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
        return session('admin.id');
    }

    /**
     * 获取新闻列表
     */
    public function getList()
    {
        $list = $this->field('*')
            ->order('created DESC')
            ->paginate();
        return $list;
    }

    /**
     * 查询某篇新闻的作者
     * 当前模型是: News
     */
    public function author()
    {
        return $this->belongsTo('user', 'uid');
    }

    /**
     * 查询新闻的所属分类
     */
    public function category()
    {
        return $this->belongsTo('category', 'cid');
    }

    /**
     * 获取器  get字段名Attr
     *
     * 如果查询的原始数据满足不了要求,对原始数据进行转换
     *
     * @param string $value 原始数据
     */
    public function getRecommendAttr($value)
    {
        $status = [
            0 => '<span class="text-danger">不推荐</span>',
            1 => '<span class="text-success">推荐</span>',
        ];

        return $status[$value];
    }

    /**
     * 转换是否上线字段
     *
     * @param  integer $value 是否上线原始数据
     *
     * @return string
     */
    public function getOnlineAttr($value)
    {
        $status = [
            0 => '<span class="glyphicon glyphicon-remove"></span>',
            1 => '<span class="glyphicon glyphicon-ok"></span>',
        ];

        return $status[$value];
    }
}
