<?php
/**
 * Created by PhpStorm.
 * User: Lycan
 * Date: 2018/10/14
 * Time: 18:03
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\LeftNav;
use App\Model\User;
use App\Model\UserGroup;
use App\Model\UserLoginLog;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * 后台主页页面
     * @author Lycan LycanCoder@gmail.com
     * @date 2018/10/19
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.index.index');
    }

    /**
     * 登录页面
     * @author Lycan LycanCoder@gmail.com
     * @date 2018/10/19
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login()
    {
        return view('admin.index.login');
    }

    /**
     * logout 退出
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/12/9
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        session()->forget('loginUser');
        session()->forget('LoginUserPermission');

        return redirect()->route('admin.index.login')->with('msg', '退出成功');
    }

    /**
     * 欢迎页面
     * @author Lycan LycanCoder@gmail.com
     * @date 2018/10/19
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function welcome()
    {
        return view('admin.index.welcome');
    }

    /**
     * 登录数据提交
     * @author Lycan LycanCoder@gmail.com
     * @date 2018/10/19
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function checkLogin(Request $request)
    {
        $getData = $request->all();

        $verifyCode = (new PublicController())->verifyCode($getData['code']);
        if ($verifyCode['status'] == 0) {
            $request->flash();
            return redirect()->back()->withErrors($verifyCode['msg']);
        }

        if (!verify_email($getData['account']) && !verify_phone($getData['account'])) {
            $request->flash();
            return redirect()->back()->withErrors('账号信息输入错误');
        }

        $model = new User();
        $userData = $model->checkLogin($getData['account'], verify_email($getData['account']) ? 'email' : 'phone');
        if (!$userData) {
            $request->flash();
            return redirect()->back()->withErrors('账号或密码错误');
        }

        if (!password_verify($getData['password'], $userData['password'])) {
            $request->flash();
            return redirect()->back()->withErrors('账号或密码错误');
        }

        if ($userData['status'] != 1) {
            $request->flash();
            return redirect()->back()->withErrors('该账号已被禁用');
        }

        $userGroup = new UserGroup();
        $groupInfo = $userGroup->getInfoId($userData['g_id']);
        $userData['groupName'] = $groupInfo['name'];
        $userData['nav_ids'] = $groupInfo['nav_ids'];
        session(['loginUser' => $userData]);

        $leftNav = new LeftNav();
        $navArr = $leftNav->navList($groupInfo['nav_ids']);
        $navPermissionArr = array();
        foreach ($navArr as $k => $v) {
            if (empty($v['url'])) { continue; }
            $navPermissionArr[$v['url']] = $v['id'];
        }
        session(['LoginUserPermission' => $navPermissionArr]);

        $userLoginLog = new UserLoginLog();
        $userLoginLog->addData($userData['id'], $request->getClientIp());

        return redirect()->route('admin.index.index')->with('msg', '登录成功');
    }
}