<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;

    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
    protected $dateFormat = 'U';
    public $timestamps = true;

    /**
     * isExistence 检查数据是否已经存在
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/12/5
     *
     * @param array $data
     * @return mixed
     */
    public function isExistence(array $data)
    {
        return $this
            ->when(isset($data['email']), function ($query) use ($data) {
                return $query->where('email', $data['email']);
            })
            ->when(isset($data['phone']), function ($query) use ($data) {
                return $query->where('phone', $data['phone']);
            })
            ->count();
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
     * 重置密码
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/10/19
     *
     * @param int $id
     * @return mixed
     */
    public function resetPassword(int $id)
    {
        $num = $this->where('id', $id)->update(['password' => password_hash('123456', PASSWORD_DEFAULT)]);
        return $num;
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
        $info = $this->where('id', $id)->first(['id','name','email','phone','status','sort','g_id']);
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

        if (empty($data['id'])) {
            if ($data['email'] && $this->isExistence(['email' => $data['email']]))
                return returnCode(0, '邮箱已存在');
            if ($data['phone'] && $this->isExistence(['phone' => $data['phone']]))
                return returnCode(0, '手机号码已存在');

            $model->password = password_hash('123456', PASSWORD_DEFAULT);
        } else {
            if (empty($model->email) && $data['email'] && $this->isExistence(['email' => $data['email']]))
                return returnCode(0, '邮箱已存在');
            if (empty($model->phone) && $data['phone'] && $this->isExistence(['phone' => $data['phone']]))
                return returnCode(0, '手机号码已存在');
        }

        $model->name = $data['name'];
        $model->email = $data['email'];
        $model->phone = $data['phone'];
        $model->sort = (int)$data['sort'];
        $model->g_id = (int)$data['g_id'];
        $model->status = $data['status'] ?? 2;
        $bool = $model->save();

        return returnCode($bool ? 1 : 0, $bool ? '操作成功' : '操作失败');
    }

    /**
     * checkLogin 检测用户登录
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/12/11
     *
     * @param string $data
     * @param string $type
     * @return mixed
     */
    public function checkLogin(string $data, $type = 'email')
    {
        $info = $this
            ->when($type == 'email', function ($query) use ($data) {
                return $query->where('email', $data);
            })
            ->when($type == 'phone', function ($query) use ($data) {
                return $query->where('phone', $data);
            })
            ->first(['id', 'name', 'email', 'phone', 'password', 'status', 'g_id', 'header_id']);

        return $info;
    }

    /**
     * changePassword 修改密码
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/12/11
     *
     * @param int $id
     * @param string $oldPwd
     * @param string $newPwd
     * @return array
     */
    public function changePassword(int $id, string $oldPwd, string $newPwd)
    {
        $info = $this->where('id', $id)->first(['password']);

        if (!password_verify($oldPwd, $info['password'])) {
            return returnCode(0, '原密码错误');
        }

        $num = $this->where('id', $id)->update(['password' => password_hash($newPwd, PASSWORD_DEFAULT)]);

        return returnCode($num ? 1 : 0, $num ? '操作成功' : '操作失败');
    }

    /**
     * changeHeader 修改头像
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2019/3/5
     *
     * @param int $id
     * @param int $fid
     * @return array
     */
    public function changeHeader(int $id, int $fid)
    {
        $num = $this->where('id', $id)->update(['header_id' => $fid]);
        return returnCode($num ? 1 : 0, $num ? '操作成功' : '操作失败');
    }
}
