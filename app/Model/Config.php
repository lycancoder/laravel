<?php
/**
 * Created by PhpStorm.
 * User: Lycan
 * Date: 2019/5/8
 * Time: 20:06
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Config extends Model
{
    use SoftDeletes;

    protected $table = 'config';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
    protected $dateFormat = 'U';
    public $timestamps = true;

    /**
     * updateInfo 更新数据
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2019/5/9
     *
     * @param array $data
     * @return array
     */
    public function updateInfo(array $data)
    {
        $model = $data['id'] ? $this->find($data['id']) : $this;

        $key = strtoupper($data['key']);

        if (empty($data['id']) && $this->isExistence($key)) {
            return return_code(1001, '该配置项已经存在');
        }

        $model->key = $key;
        $model->value = $data['value'];
        $model->remark = $data['remark'];
        $bool = $model->save();

        return return_code($bool ? 0 : 1002, $bool ? '操作成功' : '操作失败');
    }

    /**
     * isExistence 检查数据是否已经存在
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2019/5/8
     *
     * @param string $key
     * @return mixed
     */
    private function isExistence(string $key)
    {
        return $this->where('key', $key)->count();
    }

    /**
     * 获取数据详细信息
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2019/5/8
     *
     * @param int $id
     * @return mixed
     */
    public function getInfoId(int $id)
    {
        $info = $this->where('id', $id)->first(['id', 'key', 'value', 'remark']);
        return $info;
    }

    /**
     * getValue 获取值
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2019/5/8
     *
     * @param string $key
     * @return mixed
     */
    public function getValue(string $key)
    {
        $info = $this->where('key', strtoupper($key))->first(['value']);
        return $info['value'];
    }
}