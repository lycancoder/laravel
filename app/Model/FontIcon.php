<?php
/**
 * Created by PhpStorm.
 * User: Lycan
 * Date: 2018/11/24
 * Time: 20:29
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FontIcon extends Model
{
    use SoftDeletes; // 软删除需要

    protected $table = 'font_icon'; // 指定表名
    protected $primaryKey = 'id'; // 指定主键
    //protected $fillable = ['name', 'icon', 'font_class']; // 指定允许批量赋值的字段
    //protected $guarded = []; // 指定不允许批量赋值的字段
    protected $dates = ['deleted_at']; // 软删除字段
    protected $dateFormat = 'U'; // 时间戳格式
    public $timestamps = true; // 自动维护时间戳 updated_at created_at 字段

    /**
     * 字体图标列表
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/10/19
     *
     * @return mixed
     */
    public function getList()
    {
        $list = $this->orderBy('sort', 'asc')->orderBy('id', 'asc')->get();
        return $list;
    }

}