<?php

namespace app\index\controller;

use think\Controller;
use think\Request;
use think\Session;

/**
 * 前台用户控制器
 */
class User extends Controller
{
	/**
	 * 用户个人中心首页
	 * 
	 */
	public function index()
	{

        $user = model('user')->find(session('user.id'));
        var_dump($user);
        $this->assign('user', $user);
        $this->assign('blogs', $user->blogs());

        // 调用模板
        // 模板路径: index/view/user/center.html
        return $this->fetch();

		return $this->fetch();
	}

	/**
	 * 用户登录页面
	 * 
	 */
	public function login()
	{
		return $this->fetch();
	}

	/**
	 * 用户登录表单提交
	 * 
	 */
	public function doLogin()
	{
		$data = input('param.');

		$user = db('user')
		->where('username','eq',$data['username'])
		->where('password','eq',md5($data['password']))
		->find();

		if ( $user) {
            Session::set('user', $user);
			$this->success('登录成功','index/index/index');
			exit();
		}

		$this->error('登录失败');

	}

	/**
	 * 用户退出
	 * 
	 */
	public function logout()
	{
        Session::delete('user');

		$this->redirect(url('index/index/index'));
	}

	/**
	 * 用户注册页面
	 * 
	 */
	public function register()
	{
		return $this->fetch();
	}

	/**
	 * 执行用户表单提交
	 * 
	 */
	public function doRegister(Request $request)
	{
		$data = $request->post();

        // 校验验证码
        if (!captcha_check($data['captcha'])) {
            $this->error("验证码非法");
        };

        // 调用验证器,验证数据的合法性
        $v = validate('user');

        $data['password'] = md5($data['password']);

        $res = model('user')
        ->allowField(true) // 过滤非数据表字段(repassword)
            ->save($data);
        if ($res) {
            $this->success("注册成功");
        } else {
            $this->error("注册失败");
        }
	}
}