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

    // 添加场景下,需要自动完成的字段
    protected $insert = [
        'balance' => 100,
    ];

    /**
     * 通过修改器,对密码进行md5加密
     */
    public function setPasswordAttr($value)
    {
        return md5($value);
    }

    /**
     * 根据一对多关系,来获取某个用户下的博客
     *
     * 当前模型是 User
     */
    public function blogs()
    {
        //关联模型
        return $this->hasMany('Blog', 'uid')
            ->order('created DESC')
            ->paginate(5);
    }
    
}
