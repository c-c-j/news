<?php

namespace app\admin\controller;

use app\common\controller\AdminBase;

/**
 * 后台评论控制器
 */
class Comment extends AdminBase
{
    /**
     * 查看评论列表
     */
    public function index()
    {
        $list = model('comment')->getList();
        $this->assign('list', $list);
        return $this->fetch();
    }

    /**
     * 删除评论
     *
     * @param  integer $id 评论的主键id
     *
     * @return
     */
    public function delete($id)
    {
        $res = db('comment')->delete($id);
        if ($res) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }
}
