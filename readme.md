laravel通过swoole服务启动

## 1、安转
```$xslt
composer require xiaowu/laraswoole
```

## 2、使用
复制public下的index.php文件，然后生成run.php内容修改成:
```$xslt
define('LARAVEL_START', microtime(true));
require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../bootstrap/app.php';

(new \Laraswoole\App()) ->run($argv);
```

## 3、配置
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

## 4、启动服务
```$xslt
http服务:
    php public/run.php http:start
websocket服务：
    
```
