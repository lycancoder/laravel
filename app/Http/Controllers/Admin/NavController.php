<?php
/**
 * Created by PhpStorm.
 * User: Lycan
 * Date: 2018/10/21
 * Time: 22:52
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\LeftNav;
use App\Model\UserGroup;
use Illuminate\Http\Request;

class NavController extends Controller
{
    /**
     * 左侧菜单栏
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/10/19
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function leftNav()
    {
        $model = new LeftNav();
        $nav['data'] = $model->getNav();

        return response()->json($nav);
    }

    /**
     * 左侧菜单栏列表页面
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/10/19
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function leftNavTable()
    {
        return view('admin.nav.leftNavTable');
    }

    /**
     * 左侧菜单栏列表数据
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/10/19
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function leftNavTableData(Request $request)
    {
        $model = new LeftNav();
        $getData = $request->all();

        $grandpa = $model->find($getData['id'], ['parent_id']);
        $grandpa_id = $grandpa->parent_id ?? 0;

        $data = $model
            ->when(isset($getData['title']), function ($query) use ($getData) {
                return $query->where('title', 'like', '%'.$getData['title'].'%');
            })
            ->when(isset($getData['id']), function ($query) use ($getData) {
                return $query->where('parent_id', $getData['id']);
            })
            ->orderBy('sort', 'asc')->orderBy('left_nav.id', 'desc')
            ->leftJoin('font_icon', function ($join) {
                $join->on('left_nav.icon_id', '=', 'font_icon.id');
            })
            ->paginate($request->get('limit', 10), ['left_nav.*', 'code'])
            ->toArray();

        foreach ($data['data'] as $key => $value) {
            $data['data'][$key]['icon'] = '<i class="layui-icon">' . $value['code'] . '</i>';
            $data['data'][$key]['updated_at'] = date('Y-m-d H:i:s', $value['updated_at']);
            $data['data'][$key]['created_at'] = date('Y-m-d H:i:s', $value['created_at']);
        }

        return response()->json(array(
            'code' => 0,
            'msg' => '加载成功',
            'count' => $data['total'],
            'data' => $data['data'],
            'parent_id'=> $getData['id'],
            'grandpa_id'=> $grandpa_id,
        ));
    }

    /**
     * 左侧菜单栏配置编辑页面
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/10/19
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function leftNavEdit(Request $request)
    {
        $model = new LeftNav();
        $getData = $request->all();

        $data = $model->getInfoId($getData['id']);
        $parent_id = $getData['parent_id'];

        return view('admin.nav.leftNavEdit', compact('data', 'parent_id'));
    }

    /**
     * 左侧菜单栏配置编辑数据提交
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/10/19
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function leftNavEditSubmit(Request $request)
    {
        $model = new LeftNav();
        $getData = $request->all();

        $getData = json_decode($getData['data'], true);
        $ret = $model->updateInfo($getData);

        return response()->json(return_code($ret ? 0 : 1001, $ret ? '操作成功' : '操作失败'));
    }

    /**
     * 左侧菜单栏配置编辑新窗口打开设置
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/10/19
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateTarget(Request $request)
    {
        $model = new LeftNav();
        $getData = $request->all();
        $ret = $model->updateTarget($getData['id'], $getData['target'] ? 1 : 2);

        return response()->json(return_code($ret ? 0 : 1001, $ret ? '操作成功' : '操作失败'));
    }

    /**
     * 左侧菜单栏配置编辑是否启用设置
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/10/19
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Request $request)
    {
        $model = new LeftNav();
        $getData = $request->all();
        $ret = $model->updateStatus($getData['id'], $getData['status'] ? 1 : 2);

        return response()->json(return_code($ret ? 0 : 1001, $ret ? '操作成功' : '操作失败'));
    }

    /**
     * 左侧菜单栏配置编辑排序设置
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/10/19
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateSort(Request $request)
    {
        $model = new LeftNav();
        $getData = $request->all();
        $ret = $model->updateSort($getData['id'], $getData['sort']);

        return response()->json(return_code($ret ? 0 : 1001, $ret ? '操作成功' : '操作失败'));
    }

    /**
     * 左侧菜单栏配置删除数据
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/10/19
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delData(Request $request)
    {
        $model = new LeftNav();
        $getData = $request->all();
        $ret = $model->delDataIds($getData['ids']);

        return response()->json(return_code($ret ? 0 : 1001, $ret ? '操作成功' : '操作失败'));
    }

    /**
     * 左侧菜单栏配置权限
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/10/19
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function permission(Request $request)
    {
        $model = new LeftNav();
        $UserGroup = new UserGroup();
        $getData = $request->all();
        $permissions = $model->navTree();
        $userGroupInfo = $UserGroup->getInfoId($getData['id']);
        $groupPermission = explode(',', $userGroupInfo['nav_ids']);

        return view('admin.nav.permission', compact('permissions', 'userGroupInfo', 'groupPermission'));
    }

    /**
     * saveUserGroupPermission 保存用户组权限
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/12/7
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveUserGroupPermission(Request $request)
    {
        $model = new UserGroup();
        $getData = $request->all();
        $getData = json_decode($getData['data'], true);

        $gid = $getData['g_id'];
        unset($getData['_token'], $getData['g_id']);
        $ids = implode(',', $getData);
        $ret = $model->updatePermission(['id'=>$gid,'nav_ids'=>$ids]);

        return response()->json(return_code($ret ? 0 : 1001, $ret ? '操作成功' : '操作失败'));
    }
}
