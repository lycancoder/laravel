<?php
/**
 * Created by PhpStorm.
 * User: Lycan
 * Date: 2018/11/29
 * Time: 22:22
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserLoginLog extends Model
{
    use SoftDeletes;

    protected $table = 'user_login_log';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
    protected $dateFormat = 'U';
    public $timestamps = true;

    /**
     * 新增登录日志
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/11/29
     *
     * @param int $uid
     * @param string $ip
     * @return bool
     */
    public function addData(int $uid, string $ip)
    {
        $this->u_id = $uid;
        $this->ip = $ip;
        $bool = $this->save();

        return $bool;
    }
}