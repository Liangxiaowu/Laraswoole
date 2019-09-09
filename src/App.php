<?php

namespace Laraswoole;
use Laraswoole\Core\HttpServer;

class App
{
    public function run($argv){
        define('ROOT_PATH',dirname(dirname(dirname(dirname(__DIR__)))));
        define('SERVICE_PATH',ROOT_PATH.'/service');
        define('APP_PATH',ROOT_PATH.'/app');
        define('CONFIG_PATH',ROOT_PATH.'/config');
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
