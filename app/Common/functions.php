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