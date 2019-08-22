<?php


namespace App\Logic\Nav;


use App\Model\LeftNav;

class AdminNav
{
    /**
     * navList 获取菜单栏及权限集合
     * @author Lycan LycanCoder@gmail.com
     * @date 2019/7/24
     *
     * @param array $params
     * @$params['ids'] 非必需，菜单及权限主键，可以是‘,’拼接的string('1,2,3')，也可以是索引array([1,2,3])
     *
     * @return mixed
     */
    public function navList($params = array())
    {
        $mode = new LeftNav();
        $list = $mode
            ->when(!empty($params['ids']), function ($query) use ($params) {
                if (!is_array($params['ids']))
                    $params['ids'] = explode(',', $params['ids']);

                return $query->whereIn('id', $params['ids']);
            })
            ->get(['id', 'status', 'title', 'url'])
            ->toArray();

        return return_code(0, '操作成功', $list);
    }
}