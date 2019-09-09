<?php
namespace Laraswoole\Core;

use  Swoole\Http\Server;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;
class HttpServer {
    private  $server;
    private $setting;
    private $localhost;
    public function run()
    {
        $config =  RunConfig::get_instance();
        $config->load(); //载入配置文件

        $this->setting=$config->get('http');
        $this->localhost = $config ->get('localhost');
        $this->server = new Server($this->setting['host'], $this->setting['port']);

        $this->server ->set($this->setting['set_config']);
        $this->server -> on('start', [$this, 'start']);
        $this->server -> on('WorkerStart', [$this, 'workerStart']);
        $this->server -> on('request', [$this, 'request']);;
        $this->server ->on('close', [$this, 'close']);

        $this->server ->start();

    }

    public function start(){
        echo 'App running at:'.PHP_EOL;
        echo  '- Local:   http://127.0.0.1:'.$this->setting['port'].PHP_EOL;
        if($this->localhost){
            echo ' - Network:   http://'.$this->localhost.':'.$this->setting['port'].PHP_EOL;
        }

        $reload = Reload::get_instance();
        // 热重启
        $reload->md5Flag=$reload->getMd5();
        swoole_timer_tick(3000, function () use ($reload) {
            if ($reload->reload()) {
                $this->server->reload(); //重启
            }
        });

    }

    public function workerStart($server, $response){

    }


    public function request($request, $response){
        //server信息
        $_SERVER = [];
        $_SERVER['argv'] = [];
        if (isset($request->server)) {
            foreach ($request->server as $k => $v) {
                $_SERVER[strtoupper($k)] = $v;
            }
        }

        //header头信息
        if (isset($request->header)) {
            foreach ($request->header as $k => $v) {
                $_SERVER[strtoupper($k)] = $v;
            }
        }
        //get请求
        $_GET = [];
        if (isset($request->get)) {
            foreach ($request->get as $k => $v) {
                $_GET[$k] = $v;
            }
        }

        //post请求
        $_POST = [];
        if (isset($request->post)) {
            foreach ($request->post as $k => $v) {
                $_POST[$k] = $v;
            }
        }
//        $this->writeLog(); //写入日志
        $_POST['WS_HTTP'] = $this->server;
        //文件请求
        $_FILES = [];
        if (isset($request->files)) {
            foreach ($request->files as $k => $v) {
                $_FILES[$k] = $v;
            }
        }

        //cookies请求
        $_COOKIE = [];
        if (isset($request->cookie)) {
            foreach ($request->cookie as $k => $v) {
                $_COOKIE[$k] = $v;
            }
        }

        ob_start();//启用缓存区
        $kernel = app()->make(Kernel::class);

        $laravelResponse = $kernel->handle(
            $laravelRequest = Request::capture()
        );
        $response->header("Content-Type", "application/json; charset=utf-8");
        $laravelResponse->send();

        $kernel->terminate($laravelRequest, $laravelResponse);
        $res = ob_get_contents();//获取缓存区的内容
        ob_end_clean();//清除缓存区
        $response ->end($res);
        echo "{$request->fd}服务连接上了";
    }

    // 关闭客户端连接
    public function close($fd){
        echo '关闭客户端';
    }


}

