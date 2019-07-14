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
            $value['created_at'] = date('Y-m-d H:i:s', $value['created_at']);
            $value['updated_at'] = date('Y-m-d H:i:s', $value['updated_at']);
        }

        return $params;
    }
}
