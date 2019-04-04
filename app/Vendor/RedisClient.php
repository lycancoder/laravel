<?php
/**
 * redis 客户端操作简单封装
 */

namespace App\Vendor;

use Illuminate\Support\Facades\Redis;

class RedisClient
{
    private $prefix = "lyite_redis_"; // 自定义redis键值前缀

    /**
     * RedisClient constructor.
     * @param string $prefix
     */
    public function __construct(string $prefix = "")
    {
        if ($prefix) {
            $this->prefix = $prefix;
        }
    }

    /**
     * setKey 设置键
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2019/3/19
     *
     * @param $key
     * @return string
     */
    private function setKey($key)
    {
        return $this->prefix . $key;
    }

    /**
     * setVal 设置值(array|object -> string)
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2019/3/19
     *
     * @param $val
     * @return string
     */
    private function setVal($val)
    {
        if (is_array($val) || is_object($val)) {
            $val = $this->prefix . serialize($val);
        }

        return $val;
    }

    /**
     * getVal 解析值
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2019/3/19
     *
     * @param $val
     * @return mixed
     */
    private function getVal($val)
    {
        if (strpos($val, $this->prefix) === 0) {
            $value = substr($val, strlen($this->prefix));
            $val = unserialize($value);
        }

        return $val;
    }

    // +----------------------------------------------------------------------------------------------
    // |
    // | String（字符串）
    // |
    // | string是redis最基本的类型，你可以理解成与Memcached一模一样的类型，一个key对应一个value。
    // | string类型是二进制安全的。意思是redis的string可以包含任何数据。比如jpg图片或者序列化的对象。
    // | string类型是Redis最基本的数据类型，一个键最大能存储512MB。
    // |
    // +----------------------------------------------------------------------------------------------

    /**
     * set 设置指定 key 的值 过期时间(以秒为单位)
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2019/3/19
     *
     * @param $key
     * @param $val
     * @param int $timeout (s)
     */
    public function set($key, $val, int $timeout = 0)
    {
        $key = $this->setKey($key);
        $val = $this->setVal($val);

        if ($timeout) {
            Redis::setex($key, $timeout, $val);
        } else {
            Redis::set($key, $val);
        }
    }

    /**
     * add 只有在 key 不存在时设置 key 的值 过期时间(以秒为单位)
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2019/3/19
     *
     * @param $key
     * @param $val
     * @param int $timeout
     */
    public function add($key, $val, int $timeout = 0)
    {
        $key = $this->setKey($key);
        $val = $this->setVal($val);

        Redis::setnx($key, $val);
        if ($timeout) {
            Redis::expire($key, $timeout);
        }
    }

    /**
     * get 获取指定 key 的值
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2019/3/19
     *
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        $key = $this->setKey($key);
        $val = Redis::get($key);

        return $this->getVal($val);
    }

    /**
     * del  key 存在时删除 key
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2019/3/19
     *
     * @param $key
     */
    public function del($key)
    {
        $key = $this->setKey($key);
        Redis::del($key);
    }

    /**
     * pull 获取指定 key 的值 并 删除 key
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2019/3/19
     *
     * @param $key
     * @return mixed
     */
    public function pull($key)
    {
        $val = $this->get($key);
        $this->del($key);

        return $val;
    }

    /**
     * increment 将 key 所储存的值加上给定的浮点增量值
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2019/3/19
     *
     * @param $key
     * @param int $num
     */
    public function increment($key, int $num = 1)
    {
        $key = $this->setKey($key);
        Redis::incrby($key, $num);
    }

    /**
     * decrement key 所储存的值减去给定的减量值
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2019/3/19
     *
     * @param $key
     * @param int $num
     */
    public function decrement($key, int $num = 1)
    {
        $key = $this->setKey($key);
        Redis::decrby($key, $num);
    }

    // +----------------------------------------------------------------------------------------------
    // |
    // | Hash（哈希）
    // |
    // | Redis hash是一个键值对集合。
    // | Redis hash是一个string类型的field和value的映射表，hash特别适合用于存储对象。
    // |
    // +----------------------------------------------------------------------------------------------

    /**
     * hSet 将哈希表 key 中的字段 field 的值设为 value
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2019/3/19
     *
     * @param $key
     * @param $field
     * @param $val
     */
    public function hSet($key, $field, $val)
    {
        $key = $this->setKey($key);
        $val = $this->setVal($val);
        Redis::hset($key, $field, $val);
    }

    /**
     * hGet 获取存储在哈希表中指定字段的值
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2019/3/19
     *
     * @param $key
     * @param $field
     * @return mixed
     */
    public function hGet($key, $field)
    {
        $key = $this->setKey($key);
        $val = Redis::hget($key, $field);

        return $this->getVal($val);
    }

    /**
     * hKeys 获取所有哈希表中的字段
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2019/3/19
     *
     * @param $key
     * @return mixed
     */
    public function hKeys($key)
    {
        $key = $this->setKey($key);
        return Redis::hkeys($key);
    }

    /**
     * hGetAll 获取在哈希表中指定 key 的所有字段和值
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2019/3/19
     *
     * @param $key
     * @return mixed
     */
    public function hGetAll($key)
    {
        $key = $this->setKey($key);
        $res = Redis::hgetall($key);
        foreach ($res as &$v) {
            $v = $this->getVal($v);
        }

        return $res;
    }

    /**
     * hDel 删除一个哈希表字段
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2019/3/19
     *
     * @param $key
     * @param $field
     */
    public function hDel($key, $field)
    {
        $key = $this->setKey($key);
        Redis::hdel($key, $field);
    }

    // +----------------------------------------------------------------------------------------------
    // |
    // | List（列表）
    // |
    // | Redis 列表是简单的字符串列表，按照插入顺序排序。你可以添加一个元素导列表的头部（左边）或者尾部（右边）。
    // |
    // +----------------------------------------------------------------------------------------------

    /**
     * lPush 将一个值插入到列表头部
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2019/3/19
     *
     * @param $key
     * @param $value
     */
    public function lPush($key, $value)
    {
        $key = $this->setKey($key);
        $val = $this->setVal($value);
        Redis::lpush($key, $val);
    }

    /**
     * rPush 在列表中添加一个或多个值
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2019/3/19
     *
     * @param $key
     * @param $value
     */
    public function rPush($key, $value)
    {
        $key = $this->setKey($key);
        $val = $this->setVal($value);
        Redis::rpush($key, $val);
    }

    /**
     * lRange 获取列表指定范围内的元素
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2019/3/19
     *
     * @param $key
     * @param int $start
     * @param int $stop
     * @return mixed
     */
    public function lRange($key, int $start = 0, int $stop = -1)
    {
        $key = $this->setKey($key);
        $res = Redis::lrange($key, $start, $stop);

        foreach ($res as &$val) {
            $val = $this->getVal($val);
        }

        return $res;
    }

    /**
     * lRem 移除列表元素
     * @author Lycan <LycanCoder@gmail.com>
     * @date 2019/3/19
     *
     * @param $key
     * @param $val
     * @param int $count
     */
    public function lRem($key, $val, int $count = 1)
    {
        $key = $this->setKey($key);
        $val = $this->setVal($val);
        Redis::lrem($key, $count, $val);
    }
}
