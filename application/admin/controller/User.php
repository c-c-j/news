<?php

namespace app\admin\controller;

use think\Controller;

/**
 * 后台用户控制器
 */
class User extends Controller
{
    /**
     * 前置操作: 在访问具体方法之前,优先访问的内容
     *
     * 在访问User控制器的方法之前,优先访问checkAdmin方法
     * 但是login和dologin方法除外(except)
     *
     * except 排除
     * only   只包含
     */
    protected $beforeActionList = [
        'checkAdmin' => [
            'except' => 'login,dologin',
        ],
    ];

    /**
     * 校验管理员登陆状态
     */
    public function checkAdmin()
    {
        if (!session('?admin')) {
            // 如果管理员没有登陆,则跳转到登陆页
            $this->error("请先登陆...", url('admin/user/login'));
        }
    }
    /**
     * 展示管理员的登陆表单
     */
    public function login()
    {
        return $this->fetch();
    }

    /**
     * 表单提交方法
     */
    public function doLogin()
    {
        $data = input('param.');
        print_r($data);

        // 校验验证码
        if (!captcha_check($data['captcha'])) {
            $this->error('验证码非法');
        }

        // 根据用户名和密码,查询账户信息
        $admin = model('user')->login($data['username'], $data['password']);
        // print_r($admin->toArray());
        // exit;
        if ($admin) {
            // 登陆成功
            // session赋值
            session('admin', $admin->toArray());
            $this->success("登陆成功", url('admin/index/index'));
        } else {
            // 登陆失败
            $this->error("登陆失败", url('admin/user/login'));
        }
    }

    /**
     * 用户退出
     */
    public function logout()
    {
        # 删除登陆时,赋值的session
        session('admin', null);

        // 退出后跳转到登陆页
        $this->redirect(url('admin/user/login'));
    }
}
