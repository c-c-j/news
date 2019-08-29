<?php

namespace app\index\controller;

use app\common\controller\IndexBase;

/**
 * 前台评论控制器
 */
class Comment extends IndexBase
{
    /**
     * 添加评论
     */
    public function add()
    {
        # 获取表单数据
        $data = input('param.');

        // 使用模型方式添加数据
        $res = model('comment')->save($data);
        if ($res) {
            $this->success('评论成功');
        } else {
            $this->error("评论失败");
        }
    }
    
}
