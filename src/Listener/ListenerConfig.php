<?php

declare(strict_types=1);

namespace Imi\Etcd\Listener;

class ListenerConfig
{
    /**
     * Listener timeout time, in milliseconds.
     */
    protected int $timeout = 30000;

    /**
     * Waiting time to retry after failure, in milliseconds.
     */
    protected int $failedWaitTime = 3000;

    protected string $savePath = '';

    /**
     * File cache time, in seconds.
     */
    protected int $fileCacheTime = 0;

    public function __construct(array $config = [])
    {
        if (!empty($config))
        {
            foreach ($config as $key => $v)
            {
                if (!isset($this->$key))
                {
                    continue;
                }
                $this->$key = $v;
            }
        }
    }

    /**
     * Get Listener timeout time, in milliseconds.
     */
    public function getTimeout(): int
    {
        return $this->timeout;
    }

    /**
     * Set Listener timeout time, in milliseconds.
     */
    public function setTimeout(int $timeout): self
    {
        $this->timeout = $timeout;

        return $this;
    }

    /**
     * Get Waiting time to retry after failure, in milliseconds.
     */
    public function getFailedTimeout(): int
    {
        return $this->failedWaitTime;
    }

    /**
     * Set Waiting time to retry after failure, in milliseconds.
     */
    public function setFailedTimeout(int $failedWaitTime): self
    {
        $this->failedWaitTime = $failedWaitTime;

        return $this;
    }

    public function getSavePath(): string
    {
        return $this->savePath;
    }

    public function setSavePath(string $savePath): self
    {
        $this->savePath = $savePath;

        return $this;
    }

    public function getFileCacheTime(): int
    {
        return $this->fileCacheTime;
    }

    public function setFileCacheTime(int $fileCacheTime): self
    {
        $this->fileCacheTime = $fileCacheTime;

        return $this;
    }
}
