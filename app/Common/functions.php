<?php
/**
 * 公共方法
 * User: Lycan
 * Date: 2018/10/1
 * Time: 23:36
 */

if (!function_exists('p')) {
    /**
     * 输出对应的变量或数组
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/12/8
     *
     * @param string $str
     */
    function p(string $str)
    {
        if (is_bool($str)) {
            var_dump($str);
        } else if (is_null($str)) {
            var_dump(null);
        } else {
            echo '<pre style="position:relative;z-index:9999;padding:10px;'
                . 'border-radius:5px;background:#F5F5F5;border:1px solid #AAAAAA;'
                . 'font-size:14px;line-height:18px;opacity:0.9;">'
                . print_r($str, true) . '</pre>';
        }
    }
}

if (!function_exists('returnCode')) {
    /**
     * 返回一个标准的基本数据结构
     * @author Lycan <LycanCoder@gmail.com>
     * @time 2018/10/1
     *
     * @param int    $status 状态码
     * @param string $msg    消息
     * @param array  $data   数据
     * @return array
     */
    function returnCode($status = 0, $msg = 'Not Message', $data = array())
    {
        return array('status' => $status, 'msg' => $msg, 'data' => $data);
    }
}

if (!function_exists('tree')) {
    /**
     * 返回树形数据结构
     * @author Lycan <LycanCoder@gmail.com>
     * @time 2018/10/1
     *
     * @param array $list   数据
     * @param string $pk    主键
     * @param string $pid   父id
     * @param string $child 子树
     * @param int $root     根数据的父id
     * @return array
     */
    function tree(array $list, $pk = 'id', $pid = 'parent_id', $child = '_child', $root = 0)
    {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $value) {
            $refer[$value[$pk]] = &$list[$key];
        }

        // 定义Tree
        $tree = array();
        foreach ($list as $key => $value) {
            $parentId = $value[$pid];
            if ($parentId == $root) {
                $tree[] = &$list[$key];
            } else {
                // 判断是否存在parent
                if (isset($refer[$parentId])) {
                    $parent = &$refer[$parentId];
                    $parent[$child][] = &$list[$key];
                }
            }
        }

        return $tree;
    }
}

if (!function_exists('verify_email')) {
    /**
     * verify_email 验证邮箱
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/12/8
     *
     * @param string $v
     * @return bool
     */
    function verify_email(string $v)
    {
        $pattern = '/^[a-z0-9]+([._-][a-z0-9]+)*@([0-9a-z]+\.[a-z]{2,14}(\.[a-z]{2})?)$/i';
        return preg_match($pattern, $v) ? true : false;
    }
}

if (!function_exists('verify_phone')) {
    /**
     * verify_phone 验证手机号码
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2018/12/8
     *
     * @param string $v
     * @return bool
     */
    function verify_phone(string $v)
    {
        $pattern = '/^1\d{10}$/';
        return preg_match($pattern, $v) ? true : false;
    }
}

if (!function_exists("request_curl")) {
    /**
     * request_curl
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2019/1/22
     *
     * @param string $curl 请求地址
     * @param bool $https 请求类型
     * @param string $method 请求方式
     * @param null $data 请求参数数据
     * @param array $header 请求头内容
     * @return mixed|string
     */
    function request_curl(string $curl, $https = true, $method = "POST", $data = null, $header = array())
    {
        $ch = curl_init(); // 初始化

        // 是否有头信息
        if (count($header) == 0) {
            $header = array("Content-type: application/json;charset=UTF-8"); // 请求头信息
        }

        // 判断是否是使用 https 协议
        if ($https) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 禁止 cURL 验证对等证书
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // 不检查服务器SSL证书中是否存在一个公用名
        }

        // 是否是 POST 请求
        if ($method == "POST") {
            curl_setopt($ch, CURLOPT_POST, true); // 设置为 POST 请求
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // 设置POST的请求数据
        }

        curl_setopt($ch, CURLOPT_TIMEOUT, 20); // 超时时间（秒）
        curl_setopt($ch, CURLOPT_URL, $curl); // 设置访问的 URL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 返回字符串，而不直接输出
        curl_setopt($ch, CURLOPT_HEADER, false); // 将头文件的信息作为数据流输出
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header); // 设置请求头信息

        $content = curl_exec($ch); // 开始访问

        $errorNo = curl_errno($ch); // 请求错误代码号
        $errorMsg = curl_error($ch); // 错误信息

        curl_close($ch); // 关闭 释放资源

        if ($errorNo > 0) {
            return json_encode(array("status" => 0, "msg" => "cUrl Error (" . $errorNo . "): " . $errorMsg));
        }

        return $content;
    }
}