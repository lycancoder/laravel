<?php
/**
 * Created by PhpStorm.
 * User: Lycan
 * Date: 2018/11/29
 * Time: 22:21
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserGroup extends Model
{
    use SoftDeletes;

    protected $table = 'user_group';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
    protected $dateFormat = 'U';
    public $timestamps = true;

    /**
     * getInfoId
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/12/3
     *
     * @param int $id
     * @return mixed
     */
    public function getInfoId(int $id)
    {
        $info = $this->where('id', $id)->first(['id', 'name', 'sort', 'nav_ids']);
        return $info;
    }

    /**
     * updateInfo 更新组相关数据
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/12/3
     *
     * @param array $data
     * @return bool
     */
    public function updateInfo(array $data)
    {
        $model = $data['id'] ? $this->find($data['id']) : $this;

        $model->name = $data['name'];
        $model->sort = $data['sort'];
        $bool = $model->save();

        return $bool;
    }

    /**
     * updatePermission 更新组权限
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/12/7
     *
     * @param array $data
     * @return bool
     */
    public function updatePermission(array $data)
    {
        $model = $data['id'] ? $this->find($data['id']) : $this;

        $model->nav_ids = $data['nav_ids'];
        $bool = $model->save();

        return $bool;
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
     * delDataIds 软删除数据
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/12/3
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
     * getList 获取组列表
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/12/6
     *
     * @return mixed
     */
    public function getList()
    {
        $list = $this->orderBy('sort', 'asc')->orderBy('id', 'asc')->get(['id','name']);
        return $list;
    }
}
