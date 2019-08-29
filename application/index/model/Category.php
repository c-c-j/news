<?php

namespace app\index\model;

use think\Model;

/**
 * 前台分类模型
 */
class Category extends Model
{
    /**
     * 获取推荐的分类,展示到导航条中,用作导航菜单
     *
     * @return
     */
    public function getNav()
    {
        return $this->field('id,title')
            ->where('recommend', 'eq', 1)
            ->select();
    }

    /**
     * 查询某格个分类下的所有的后代分类id
     *
     * @param  integer $parentid 父类id
     *
     * @return array
     */
    public function getSubs($parentid = 0, $target = [])
    {
        # 根据父类id,查询儿子分类
        $cs = $this->field('id')
            ->where('parentid', 'eq', $parentid)
            ->select();
        // 假设 $parentid=1 (体育的id)
        // $cs = [NBA, 中超]
        foreach ($cs as $c) {
            # 第一次遍历是 NBA
            $target[] = $c['id'];
            // 查询NBA下的分类id
            $target = $this->getSubs($c['id'], $target);

            # 第二次遍历是 中超
        }
        return $target;
    }

    /**
     * 根据父类id获取儿子分类
     *
     * @param  integer $parentid 父类id
     *
     * @return array
     */
    public function getSon($parentid)
    {
        return $this->field('id, title')
            ->where('parentid', 'eq', $parentid)
            ->select();
    }
}
