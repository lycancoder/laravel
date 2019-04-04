<?php
/**
 * Created by PhpStorm.
 * User: Lycan
 * Date: 2018/12/17
 * Time: 23:32
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VideoContestTeam extends Model
{
    use SoftDeletes;

    protected $table = 'video_contest_team';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
    protected $dateFormat = 'U';
    public $timestamps = true;

    /**
     * delDataIds 删除数据
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/12/22
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
}
