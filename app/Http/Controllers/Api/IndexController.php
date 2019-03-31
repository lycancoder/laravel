<?php
/**
 * Created by PhpStorm.
 * User: Lycan
 * Date: 2019/1/9
 * Time: 21:52
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * index 接口入口
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2019/3/31
     *
     * @param Request $request
     */
    public function index(Request $request)
    {
        $getData = $request->all();
        $method = $getData["method"];
        if (!method_exists($this, $method)) {
            echo json_encode(array("code" => 1, "msg" => $method."方法不存在", "data" => $getData));
            exit();
        }

        unset($getData["timestamp"], $getData["nonce"], $getData["signature"], $getData["src"], $getData["method"]);
        $this->$method($getData);
    }

    /**
     * returnJson 接口请求返回数据
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2019/3/31
     *
     * @param array $data
     */
    private function returnJson($data = array())
    {
        echo json_encode($data);
        exit();
    }

    /**
     * home 请求方法
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2019/3/31
     *
     * @param array $getData
     */
    private function home($getData = array())
    {
        $this->returnJson(return_code(0,"success", $getData));
    }
}