<?php

declare(strict_types=1);

namespace Imi\Etcd\Config;

use Imi\Etcd\Client\Client;
use Imi\Etcd\Client\Config;
use Imi\Etcd\Config\Contract\IEtcdConfigDriver;
use Imi\Etcd\Config\Event\Param\EtcdConfigChangeEventParam;
use Imi\Etcd\Listener\ConfigListener;
use Imi\Etcd\Listener\ListenerConfig;
use Imi\Event\Event;

class EtcdConfigDriver implements IEtcdConfigDriver
{
    protected Client $client;

    protected array $config = [];

    protected string $name = '';

    protected bool $listening = false;

    protected ConfigListener $configListener;

    public function __construct(string $name, array $config)
    {
        $this->config = $config;
        $this->name = $name;
        $this->client = new Client(new Config($config['client']));

        $listenerConfig = new ListenerConfig($config['listener'] ?? []);
        // 监听配置
        $this->configListener = $this->client->config->getConfigListener($listenerConfig);
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * {@inheritDoc}
     */
    public function push(string $key, string $value, array $options = []): void
    {
        $this->client->put($key, $value, $options);
    }

    /**
     * {@inheritDoc}
     */
    public function pull(bool $enableCache = true): void
    {
        $this->configListener->pull(!$enableCache);
    }

    /**
     * 从配置中心获取配置原始数据.
     */
    public function getRaw(string $key, bool $enableCache = true, array $options = []): ?string
    {
        return $this->client->getRaw($key, $options) ?: '';
    }

    /**
     * 从配置中心获取配置处理后的数据.
     * $enableCache 是否从缓存中取出.
     *
     * @return mixed
     */
    public function get(string $key, bool $enableCache = true, array $options = [])
    {
        if ($enableCache)
        {
            return json_decode($this->configListener->get($key), true);
        }
        else
        {
            return $this->client->get($key, $options) ?: [];
        }
    }

    /**
     * {@inheritDoc}
     */
    public function delete($keys, array $options = []): void
    {
        $this->client->del($keys, $options);
    }

    public function listen(string $imiConfigKey, string $key, array $options = []): void
    {
        $this->configListener->addListener($key, function (ConfigListener $listener, string $key) use ($imiConfigKey) {
            Event::trigger('IMI.CONFIG_CENTER.CONFIG.CHANGE', [
                'driver'      => $this,
                'configKey'   => $imiConfigKey,
                'key'         => $key,
                'value'       => $listener->get($key),
                'parsedValue' => $listener->getParsed($key),
                'options'     => [
                    'listener' => $listener,
                ],
            ], $this, EtcdConfigChangeEventParam::class);
        });
    }

    public function polling(): void
    {
        $this->configListener->polling();
    }

    public function startListner(): void
    {
        $this->listening = true;
        $this->configListener->start();
    }

    public function stopListner(): void
    {
        $this->listening = false;
        $this->configListener->stop();
    }

    public function isListening(): bool
    {
        return $this->listening;
    }

    public function isSupportServerPush(): bool
    {
        return false;
    }

    /**
     * 获取 etcd 客户端.
     */
    public function getOriginClient(): Client
    {
        return $this->client;
    }
}
