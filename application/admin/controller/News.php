<?php

namespace app\admin\controller;

use app\common\controller\AdminBase;

/**
 * 后台新闻控制器
 */
class News extends AdminBase
{
    /**
     * 新闻列表
     */
    public function index()
    {
        // 查询数据
        $list = model('news')->getList();

        $this->assign('list', $list);

        return $this->fetch();
    }

    /**
     * 添加新闻
     */
    public function add()
    {
        // 查看分类的树形结构
        $cs = model('category')->getTree();
        $this->assign('cs', $cs);
        return $this->fetch();
    }

    /**
     * 新闻表单提交
     */
    public function doAdd()
    {
        # 接收数据
        $data = request()->post();

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

        $res = model('news')->save($data);
        if ($res) {
            $this->success('添加成功', url('admin/news/index'));
        } else {
            $this->error("添加失败");
        }
    }

    /**
     * 新闻编辑展示页面
     */
    public function edit($id)
    {
        # 获取id
        // $id = input('param.id/d');
        if (is_numeric($id) && $id > 0) {
            $data = model('news')->find($id);
            // 查看分类的树形结构
            $cs = model('category')->getTree();

            $this->assign('cs', $cs);
            $this->assign('data', $data);
            return $this->fetch();
        } else {
            $this->error("参数非法");
        }
    }

    /**
     * 新闻编辑表单的执行方法
     */
    public function doEdit()
    {
        # 接收表单数据
        $data = input('param.');
        $id   = input('param.id');

        //接收数据
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

        $res = model('news')
            ->where('id', 'eq', $id)
            ->update($data);
        if ($res) {
            $this->success('更新成功', url('admin/news/index'));
        } else {
            $this->error("更新失败");
        }
    }

    /**
     * 执行新闻删除操作
     *
     * @param  integer $id 新闻的主键
     *
     * @return
     */
    public function delete($id)
    {
        if (is_numeric($id) && $id > 0) {
            $res = db('news')->delete($id);
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
