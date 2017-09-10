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

    'app_id'  => env('WECHAT_APPID', 'wx7d47acb224c8c69c'),         // AppID
    'secret'  => env('WECHAT_SECRET', 'ef8fcc35f5a7e23459534fa010a3036e'),     // AppSecret
    'token'   => env('WECHAT_TOKEN', 'lvye'),          // Token
    'aes_key' => env('WECHAT_AES_KEY', '20vxfYBU70t4Yo11w40tUD6BSuptx8TayywhphxL8TK'),                    // EncodingAESKey
    'auto_login'=>env('WECHAT_AUTO_LOGIN',TRUE),
    'mch_id'  =>env('WECHAT_MCHID','1487699012'),
    'key'   =>env('WECHAT_PAY_KEY','bj4w4a1YqhHIMmgha65aN5kSQs02aNc2'),
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

