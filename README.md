laravel通过swoole服务启动
## 1、依赖
```
    laravel:5.5\5.8
    php:>=7.2
    swoole:>=4.0

```

## 2、安装
```$xslt
composer require xiaowu/laraswoole
```

## 3、使用
复制public下的index.php文件，然后生成run.php内容修改成:
```$xslt
define('LARAVEL_START', microtime(true));
require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../bootstrap/app.php';

define('ROOT_PATH',dirname(__DIR__));

(new \Laraswoole\App()) ->run($argv);

```

## 4、配置
在cofig文件下生成一个run.php文件:
```$xslt
return [
     'localhost'=>'',  // 本服务IP地址，访问的服务器地址
     'http'=>[
         'host'=>'0.0.0.0', // 指定监听的ip地址
         'port'=>9500,      // 监听的端口
         'set_config'=>[     // 服务运行时的参数
             'worker_num'=>2, // 全异步非阻塞服务器 worker_num配置为CPU核数的1-4倍即可
             'max_request'=>5000 // 最大请求数
             // 其他参数可以参考swoole文档
         ]
     ],
    'ws'=>[
    
    ]
];
```

## 5、启动服务
```$xslt
http服务:
    php public/run.php http:start
websocket服务：
    
```
