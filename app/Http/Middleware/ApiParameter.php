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
        // http://localhost/api/index?timestamp=1547047192215&nonce=6020526690292680&signature=6b2fd274073f1de2308403cb6e0cb78f89f3b66c9dbf647cb7cf224a270b7de4&src=lyite
        $token = 'lyite1001'; // 可以由英文和数字组成，自行指定
        $src = 'lyite'; // 自行指定
        $getData = $request->all();
        $timestamp = $getData['timestamp']; // 13位长度时间戳
        $nonce = $getData['nonce']; // 随机数
        $signature = self::SHA256("{$timestamp}{$nonce}{$token}");
        if ( !isset($getData['timestamp']) || !isset($getData['nonce']) || !isset($getData['signature']) || !isset($getData['src']) ) {
            echo 'url请求参数错误';
            exit();
        }

        if (13 != strlen($getData['timestamp'])) {
            echo '时间格式错误';
            exit();
        }

        if (16 != strlen($getData['nonce'])) {
            echo '随机数格式错误';
            exit();
        }

        if ($signature != $getData['signature']) {
            echo '签名格式错误';
            exit();
        }

        if ($src != $getData['src']) {
            echo 'src格式错误';
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
        return (float)sprintf('%.0f',(floatval($t1)+floatval($t2))*1000);
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
        $chars = '0123456789';
        $charsLength = strlen($chars);

        $nonce = '';
        for ($i = 0; $i < $length; $i++) {
            $nonce .= $chars[mt_rand(0, $charsLength-1)];
        }

        return $nonce;
    }
}