<?php

declare(strict_types=1);

namespace Imi\Etcd\Config;

use Imi\App;
use Imi\Etcd\Client\Client;
use Imi\Etcd\Config\Contract\IEtcdConfigDriver;


class EtcdConfigDriver implements IEtcdConfigDriver
{
    public function getOriginClient(): Client
    {
        // TODO: Implement getOriginClient() method.
    }
}
