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
}
