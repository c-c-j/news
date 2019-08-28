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

    /**
     * 查询用户列表
     */
    public function getList()
    {
        return $this->field('id,username,email,phone,admin,created')
            ->order('created DESC')
            ->paginate(10);
    }

        /**
     * 转换"是否是管理员"字段
     *
     * @param  integer $value 0普通用户,1管理员
     *
     * @return string
     */
    public function getAdminAttr($value)
    {
        $status = [
            0 => "普通用户",
            1 => "管理员",
        ];
        return $status[$value];
    }
}
