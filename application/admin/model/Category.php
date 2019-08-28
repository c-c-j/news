<?php

namespace app\admin\model;

use think\Model;

/**
 * 后台分类模型
 */
class Category extends Model
{
    // 开启时间字段的自动完成
    protected $autoWriteTimestamp = true;
    protected $updateTime         = false;
    protected $createTime         = 'created';

    /**
     * [getTree description]
     *
     * @param  integer $parentid 父类id
     *
     * @return 数组
     */
    public function getTree($parentid = 0, $target = [])
    {
        // 查询一级分类
        $cs = $this->field('*')
            ->where('parentid', 'eq', $parentid)
            ->select();
        static $n = 1;
        // $cs = [体育, 娱乐];
        foreach ($cs as $c) {
            # 第一次遍历 $c是体育
            $tmp          = null;
            $tmp          = $c->toArray();
            $tmp['level'] = $n;
            $target[]     = $tmp;
            // $tmp['id'] // 体育的id
            // 查询体育下的二级分类
            $n++;
            $target = $this->getTree($tmp['id'], $target);
            $n--;
            # 第二次遍历 $c是娱乐
        }

        return $target;
    }

    /**
     * 获取器  get字段名Attr
     *
     * 如果查询的原始数据满足不了要求
     * 可以对原始数据进行转换
     *
     * @param string $value 原始数据
     */
    public function getRecommendAttr($value)
    {
        $status = [
            0 => '<span class="text text-danger">不推荐</span>',
            1 => '<span class="text text-success">推荐</span>',
        ];

        return $status[$value];
    }
}
