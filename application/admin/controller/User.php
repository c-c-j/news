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

        // 校验验证码
        if (!captcha_check($data['captcha'])) {
            $this->error('验证码非法');
        }

        $admin = model('user')->login($data['username'], $data['password']);
        if ($admin) {
            session('admin', $admin->toArray());
            $this->success("登陆成功", url('admin/index/index'));
        } else {
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

        $this->redirect(url('admin/user/login'));
    }

    /**
     * 用户列表
     */
    public function index()
    {
        # 查看用户列表数据
        $list = model('user')->getList();

        $this->assign('list', $list);

        return $this->fetch();
    }

    /**
     * 删除用户
     */
    public function delete()
    {
        $id = input('param.id');
        if (is_numeric($id) && $id > 0) {
            $res = UserModel::destroy($id);
            if ($res) {
                $this->success("删除成功");
            } else {
                $this->error("删除失败");
            }
        } else {
            $this->error("参数非法");
        }
    }

}
