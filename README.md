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

(new \Laraswoole\App()) ->run($argv);
```

## 4、配置
在cofig文件下生成一个run.php文件:
```$xslt
return [
    'http'=>[
        'host'=>'0.0.0.0',
        'port'=>9500,
        'set_config'=>[
            'worker_num'=>2, // 一般开启cpu核数的两倍
            'max_request'=>5000
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
