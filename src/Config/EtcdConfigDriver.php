<?php

declare(strict_types=1);

namespace Imi\Etcd\Config;

use Imi\App;
use Imi\Etcd\Client\Client;
use Imi\Etcd\Config\Contract\IEtcdConfigDriver;


class EtcdConfigDriver implements IEtcdConfigDriver
{
    protected Client $client;

    public function getOriginClient(): Client
    {
        return $this->client;
    }
}
