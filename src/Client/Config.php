<?php

declare( strict_types=1 );

namespace Imi\Etcd\Client;

class Config
{
    /**
     * scheme
     * @var string
     */
    protected string $scheme = 'http';
    
    /**
     * host
     * @var string
     */
    protected string $host = '127.0.0.1';
    
    /**
     * port
     * @var int
     */
    protected int $port = 2379;
    
    /**
     * API version
     * @var string
     */
    protected string $version = 'v3';
    
    /**
     * 是否只获取返回结果
     * @var bool
     */
    protected bool $pretty = false;
    
    /**
     * @var bool
     */
    protected bool $ssl = false;
    
    /**
     * SSL Cert
     * @var string
     */
    protected string $sslCert;
    
    /**
     * SSL Key
     * @var string
     */
    protected string $sslKey;
    
    /**
     * timeout
     * @var int
     */
    protected int $timeout = 30;
    
    /**
     * @param array $config
     */
    public function __construct ( array $config = [] )
    {
        if (!empty($config)) {
            $this->setHost( $config['host'] );
            $this->setPort( $config['port'] );
            $this->setScheme( $config['scheme'] );
            $this->setSsl( $config['ssl'] );
            $this->setVersion( $config['version'] );
            $this->setTimeout( $config['timeout'] );
            $this->setPretty( $config['pretty'] );
            $this->setSslCert( $config['sslCert'] );
            $this->setSslKey( $config['sslKey'] );
        }
        
    }
    
    /**
     * @return string
     */
    public function getHost (): string
    {
        return $this->host;
    }
    
    /**
     * @param string $host
     */
    public function setHost ( string $host ): void
    {
        $this->host = $host;
    }
    
    /**
     * @return int
     */
    public function getPort (): int
    {
        return $this->port;
    }
    
    /**
     * @param int $port
     */
    public function setPort ( int $port ): void
    {
        $this->port = $port;
    }
    
    /**
     * @return string
     */
    public function getVersion (): string
    {
        return $this->version;
    }
    
    /**
     * @param string $version
     */
    public function setVersion ( string $version ): void
    {
        $this->version = $version;
    }
    
    /**
     * @return bool
     */
    public function isPretty (): bool
    {
        return $this->pretty;
    }
    
    /**
     * @param bool $pretty
     */
    public function setPretty ( bool $pretty ): void
    {
        $this->pretty = $pretty;
    }
    
    /**
     * @return string
     */
    public function getScheme (): string
    {
        return $this->scheme;
    }
    
    /**
     * @param string $scheme
     */
    public function setScheme ( string $scheme ): void
    {
        $this->scheme = $scheme;
    }
    
    /**
     * @return string
     */
    public function getSslCert (): string
    {
        return $this->sslCert;
    }
    
    /**
     * @param string $sslCert
     */
    public function setSslCert ( string $sslCert ): void
    {
        $this->sslCert = $sslCert;
    }
    
    /**
     * @return string
     */
    public function getSslKey (): string
    {
        return $this->sslKey;
    }
    
    /**
     * @param string $sslKey
     */
    public function setSslKey ( string $sslKey ): void
    {
        $this->sslKey = $sslKey;
    }
    
    /**
     * @return bool
     */
    public function isSsl (): bool
    {
        return $this->ssl;
    }
    
    /**
     * @param bool $ssl
     */
    public function setSsl ( bool $ssl ): void
    {
        $this->ssl = $ssl;
    }
    
    /**
     * @return int
     */
    public function getTimeout (): int
    {
        return $this->timeout;
    }
    
    /**
     * @param int $timeout
     */
    public function setTimeout ( int $timeout ): void
    {
        $this->timeout = $timeout;
    }
}