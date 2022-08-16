
# imi-etcd

[![Latest Version](https://img.shields.io/packagist/v/imiphp/imi-etcd.svg)](https://packagist.org/packages/imiphp/imi-etcd)
[![Php Version](https://img.shields.io/badge/php-%3E=7.4-brightgreen.svg)](https://secure.php.net/)
[![Swoole Version](https://img.shields.io/badge/swoole-%3E=4.8.0-brightgreen.svg)](https://github.com/swoole/swoole-src)
[![imi License](https://img.shields.io/badge/license-MulanPSL%202.0-brightgreen.svg)](https://github.com/imiphp/imi-etcd/blob/2.1/LICENSE)

## 介绍

此项目是 imi 框架的 etcd 组件。

> 正在开发中，随时可能修改，请勿用于生产环境！

**支持的功能：**

* [x] 配置中心

## Composer

本项目可以使用composer安装，遵循psr-4自动加载规则，在你的 `composer.json` 中加入下面的内容:

```json

```

然后执行 `composer update` 安装。

## 使用说明

### 配置

`@app.beans`：

```php
[
    'ConfigCenter' => [
        // 'mode'    => \Imi\ConfigCenter\Enum\Mode::WORKER, // 工作进程模式
        'mode'    => \Imi\ConfigCenter\Enum\Mode::PROCESS, // 进程模式
        'configs' => [
            'etcd' => [
                'driver'  => \Imi\Etcd\Config\EtcdConfigDriver::class,
                // 客户端连接配置
                'client'  => [
                    'scheme'              => env('IMI_ETCD_HOST', 'http'), // 主机名
                    'host'                => env('IMI_ETCD_HOST', '127.0.0.1'), // 主机名
                    'port'                => env('IMI_ETCD_PORT', 2379), // 端口号
                    'timeout'             => env('IMI_ETCD_TIMEOUT', 6000), // 网络请求超时时间，单位：毫秒
                    'ssl'                 => env('IMI_ETCD_SSL', false), // 是否使用 ssl(https) 请求
                    'version'             => env('IMI_ETCD_VERSION', 'v3'), /**
                     * v3 v3alpha v3beta v2
                     * etcd v3.2以及之前版本只使用[CLIENT-URL]/v3alpha/*。
                     * etcd v3.3使用[CLIENT-URL]/v3beta/*保持[CLIENT-URL]/v3alpha/*使用。
                     * etcd v3.4使用[CLIENT-URL]/v3/*保持[CLIENT-URL]/v3beta/*使用。
                     * [CLIENT-URL]/v3alpha/*被抛弃使用。
                     * etcd v3.5以及最新版本只使用[CLIENT-URL]/v3/*。
                     * [CLIENT-URL]/v3beta/*被抛弃使用。
                     */
                    'pretty'              => env('IMI_ETCD_PRETTY', true),
                    'sslCert'             => '',
                    'sslKey'              => ''
                ]
            ],
        ],
    ],
]
```

## 免费技术支持

QQ群：17916227 [![点击加群](https://pub.idqqimg.com/wpa/images/group.png "点击加群")](https://jq.qq.com/?_wv=1027&k=5wXf4Zq)，如有问题会有人解答和修复。

## 运行环境

* [PHP](https://php.net/) >= 7.4
* [Composer](https://getcomposer.org/) >= 2.0
* [Swoole](https://www.swoole.com/) >= 4.8.0
* [imi](https://www.imiphp.com/) >= 2.1

## 版权信息

`imi-etcd` 遵循 MulanPSL-2.0 开源协议发布，并提供免费使用。
