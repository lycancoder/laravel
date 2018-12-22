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
//    protected $fillable = ['name', 'email', 'password'];
//    protected $hidden = ['password'];
    protected $dates = ['delete_at'];
    protected $dateFormat = 'U';
    public $timestamps = true;

    public function getMemberList(int $id)
    {
        $list = $this->where('vct_id', $id)
            ->get(['name', 'gender', 'birth'])
            ->toArray();

        return $list;
    }
}