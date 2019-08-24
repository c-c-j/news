<?php

namespace app\index\validate;

use think\Validate;

/**
 * 用户验证器
 */
class User extends Validate
{
    // 验证规则属性
    protected $rule = [
        'username'   => 'require|length:2,100|unique:user',
        'password'   => 'require|min:6',
        'repassword' => 'require|confirm:password',
        'email'      => 'require|email',
        'phone'      => [
            'regex' => '/^1(3\d|4[57]|5[0-37-9]|66|8[0235-9])\d{8}$/',
        ],
    ];
    
    // 提示消息属性
    protected $message = [
        'username.require'   => '用户名必须填写',
        'username.length'    => "用户名长度非法(2-100)",
        'username.unique'    => '用户名已被占用,请换一个',
        'password.require'   => '密码不能为空',
        'password.min'       => "密码最短是6位",
        'repassword.require' => '确认密码不能为空',
        'repassword.confirm' => '两次输入的密码不一致,请重新输入',
        'email.require'      => "邮箱不能为空",
        'email.email'        => '邮箱格式非法',
        'phone.regex'        => "手机号非法",
    ];

}
