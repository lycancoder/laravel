<?php

namespace App\Logic;

Class Timer
{
    /**
     * timestampToYmdHis
     * @author Lycan LycanCoder@gmail.com
     * @date 2019/7/14
     *
     * @param array $params
     * @return array
     */
    static public function timestampToYmdHis($params = array())
    {
        foreach ($params as $key => &$value) {
            $value['create_at'] = date('Y-m-d H:i:s', $value['create_at']);
            $value['update_at'] = date('Y-m-d H:i:s', $value['update_at']);
        }

        return $params;
    }
}
