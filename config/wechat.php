<?php

return [
    /*
     * Debug 模式，bool 值：true/false
     *
     * 当值为 false 时，所有的日志都不会记录
     */
    'debug'  => true,

    /*
     * 使用 Laravel 的缓存系统
     */
    'use_laravel_cache' => true,

    /*
     * 账号基本信息，请从微信公众平台/开放平台获取
     */

    'app_id'  => env('WECHAT_APPID', 'wxbd484099df3d396a'),         // AppID
    'secret'  => env('WECHAT_SECRET', '2d3aec927e7c36ad1bda1655bf45a03d'),     // AppSecret
    'token'   => env('WECHAT_TOKEN', 'fang81'),          // Token
    'aes_key' => env('WECHAT_AES_KEY', '45ZTv1goBEWP3wagvMHd9omKryBLMj0M8uJDXsoETDP'),                    // EncodingAESKey
    'auto_login'=>env('WECHAT_AUTO_LOGIN',FALSE),
    'mch_id'  =>env('WECHAT_MCHID','1386063702'),
    'key'   =>env('WECHAT_PAY_KEY','854fkY1f2Y9wvxr7kbkZXj9HU2oee2KA'),
    /*
     * 日志配置
     *
     * level: 日志级别，可选为：
     *                 debug/info/notice/warning/error/critical/alert/emergency
     * file：日志文件位置(绝对路径!!!)，要求可写权限
     */
    'log' => [
        'level' => env('WECHAT_LOG_LEVEL', 'debug'),
        'file'  => env('WECHAT_LOG_FILE', storage_path('logs/wechat.log')),
    ],
];
