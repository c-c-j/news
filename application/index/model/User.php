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

    /**
     * 根据一对多关系,来获取某个用户下的博客
     *
     * 当前模型是 User
     */
    public function blogs()
    {
        //                   关联模型
        return $this->hasMany('Blog', 'uid')
            ->order('created DESC')
            ->paginate(5);
    }
    
}
