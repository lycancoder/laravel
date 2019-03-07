<?php
/**
 * redis 客户端封装
 */

namespace App\Vendor;

use Illuminate\Support\Facades\Redis;

class RedisClient
{
    private $prefix = "lyite_redis_"; // 自定义redis键值前缀

    public function __construct($prefix = "")
    {
        if ($prefix) {
            $this->prefix = $prefix;
        }
    }

    public function set($key, $value, $timeout = 0)
    {
        if ($timeout) {
            Redis::setex($key, $timeout, $value);
        } else {
            Redis::set($key, $value);
        }
    }
}