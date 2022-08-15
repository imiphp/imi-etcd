<?php

declare(strict_types=1);

namespace Imi\Etcd\Config\Event\Param;

use Imi\ConfigCenter\Event\Param\ConfigChangeEventParam;
use Imi\Etcd\Listener\ConfigListener;

class EtcdConfigChangeEventParam extends ConfigChangeEventParam
{
    protected ?ConfigListener $listener = null;

    public function __construct(string $eventName, array $data = [], ?object $target = null)
    {
        parent::__construct($eventName, $data, $target);
        $this->listener = $data['options']['listener'] ?? null;
    }

    public function getListener(): ?ConfigListener
    {
        return $this->listener;
    }
}
