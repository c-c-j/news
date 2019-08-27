<?php

namespace app\admin\model;

use think\Model;

/**
 * 后台用户模型
 */
class User extends Model
{
    /**
     * 根据用户名和密码登陆后台
     *
     * @param  string $username 用户名
     * @param  string $password 密码
     *
     * @return 数组
     */
    public function login($username, $password)
    {
        $user = $this->field('id,username')
            ->where('username', 'eq', $username)
            ->where('password', 'eq', md5($password))
            ->where('admin', 'eq', 1)
            ->find();
        return $user;
    }
}
