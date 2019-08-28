<?php

namespace app\admin\controller;

use app\common\controller\AdminBase;

/**
 * 后台分类控制器
 */
class Category extends AdminBase
{
    /**
     * 初始化方法
     */
    public function _initialize()
    {
        // 调用父类中的同名方法
        parent::_initialize();
        $cs = model('category')->getTree();

        $this->assign('cs', $cs);
    }

    /**
     * 添加表单页面
     */
    public function add()
    {
        return $this->fetch();
    }

    /**
     * 添加表单提交处理
     */
    public function doAdd()
    {
        $data = input('param.');
        
        $res = model('category')->save($data);
        if ($res) {
            $this->success("添加成功");
        } else {
            $this->error('添加失败');
        }
    }

    /**
     * 分类列表
     */
    public function index()
    {
        return $this->fetch();
    }

    /**
     * 编辑表单展示
     */
    public function edit()
    {

        $id = input('param.id/d');
        if (is_numeric($id) && $id > 0) {
            $data = model('category')->find($id);
            $this->assign('data', $data);

            return $this->fetch();
        } else {
            $this->error('参数非法');
        }
    }

    public function doEdit()
    {
        # 接收表单数据
        $data = input('param.');
        $id   = input('param.id');

        $res = model('category')
            ->where('id', 'eq', $id)
            ->update($data);
        if ($res) {
            $this->success('更新成功');
        } else {
            $this->error("更新失败");
        }
    }
}
