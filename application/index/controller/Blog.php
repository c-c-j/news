<?php

namespace app\index\controller;

use app\index\model\Blog as BlogModel;
use think\Controller;


/**
 * 前台博客控制器
 */
class  Blog extends Controller
{
	public function index()
	{
		//分页查询博客列表
		$list = model('Blog')
		->order('created DESC')
		->paginate(5);

		//查看最新的5条博客记录
		$newest = db('blog')
			->field('id, title')
			->order('created DESC')
			->limit(5)
			->select();
		
		//查看最热的五条博客记录
		$hotest = db('blog')
			->field('id, title, view')
			->order('view DESC')
			->select();
		$this->assign([
			'list' => $list,
			'newest' => $newest,
			'hotest' => $hotest
		]);

		return $this->fetch();

	}

    /**
     * 博客详情
     *
     */
    public function detail()
    {
        # 接收id参数
        $id = input('param.id');

        $data = BlogModel::get($id);

        // 查看最新的5条记录
        $newest = db('blog')
            ->field("id, title")
            ->order('created DESC')
            ->limit(5)
            ->select();

        // 查看最热的5条记录
        $hotest = db('blog')
            ->field("id, title, view")
            ->order('view DESC')
            ->limit(5)
            ->select();

        // 更新博客的浏览量
        db('blog')->where('id', 'eq', $id)
            ->setInc('view');

        // 将查到的结果赋值给模板
        $this->assign('data', $data);
        $this->assign('newest', $newest);
        $this->assign('hotest', $hotest);

        return $this->fetch();
    }

}