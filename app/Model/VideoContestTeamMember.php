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

class VideoContestTeamMember extends Model
{
    use SoftDeletes;

    protected $table = 'video_contest_team_member';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
    protected $dateFormat = 'U';
    public $timestamps = true;

    /**
     * getMemberList 获取团队成员
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2019/1/8
     *
     * @param int $id
     * @return mixed
     */
    public function getMemberList(int $id)
    {
        $list = $this
            ->where('vct_id', $id)
            ->get(['name', 'gender', 'birth'])
            ->toArray();

        return $list;
    }
}
