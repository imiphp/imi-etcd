<?php

declare(strict_types=1);

namespace Imi\Etcd\Client;

use Imi\Etcd\Listen\ConfigListener;
use Imi\Etcd\Listen\ListenerConfig;

class Config
{
    /**
     * scheme.
     */
    protected string $scheme = 'http';

    /**
     * host.
     */
    protected string $host = '127.0.0.1';

    /**
     * port.
     */
    protected int $port = 2379;

    /**
     * API version.
     */
    protected string $version = 'v3';

    /**
     * 是否只获取返回结果.
     */
    protected bool $pretty = true;

    protected bool $ssl = false;

    /**
     * SSL Cert.
     */
    protected string $sslCert;

    /**
     * SSL Key.
     */
    protected string $sslKey;

    /**
     * timeout.
     */
    protected int $timeout = 300;

    public function __construct(array $config = [])
    {
        if (!empty($config))
        {
            $this->setHost($config['host'] ?? $this->host);
            $this->setPort($config['port'] ?? $this->port);
            $this->setScheme($config['scheme'] ?? $this->scheme);
            $this->setSsl($config['ssl'] ?? $this->ssl);
            $this->setVersion($config['version'] ?? $this->version);
            $this->setTimeout($config['timeout'] ?? $this->timeout);
            $this->setPretty($config['pretty'] ?? $this->pretty);
            $this->setSslCert($config['sslCert'] ?? $this->sslCert);
            $this->setSslKey($config['sslKey'] ?? $this->sslKey);
        }
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function setHost(string $host): void
    {
        $this->host = $host;
    }

    public function getPort(): int
    {
        return $this->port;
    }

    public function setPort(int $port): void
    {
        $this->port = $port;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function setVersion(string $version): void
    {
        $this->version = $version;
    }

    public function isPretty(): bool
    {
        return $this->pretty;
    }

    public function setPretty(bool $pretty): void
    {
        $this->pretty = $pretty;
    }

    public function getScheme(): string
    {
        return $this->scheme;
    }

    public function setScheme(string $scheme): void
    {
        $this->scheme = $scheme;
    }

    public function getSslCert(): string
    {
        return $this->sslCert;
    }

    public function setSslCert(string $sslCert): void
    {
        $this->sslCert = $sslCert;
    }

    public function getSslKey(): string
    {
        return $this->sslKey;
    }

    public function setSslKey(string $sslKey): void
    {
        $this->sslKey = $sslKey;
    }

    public function isSsl(): bool
    {
        return $this->ssl;
    }

    public function setSsl(bool $ssl): void
    {
        $this->ssl = $ssl;
    }

    public function getTimeout(): int
    {
        return $this->timeout;
    }

    public function setTimeout(int $timeout): void
    {
        $this->timeout = $timeout;
    }

    public function getConfigListener(ListenerConfig $listenerConfig): ConfigListener
    {
        return new ConfigListener($this->getClient(), $listenerConfig);
    }

    public function getClient(): Client
    {
        return new Client($this);
    }
}
