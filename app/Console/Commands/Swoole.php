<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Swoole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'swoole:server {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'swoole command';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $action = $this->argument("action");

        switch ($action) {
            case "start":
                $this->start();
                break;
            case "restart":
                $this->restart();
                break;
            case "stop":
                $this->stop();
                break;
            default:
                break;
        }
    }

    private function start()
    {
        // 创建 websocket 服务器对象，监听 0.0.0.0:9501 端口
        $ws = new \swoole_websocket_server("0.0.0.0", 9501, SWOOLE_PROCESS, SWOOLE_SOCK_TCP | SWOOLE_SSL);

        $ws->set([
            "reactor_num" => 1, // 线程数 cpu核数
            "backlog" => 128, // 列队长度
            "daemonize" => false, // 守护进程化
            "max_request" => 50, // 最大请求数
            "max_conn" => 1000, // 最大连接数
            "heartbeat_check_interval" => 5, // 心跳检测间隔时间
            "heartbeat_idle_time" => 1800, // 允许连接最大空闲时间
            'ssl_cert_file' => '/usr/local/nginx/cert/214953059310619.pem',
            'ssl_key_file' => '/usr/local/nginx/cert/214953059310619.key',
        ]);

        $hander = app(\App\Logic\Swoole::class);

        $ws->on('open', [$hander, 'onOpen']);

        // 监听WebSocket 消息事件
        $ws->on('message', [$hander, 'onMessage']);
        $ws->on('close', [$hander, 'onClose']);
        $ws->start();
    }

    /**
     * 停止websocket
     */
    private function stop()
    {
        $cli = new \swoole_http_client('127.0.0.1', 9501);
        $cli->set([
            'websocket_mask' => true,
            'ssl_host_name' => 'www.lyite.com',
        ]);
        $cli->setHeaders([
            'Host' =>  'www.lyite.com',
            'UserAgent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 '
                . '(KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36'
        ]);
        $cli->on('message', function ($cli, $frame) {
            var_dump($frame);
        });
        $cli->upgrade('/', function ($cli) {
            $data = [
                'type' => 'swoole_stop'
            ];
            echo $cli->body;
            $cli->push(json_encode($data));
            $cli->close();
        });
    }
    /**
     * 重启
     */
    private function restart()
    {
        $cli = new \swoole_http_client('127.0.0.1', 9501);
        $cli->set([
            'websocket_mask' => true,
            'ssl_host_name' => 'www.lyite.com',
        ]);
        $cli->setHeaders([
            'Host' =>  'www.lyite.com',
            'UserAgent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 '
                . '(KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36'
        ]);
        $cli->on('message', function ($cli, $frame) {
            var_dump($frame);
        });
        $cli->upgrade('/', function ($cli) {
            $data = [
                'type' => 'swoole_restart'
            ];
            echo $cli->body;
            $cli->push(json_encode($data));
            $cli->close();
        });
    }
}
