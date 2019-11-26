<?php 
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