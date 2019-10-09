<?php

namespace Laraswoole;
use Laraswoole\Core\HttpServer;

class App
{
    public function run($argv, $rootPath){
        define('ROOT_PATH',$rootPath);
        define('SERVICE_PATH',ROOT_PATH.'/vendor/xiaowu/laraswoole');
        define('ROUTE_PATH',ROOT_PATH.'/routes'); // 路由目录
        define('APP_PATH',ROOT_PATH.'/app');    // app目录
        define('CONFIG_PATH',ROOT_PATH.'/config');  // 配置目录
        try{
            switch ($argv[1]){
                case 'start':
                    // tcp服务
                    break;
                case 'ws:start':
                    // websocket 服务
                    break;
                case 'http:start':
                    (new HttpServer())->run();
                    // http服务
                    break;
            }


        }catch (\Exception $e){
            echo '异常'.$e->getMessage().PHP_EOL;
        }catch (\Throwable $t){
            echo '错误'.$t->getMessage().PHP_EOL;
        }

    }
}
