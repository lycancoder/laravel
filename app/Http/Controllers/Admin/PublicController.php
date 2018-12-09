<?php
/**
 * 公用的控制层
 * User: Lycan
 * Date: 2018/10/19
 * Time: 22:30
 */

namespace App\Http\Controllers\Admin;

use App\Model\FontIcon;
use App\Http\Controllers\Controller;
use App\Vendor\Captcha\Captcha;

class PublicController extends Controller
{
    /**
     * 架构方法
     * @author Lycan LycanCoder@gmail.com
     * @date 2018/10/19
     *
     * CommonController constructor.
     */
    public function __construct()
    {
    }

    /**
     * 获取验证码
     * @author Lycan LycanCoder@gmail.com
     * @date 2018/10/19
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function captcha()
    {
        $config = array(
            'useNoise' => true,
            'bgc'      => array(255, 87, 34),
            'codeSet'  => '0123456789'
        ); // 自定义配置数据

        $captcha = new Captcha($config);
        $captcha->getCodeImg();

        return response()->json();
    }

    /**
     * 检测验证码
     * @author Lycan LycanCoder@gmail.com
     * @date 2018/10/19
     *
     * @param string $code 验证码
     * @return array
     */
    public function verifyCode(string $code)
    {
        $captcha = new Captcha();
        return $captcha->verifyCode($code);
    }

    /**
     * 字体图标页面
     * @author Lycan LycanCoder@gmail.com
     * @date 2018/10/19
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function iconChar()
    {
        $model = new FontIcon();
        $list = $model->getList();
        return view('admin.common.iconChar', compact('list'));
    }
}