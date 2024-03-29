<?php

namespace app\admin\controller;

use app\common\controller\AdminBase;

/**
 * 后台博客控制器
 */
class Blog extends AdminBase
{
    /**
     * 后台博客列表
     */
    public function index()
    {
        $list = model('blog')->getList();
        $this->assign('list', $list);

        return $this->fetch();
    }

    /**
     * 添加博客
     */
    public function add()
    {
        # code...
    }

    /**
     * 编辑博客
     */
    public function edit()
    {
        $id = input('param.id/d');

        if (is_numeric($id) && $id > 0) {

            $data = model('blog')->find($id);
            $this->assign('data', $data);

            return $this->fetch();
            
        } else {
            $this->error('参数非法');
        }
    }


    /**
     * 编辑表单的提交
     */
    public function doEdit()
    {
        # 接收表单数据
        $data = input('param.');
        $id   = input('param.id');

        // 图片上传,接收数据
        $file = request()->file('image');
        if ($file) {
            // 2. 执行上传
            $path = ROOT_PATH . 'public/static/upload';
            $info = $file
                ->validate(['size' => 2048000, 'ext' => 'jpg,png,gif'])
                ->move($path);
            if (is_object($info) && !empty($info->getSaveName())) {
                // 将图片的上传路径保存到数据库
                $data['image'] = $info->getSaveName();
            } else {
                $this->error($file->getError());
            }
        }

        $res = model('blog')->where('id', 'eq', $id)->update($data);
        if ($res) {
            $this->success('更新成功');
        } else {
            $this->error("更新失败");
        }
    }
}
