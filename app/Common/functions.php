<?php
/**
 * 公共方法
 * User: Lycan
 * Date: 2018/10/1
 * Time: 23:36
 */


/**
 * 输出对应的变量或数组
 * @author Lycan
 * @email LycanCoder@gmail.com
 * @time 2018/10/1
 *
 * @param mixed $str 输出内容
 */
function p($str)
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

/**
 * 返回一个标准的基本数据结构
 * @author Lycan
 * @email LycanCoder@gmail.com
 * @time 2018/10/1
 *
 * @param int $code  状态
 * @param string msg 消息
 * @param null $data 数据
 * @return array
 */
function getStandResult($code = 0, $msg = 'Not Message', $data = null)
{
    return array('code' => $code, 'msg' => $msg, 'data' => $data ? $data : array());
}