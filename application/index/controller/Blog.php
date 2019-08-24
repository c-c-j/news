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
			->limit(5)
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

    /**
     * 博客添加页面
     */
    public function add()
    {
        // 判断用户有没有登陆
        if (session('?user')) {
            // 调用模板
            return $this->fetch();
        } else {
            // 如果没有登陆,则跳转到登陆页面
            $this->error("请先登陆...", url('index/user/login'));
        }
    }

        /**
     * 添加博客的提交方法
     */
    public function doAdd()
    {
        $data = input('param.');
        
        $data['uid'] = session('user.id');

        // 处理图片的上传
        // 1. 接收数据
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

        // 使用模型方式添加数据
        $res = model('blog')->save($data);
        if ($res) {
            $this->success("添加成功");
        } else {
            $this->error("添加失败");
        }
    }
}