<?php
/**
 * Created by PhpStorm.
 * User: Lycan
 * Date: 2018/12/17
 * Time: 23:40
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\VideoContestTeam;
use App\Model\VideoContestTeamMember;
use Illuminate\Http\Request;

// 重庆大学生视频大赛
class VideoContestController extends Controller
{
    /**
     * applyPage 报名列表
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/12/22
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function applyPage()
    {
        return view('admin.videoContest.applyPage');
    }

    /**
     * applyPageData 报名列表数据
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/12/22
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function applyPageData(Request $request)
    {
        $model = new VideoContestTeam();
        $getData = $request->all();

        $data = $model
            ->when(isset($getData['phone']), function ($query) use ($getData) {
                return $query->where('phone', $getData['phone']);
            })
            ->when(isset($getData['id']), function ($query) use ($getData) {
                return $query->where('id', $getData['id']);
            })
            ->where('school', '!=', '')
            ->paginate($request->get('limit', 10), [
                'id', 'team_leader', 'team', 'number', 'tel', 'phone', 'school', 'major', 'created_at'
            ])
            ->toArray();

        foreach ($data['data'] as $key => $value) {
            $data['data'][$key]['created_at'] = date('Y-m-d H:i:s', $value['created_at']);
        }

        return response()->json(array(
            'code' => 0,
            'msg' => '加载成功',
            'count' => $data['total'],
            'data' => $data['data'],
        ));
    }

    /**
     * delVideoContestData 删除数据
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/12/22
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delVideoContestData(Request $request)
    {
        $model = new VideoContestTeam();
        $getData = $request->all();
        $ret = $model->delDataIds($getData['ids']);

        return response()->json(returnCode($ret ? 1 : 0, $ret ? '操作成功' : '操作失败'));
    }

    /**
     * videoContestMember 团队成员
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/12/22
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function memberPage(Request $request)
    {
        $model = new VideoContestTeamMember();
        $getData = $request->all();

        $data = $model->getMemberList($getData['id']);

        return view('admin.videoContest.memberPage', compact('data'));
    }
}