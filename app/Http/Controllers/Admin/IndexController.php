<?php
/**
 * Created by PhpStorm.
 * User: Lycan
 * Date: 2018/10/14
 * Time: 18:03
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Logic\LogInOut\Login;
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        session()->flush(); // 清空所有 session
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

        # 验证 验证码
        $publicController = new PublicController();
        $verifyCode = $publicController->verifyCode($getData['code']);
        if ($verifyCode['code']) {
            $request->flash();
            return redirect()->back()->withErrors($verifyCode['msg']);
        }

        $login = new Login();
        if ('admin' == $getData['account']) { # 超管登录
            $result = $login->adminLogin($getData);
        } else { // 普通用户登录
            $getData['ip'] = $request->getClientIp(); # 获取客户端IP
            $result = $login->login($getData);
        }

        # 登录失败
        if ($result['code']) {
            $request->flash();
            return redirect()->back()->withErrors($result['msg']);
        }

        return redirect()->route('admin.index.index')->with('msg', '登录成功');
    }
}
