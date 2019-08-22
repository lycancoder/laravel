<?php
/**
 * Swoole相关逻辑处理
 */

namespace App\Service\Swoole;

use App\Service\Redis\RedisClient;

class Swoole
{
    // 监听连接事件
    public function onOpen($ws, $request)
    {
        $redis = new RedisClient();
        $redis->rPush("connect", $request->fd);

        $arr = array(
            "type" => "setFd",
            "fd" => $request->fd
        );

        $ws->push($request->fd, json_encode($arr));
    }

    // 监听接收消息
    public function onMessage($ws, $request)
    {
        $data = json_decode($request->data, true);

        if (is_array($data)) {
            switch ($data["type"]) {
                case "msg":
                    $this->sendMsg($ws, $data, $request->fd);
                    break;
                case "setData":
                    $this->setData($ws, $data, $request->fd);
                    break;
                case "getUserAll":
                    $this->getUserAll($ws, $request->fd);
                    break;
                case "swoole_stop":
                    $ws->stop(-1);
                    break;
                case "swoole_restart":
                    $ws->reload(false);
                    break;
                default :
                    $data = [
                        "type" => "error",
                        "msg" => "数据类型错误"
                    ];
                    $ws->push($request->fd, json_encode($data));
                    break;
            }
        }
    }

    // 获取当前在线的所有用户
    private function getUserAll($ws, $fd)
    {
        $redis = new RedisClient();
        $fdAll = $redis->hGetAll("user_data");
        $data = array();

        foreach ($fdAll as $key => &$value) {
            $value["fd"] = $key;
            $data[] = $value;
        }

        $arr = [
            "type" => "getUserAll",
            "data" => $data
        ];

        $ws->push($fd, json_encode($arr));
    }

    // 设置资料
    private function setData($ws, $data, $fd)
    {
        $redis = new RedisClient();
        $arr = [
            "name" => $data["name"] ?? "",
            "icon" => $data["icon"] ?? "",
            "uid" => $data["uid"] ?? ""
        ];

        $redis->hSet("user_data", $fd, $arr);

        // 回执发送成功
        $send = [
            'type' => 'set_data_succ'
        ];

        $ws->push($fd, json_encode($send));
        $fdAll = $redis->hKeys("user_data");
        $arr["fd"] = $fd;
        $notice = [
            "type" => "addUser",
            "data" => $arr
        ];

        foreach ($fdAll as $value) {
            $ws->push($value, json_encode($notice));
        }
    }

    // 发送消息
    private function sendMsg($ws, $data, $fd)
    {
        $redis = new RedisClient();
        $userData = $redis->hGet("user_data", $fd);
//		$fdAll = $Redis->hKeys("user_data");
//		$connAll = $Redis->lRange("connect");

        // 群发信息
        $arr = [
            "type" => "msg",
            "fd" => $fd,
            "data" => [
                "user" => $userData,
                "msg" => $data["msg"],
                "time" => date("Y/m/d H:i")
            ]
        ];

        $ws->push($data["toFd"], json_encode($arr));
    }

    // 监听关闭连接
    public function onClose($ws, $fd)
    {
        $redis = new RedisClient();
        $redis->hDel("user_data", $fd);
        $redis->lRem("connect", $fd);

        // 通知某某下线了
        $connAll = $redis->lRange("connect");
        $arr = [
            "type" => "close_notice",
            "fd" => $fd
        ];

        foreach ($connAll as $value) {
            $ws->push($value, json_encode($arr));
        }
    }
}