<?php

declare(strict_types=1);

namespace app\Process;

use Imi\Config;
use Imi\Swoole\Process\Annotation\Process;
use Imi\Swoole\Process\BaseProcess;

/**
 * @Process("TestProcess")
 */
class SwooleTestProcess extends BaseProcess
{
    public function run(\Swoole\Process $process): void
    {
        while (true)
        {
            var_dump(__METHOD__, Config::get('etcd'));
            sleep(3);
        }
    }
}