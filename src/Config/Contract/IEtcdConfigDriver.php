<?php

declare(strict_types=1);

namespace Imi\Etcd\Config\Contract;

use Imi\ConfigCenter\Contract\IConfigDriver;
use Imi\Etcd\Client\Client;

interface IEtcdConfigDriver extends IConfigDriver
{
    /**
     * {@inheritDoc}
     */
    public function getOriginClient(): Client;
}
