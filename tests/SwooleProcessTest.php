<?php

declare(strict_types=1);

namespace Imi\Etcd\Test;

class SwooleProcessTest extends BaseTest
{
    protected static function __startServer(): void
    {
        self::$process = $process = new \Symfony\Component\Process\Process([\PHP_BINARY, \dirname(__DIR__) . '/example/bin/imi-swoole', 'swoole/start'], null, [
            'IMI_CONFIG_CENTER_MODE' => \Imi\ConfigCenter\Enum\Mode::PROCESS,
        ]);
        $process->start();
    }

    /**
     * {@inheritDoc}
     */
    public static function setUpBeforeClass(): void
    {
        if (!\extension_loaded('swoole'))
        {
            self::markTestSkipped('no swoole');
        }
        parent::setUpBeforeClass();
    }
}
