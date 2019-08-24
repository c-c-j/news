<?php

namespace app\index\model;

use think\Model;

/**
 * 前台用户模型
 */
class User extends Model
{
    // 开启时间的自动完成
    protected $autoWriteTimestamp = true;
    protected $updateTime         = false;
    protected $createTime         = "created";
}
