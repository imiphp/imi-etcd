<?php

declare( strict_types=1 );

namespace Imi\Etcd\Config;

use Imi\App;
use Imi\Etcd\Client\Client;
use Imi\Etcd\Client\Config;
use Imi\Etcd\Config\Contract\IEtcdConfigDriver;


class EtcdConfigDriver implements IEtcdConfigDriver
{
    protected Client $client;
    
    protected array $config = [];
    
    
    public function __construct (array $config )
    {
        $this->config = $config;
        $this->client = new Client( new Config( $config['client'] ) );
    }
    
    public function getOriginClient (): Client
    {
        return $this->client;
    }
}
