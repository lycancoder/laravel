<?php

namespace App\Http\Middleware;

use Closure;

class ApiParameter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // http://localhost/api/index?sign=154704719221560205266902926806b2fd274073f1de2308403c
        // b6e0cb78f89f3b66c9dbf647cb7cf224a270b7de4lyite&method=index
        $token = 'lyite.com';
        $src = 'lyite';
        $getData = $request->all();

        if (
            !isset($getData['sign']) || empty($getData['sign']) ||
            !isset($getData['method']) || empty($getData['method'])
        ) {
            echo json_encode(array("code" => 1, "msg" => "url请求参数错误", "data" => []));
            exit();
        }

        if (98 != strlen($getData['sign'])) {
            echo json_encode(array("code" => 1, "msg" => "签名错误", "data" => []));
            exit();
        }

        $getTimestamp = substr($getData['sign'], 0, 13);
        $getNonce     = substr($getData['sign'], 13, 16);
        $getSrc       = substr($getData['sign'], -5, 5);
        $getSignature = substr($getData['sign'], 29, 64);

        if ($src != $getSrc) {
            echo json_encode(array("code" => 1, "msg" => "签名错误", "data" => []));
            exit();
        }

        $signature = self::SHA256("{$getTimestamp}{$getNonce}{$token}");
        if ($signature != $getSignature) {
            echo json_encode(array("code" => 1, "msg" => "签名错误", "data" => []));
            exit();
        }

        return $next($request);
    }

    /**
     * getMillisecond 生成13位长度时间戳
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2019/1/9
     *
     * @return float
     */
    protected function getMillisecond()
    {
        list($t1, $t2) = explode(' ', microtime());
        return (float)sprintf('%.0f',(floatval($t1) + floatval($t2)) * 1000);
    }

    /**
     * SHA256 sha256加密
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2019/1/9
     *
     * @param string $str
     * @return string
     */
    protected function SHA256(string $str)
    {
        $re = hash('sha256', $str, true);
        return bin2hex($re);
    }

    /**
     * setNonce 设置随机数
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2019/1/9
     *
     * @param int $length
     * @return string
     */
    protected function setNonce($length = 0)
    {
        $chars = '0123456789abcdefghijkmnpqrstuvwxyz';
        $charsLength = strlen($chars);

        $nonce = '';
        for ($i = 0; $i < $length; $i++) {
            $nonce .= $chars[mt_rand(0, $charsLength-1)];
        }

        return $nonce;
    }
}
