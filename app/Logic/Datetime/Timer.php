<?php

namespace App\Logic\Datetime;

Class Timer
{
    /**
     * 时间戳转 Y-m-d H:i:s 格式字符串
     * @author Lycan LycanCoder@gmail.com
     * @date 2019/7/14
     *
     * @param array $params
     * $params[$key]['created_at'] 必需 时间戳
     * $params[$key]['updated_at'] 必需 时间戳
     *
     * @return array
     */
    public static function timestampToYmdHis($params = array())
    {
        foreach ($params as $key => &$value) {
            $value['created_at'] = date('Y-m-d H:i:s', $value['created_at']);
            $value['updated_at'] = date('Y-m-d H:i:s', $value['updated_at']);
        }

        return $params;
    }
}
