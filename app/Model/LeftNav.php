<?php
/**
 * 后台左侧导航栏
 * User: Lycan
 * Date: 2018/10/23
 * Time: 21:09
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeftNav extends Model
{
    use SoftDeletes;

    protected $table = 'left_nav';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
    protected $dateFormat = 'U';
    public $timestamps = true;

    /**
     * 获取菜单
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/10/19
     *
     * @return array
     */
    public function getNav()
    {
        $userPermission = session('loginUser')['nav_ids'];
        $userPermission = explode(',', $userPermission);

        $idArr = $this->where(['parent_id' => 0, 'status' => 1])->get(['id'])->toArray();
        $idArr = array_merge(array(0), array_pluck($idArr,'id'));
        $nav = $this->whereIn('parent_id' , $idArr)->whereIn('left_nav.id', $userPermission)->where('status', 1)
            ->orderBy('left_nav.sort', 'asc')->orderBy('left_nav.id', 'asc')
            ->leftJoin('font_icon', function ($join) {
                $join->on('left_nav.icon_id', '=', 'font_icon.id');
            })
            ->get(['left_nav.id', 'parent_id', 'left_nav.sort', 'target', 'title', 'code', 'url'])
            ->toArray();

        // 得到树形数据结构
        $navTree = tree($nav, 'id', 'parent_id', 'subset', 0);

        // 数据整理
        $retData = array();
        foreach ($navTree as $k1 => $v1) {
            // http:// 或 https:// 开头的url地址，返回原内容，否则返回 false
            $boolStr = filter_var($v1['url'], FILTER_VALIDATE_URL);

            $retData[$k1]['text'] = $v1['title'];
            $retData[$k1]['icon'] = $v1['code'];
            $retData[$k1]['href'] = $v1['url'] ? $boolStr == false ? route($v1['url']) : $v1['url'] : '';
            $retData[$k1]['target'] = $v1['target'] == 1 ? true : false;

            if (isset($v1['subset'])) {
                $retData[$k1]['subset'] = array();
                foreach ($v1['subset'] as $k2 => $v2) {
                    $boolStr = filter_var($v2['url'], FILTER_VALIDATE_URL);

                    $retData[$k1]['subset'][$k2]['text'] = $v2['title'];
                    $retData[$k1]['subset'][$k2]['icon'] = $v2['code'];
                    $retData[$k1]['subset'][$k2]['href'] = $v2['url'] ? $boolStr == false ? route($v2['url']) : $v2['url'] : '';
                    $retData[$k1]['subset'][$k2]['target'] = $v2['target'] == 1 ? true : false;
                }
            }
        }

        return $retData;
    }

    /**
     * 获取数据详细信息
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/10/19
     *
     * @param int $id
     * @return mixed
     */
    public function getInfoId(int $id)
    {
        $info = $this->where('left_nav.id', $id)
            ->leftJoin('font_icon', function ($join) {
                $join->on('left_nav.icon_id', '=', 'font_icon.id');
            })
            ->first(['left_nav.id', 'parent_id', 'left_nav.sort', 'target', 'status', 'title', 'icon_id', 'url', 'code']);
        return $info;
    }

    /**
     * 更新数据详细信息
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/10/19
     *
     * @param array $data
     * @return bool
     */
    public function updateInfo(array $data)
    {
        $model = $data['id'] ? $this->find($data['id']) : $this;

        $model->parent_id = $data['parent_id'];
        $model->title = $data['title'];
        $model->sort = (int)$data['sort'];
        $model->icon_id = (int)$data['icon'];
        $model->url = $data['url'];
        $model->target = $data['target'] ?? 2;
        $model->status = $data['status'] ?? 2;
        $bool = $model->save();

        return $bool;
    }

    /**
     * 更新新窗口打开
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/10/19
     *
     * @param int $id
     * @param int $target
     * @return mixed
     */
    public function updateTarget(int $id, int $target)
    {
        $num = $this->where('id', $id)->update(['target' => $target == 1 ? 1 : 2]);
        return $num;
    }

    /**
     * 更新状态
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/10/19
     *
     * @param int $id
     * @param int $status
     * @return mixed
     */
    public function updateStatus(int $id, int $status)
    {
        $num = $this->where('id', $id)->update(['status' => $status == 1 ? 1 : 2]);
        return $num;
    }

    /**
     * 更新排序
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/10/19
     *
     * @param int $id
     * @param int $sort
     * @return mixed
     */
    public function updateSort(int $id, int $sort)
    {
        $num = $this->where('id', $id)->update(['sort' => $sort]);
        return $num;
    }

    /**
     * 软删除数据
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/10/19
     *
     * @param string $ids
     * @return mixed
     */
    public function delDataIds(string $ids)
    {
        $idArr = explode(',', $ids);
        $num = $this->whereIn('id', $idArr)->delete();
        return $num;
    }

    /**
     * 菜单树
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/10/19
     *
     * @return array
     */
    public function navTree()
    {
        $list = $this->orderBy('sort', 'asc')->orderBy('id', 'asc')
            ->get(['id', 'parent_id', 'title'])
            ->toArray();
        $retData = tree($list);
        return $retData;
    }

    /**
     * navList 获取指定的菜单列表
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2019/3/18
     *
     * @param string $ids
     * @return mixed
     */
    public function navList(string $ids)
    {
        $idArr = explode(',', $ids);
        $list = $this->whereIn('id', $idArr)
            ->get(['id', 'status', 'title', 'url'])
            ->toArray();

        return $list;
    }
}