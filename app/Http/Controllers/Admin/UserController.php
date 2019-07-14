<?php
/**
 * Created by PhpStorm.
 * User: Lycan
 * Date: 2018/11/29
 * Time: 23:19
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Logic\Timer;
use App\Model\User;
use App\Model\UserGroup;
use App\Model\UserLoginLog;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * groupPage 用户组列表页
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/12/3
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function groupPage()
    {
        return view('admin.user.groupPage');
    }

    /**
     * groupPageData 用户组列表页数据
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/12/3
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function groupPageData(Request $request)
    {
        $model = new UserGroup();
        $getData = $request->all();

        $data = $model
            ->when(isset($getData['name']), function ($query) use ($getData) {
                return $query->where('name', 'like', '%'.$getData['name'].'%');
            })
            ->orderBy('sort', 'asc')->orderBy('id', 'asc')
            ->paginate($request->get('limit', 10))
            ->toArray();

        $data['data'] = Timer::timestampToYmdHis($data['data']);

        return response()->json(['code' => 0, 'msg' => '加载成功', 'count' => $data['total'], 'data' => $data['data']]);
    }

    /**
     * updateGroupSort 更新组排序
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/12/5
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateGroupSort(Request $request)
    {
        $model = new UserGroup();
        $getData = $request->all();
        $ret = $model->updateSort($getData['id'], $getData['sort']);

        return response()->json(return_code($ret ? 0 : 1001, $ret ? '操作成功' : '操作失败'));
    }

    /**
     * groupEdit 用户组编辑页
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/12/3
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function groupEdit(Request $request)
    {
        $model = new UserGroup();
        $getData = $request->all();
        $data = $model->getInfoId($getData['id']);

        return view('admin.user.groupEdit', compact('data'));
    }

    /**
     * groupEditSubmit 保存用户组数据
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/12/3
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function groupEditSubmit(Request $request)
    {
        $model = new UserGroup();
        $getData = $request->all();
        $getData = json_decode($getData['data'], true);
        $ret = $model->updateInfo($getData);

        return response()->json(return_code($ret ? 0 : 1001, $ret ? '操作成功' : '操作失败'));
    }

    /**
     * delUserGroupData 删除用户组
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/12/3
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delUserGroupData(Request $request)
    {
        $model = new UserGroup();
        $getData = $request->all();
        $ret = $model->delDataIds($getData['ids']);

        return response()->json(return_code($ret ? 0 : 1001, $ret ? '操作成功' : '操作失败'));
    }

    /**
     * userPage 用户列表页
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/12/4
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function userPage()
    {
        return view('admin.user.userPage');
    }

    /**
     * userPageData 用户列表页数据
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/12/5
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function userPageData(Request $request)
    {
        $model = new User();
        $getData = $request->all();

        $data = $model
            ->when(isset($getData['name']), function ($query) use ($getData) {
                return $query->where('user.name', 'like', '%' . $getData['name'] . '%');
            })
            ->when(isset($getData['email']), function ($query) use ($getData) {
                return $query->where('email', $getData['email']);
            })
            ->when(isset($getData['phone']), function ($query) use ($getData) {
                return $query->where('phone', $getData['phone']);
            })
            ->orderBy('sort', 'asc')->orderBy('user.id', 'asc')
            ->leftJoin('user_group', function ($join) {
                $join->on('user.g_id', '=', 'user_group.id');
            })
            ->paginate($request->get('limit', 10), [
                'user.id', 'user.name', 'user.email', 'user.phone',
                'user.status', 'user.sort', 'user.updated_at', 'user.created_at',
                'user_group.name as g_name'
            ])
            ->toArray();

        $data['data'] = Timer::timestampToYmdHis($data['data']);

        return response()->json(['code' => 0, 'msg' => '加载成功', 'count' => $data['total'], 'data' => $data['data']]);
    }

    /**
     * updateUserSort 更新用户排序
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/12/5
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateUserSort(Request $request)
    {
        $model = new User();
        $getData = $request->all();
        $ret = $model->updateSort($getData['id'], $getData['sort']);

        return response()->json(return_code($ret ? 0 : 1001, $ret ? '操作成功' : '操作失败'));
    }

    /**
     * updateUserStatus 更新用户状态
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/12/5
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateUserStatus(Request $request)
    {
        $model = new User();
        $getData = $request->all();
        $ret = $model->updateStatus($getData['id'], $getData['status'] ? 1 : 2);

        return response()->json(return_code($ret ? 0 : 1001, $ret ? '操作成功' : '操作失败'));
    }

    /**
     * delUserData 删除用户
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/12/5
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delUserData(Request $request)
    {
        $model = new User();
        $getData = $request->all();
        $ret = $model->delDataIds($getData['ids']);

        return response()->json(return_code($ret ? 0 : 1001, $ret ? '操作成功' : '操作失败'));
    }

    /**
     * resetUserPassword 重置密码
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/12/5
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetUserPassword(Request $request)
    {
        $model = new User();
        $getData = $request->all();
        $ret = $model->resetPassword($getData['id']);

        return response()->json(return_code($ret ? 0 : 1001, $ret ? '操作成功' : '操作失败'));
    }

    /**
     * userEdit 用户编辑页
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/12/5
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function userEdit(Request $request)
    {
        $model = new User();
        $group = new UserGroup();
        $getData = $request->all();

        $data = $model->getInfoId($getData['id']);
        $group = $group->getList();

        return view('admin.user.userEdit', compact('data', 'group'));
    }

    /**
     * userEditSubmit 保存用户数据
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/12/5
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function userEditSubmit(Request $request)
    {
        $model = new User();
        $getData = $request->all();
        $getData = json_decode($getData['data'], true);
        $ret = $model->updateInfo($getData);

        return response()->json($ret);
    }

    /**
     * userLoginLogPage 用户登录日志列表页
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/12/4
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function userLoginLogPage()
    {
        return view('admin.user.userLoginLogPage');
    }

    /**
     * userLoginLogPageData 用户登录日志列表页数据
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/12/5
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function userLoginLogPageData(Request $request)
    {
        $model = new UserLoginLog();
        $getData = $request->all();

        $data = $model
            ->when(isset($getData['name']), function ($query) use ($getData) {
                return $query->where('name', 'like', '%' . $getData['name'] . '%');
            })
            ->orderBy('user_login_log.created_at', 'desc')
            ->leftJoin('user', function ($join) {
                $join->on('user_login_log.u_id', '=', 'user.id');
            })
            ->paginate($request->get('limit', 10), [
                'user.name', 'user_login_log.id', 'ip', 'user_login_log.created_at'
            ])
            ->toArray();

        foreach ($data['data'] as $key => $value) {
            $data['data'][$key]['created_at'] = date('Y-m-d H:i:s', $value['created_at']);
        }

        return response()->json(['code' => 0, 'msg' => '加载成功', 'count' => $data['total'], 'data' => $data['data']]);
    }

    /**
     * userChangePassword 修改密码页面
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/12/11
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function userChangePassword()
    {
        return view('admin.user.userChangePassword');
    }

    /**
     * userChangePasswordSubmit 保存新密码
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/12/11
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function userChangePasswordSubmit(Request $request)
    {
        $model = new User();
        $getData = $request->all();
        $getData = json_decode($getData['data'], true);
        $ret = $model->changePassword(session('loginUser')['id'], $getData['oldPassword'], $getData['newPassword']);

        return response()->json($ret);
    }

    /**
     * userChangeHeader 更换像页面
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2019/3/3
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function userChangeHeader()
    {
        return view('admin.user.userChangeHeader');
    }

    /**
     * userChangeHeaderSubmit 更换头像
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2019/3/5
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function userChangeHeaderSubmit(Request $request)
    {
        $model = new User();
        $getData = $request->all();
        $getData = json_decode($getData['data'], true);
        $ret = $model->changeHeader(session('loginUser')['id'], $getData['fid']);

        if ($ret["code"] === 0) {
            $userData = session("loginUser");
            $userData["header"] = $getData["furl"];
            session(['loginUser' => $userData]);
        }

        return response()->json($ret);
    }
}
