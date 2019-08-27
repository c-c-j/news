<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Route;

// 设置首页的访问路由

Route::rule('/', 'index/index/index', 'get');
Route::get('user/login', 'index/user/login');
Route::post('user/doLogin', 'index/user/doLogin');

return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],

    // 方式二: 路由分组
    '[blog]'      => [
        ':id'   => [
            'index/blog/detail',
            ['method' => 'get'],
            ['id' => '\d+'],
        ],
        'add'   => [
            'index/blog/add',
            ['method' => 'get'],
        ],
        'doAdd' => [
            'index/blog/doAdd',
            ['method' => 'post'],
        ],
        '/'     => [
            'index/blog/index',
            ['method' => 'get'],
        ],
    ],

];
