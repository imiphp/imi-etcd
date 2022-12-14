<?php

declare(strict_types=1);

use function Imi\env;
use Imi\Util\Imi;

$rootPath = \dirname(__DIR__) . '/';

return [
    'hotUpdate'    => [
        'status'    => false, // 关闭热更新去除注释，不设置即为开启，建议生产环境关闭

        // --- 文件修改时间监控 ---
        // 'monitorClass'    =>    \Imi\HotUpdate\Monitor\FileMTime::class,
        'timespan'    => 1, // 检测时间间隔，单位：秒

        // --- Inotify 扩展监控 ---
        // 'monitorClass'    =>    \Imi\HotUpdate\Monitor\Inotify::class,
        // 'timespan'    =>    1, // 检测时间间隔，单位：秒，使用扩展建议设为0性能更佳

        // 'includePaths'    =>    [], // 要包含的路径数组
        'excludePaths'    => [
            $rootPath . '.git',
            $rootPath . 'bin',
            $rootPath . 'logs',
        ], // 要排除的路径数组，支持通配符*
    ],
    'ConfigCenter' => [
        // 'mode'    => \Imi\ConfigCenter\Enum\Mode::WORKER, // 工作进程模式
        // 'mode'    => \Imi\ConfigCenter\Enum\Mode::PROCESS, // 进程模式
        'mode'    => env('IMI_CONFIG_CENTER_MODE', \Imi\ConfigCenter\Enum\Mode::PROCESS),
        'configs' => [
            'etcd' => [
                'driver'  => \Imi\Etcd\Config\EtcdConfigDriver::class,
                // 客户端连接配置
                'client'  => [
                    'scheme'              => env('IMI_ETCD_SCHEME', 'http'), // 主机名
                    'host'                => env('IMI_ETCD_HOST', '127.0.0.1'), // 主机名
                    'port'                => env('IMI_ETCD_PORT', 2379), // 端口号
                    'timeout'             => env('IMI_ETCD_TIMEOUT', 6000), // 网络请求超时时间，单位：毫秒
                    'ssl'                 => env('IMI_ETCD_SSL', false), // 是否使用 ssl(https) 请求
                    'version'             => env('IMI_ETCD_VERSION', 'v3'),
                    /**
                     * v3 v3alpha v3beta v2
                     * etcd v3.2以及之前版本只使用[CLIENT-URL]/v3alpha/*。
                        etcd v3.3使用[CLIENT-URL]/v3beta/*保持[CLIENT-URL]/v3alpha/*使用。
                        etcd v3.4使用[CLIENT-URL]/v3/*保持[CLIENT-URL]/v3beta/*使用。
                        [CLIENT-URL]/v3alpha/*被抛弃使用。
                        etcd v3.5以及最新版本只使用[CLIENT-URL]/v3/*。
                        [CLIENT-URL]/v3beta/*被抛弃使用。
                     */
                    'pretty'              => env('IMI_ETCD_PRETTY', true),
                    'sslCert'             => '',
                    'sslKey'              => '',
                ],
                // 监听器配置
                'listener' => [
                    'timeout'         => 30000, // 配置监听器长轮询超时时间，单位：毫秒
                    'failedWaitTime'  => 3000, // 失败后等待重试时间，单位：毫秒
                    'savePath'        => Imi::getRuntimePath('config-cache'), // 配置保存路径，默认为空不保存到文件。php-fpm 模式请一定要设置！
                    'fileCacheTime'   => 30, // 文件缓存时间，默认为0时不受缓存影响，此配置只影响 pull 操作。php-fpm 模式请一定要设置为大于0的值！
                    'pollingInterval' => 10000, // 客户端轮询间隔时间，单位：毫秒
                ],
                // 配置项
                'configs' => [
                    'etcd' => [
                        'key'  => 'imi-etcd-key1',
                    ],
                ],
            ],
        ],
    ],
    'AutoRunProcessManager' => [
        'processes' => [
            'TestProcess',
        ],
    ],
];
