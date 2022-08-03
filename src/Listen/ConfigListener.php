<?php
declare( strict_types=1 );

namespace Imi\Etcd\Listen;

use Imi\Etcd\Client\Client;
use Imi\Etcd\Exception\EtcdException;
use Imi\Log\Log;
use Psr\Log\LogLevel;

class ConfigListener
{
    protected Client $client;
    
    protected ListenerConfig $listenerConfig;
    
    protected bool $running = false;
    
    protected array $listeningLists = [];
    
    public function __construct ( Client $client, ListenerConfig $listenerConfig )
    {
        $this->client         = $client;
        $this->listenerConfig = $listenerConfig;
    }
    
    public function pull (): void
    {
        $this->polling();
    }
    
    public function get(string $key): string
    {
        return $this->listeningLists[$key]['value'] ?? '';
    }
    
    public function addListener(string $key, ?callable $callback = null): void
    {
        try {
            $this->listeningLists[$key] = [
                'value'    => $this->client->get( $key )[ $key ],
                'callback' => $callback,
            ];
        }catch (\Throwable $th){
            Log::log(LogLevel::ERROR, sprintf('Etcd addListener failed: %s', $th));
        }
        
    }
    
    public function removeListener(string $key): void
    {
        if (isset($this->listeningLists[$key])) {
            unset($this->listeningLists[$key]);
        }
    }
    

    
    public function stop (): void
    {
        $this->running = false;
    }
    
    public function start (): void
    {
        $this->running = true;
        while ($this->running) {
            if (!$this->listeningLists) {
                usleep(100_000);
                continue;
            }
            $this->polling();
        }
    
    }
    
    public function polling (): void
    {
        // 轮询监听的配置
        try {
            $this->client->pretty = true;
            foreach ($this->listeningLists as $key => $value) {
                $res = $this->client->get( $key );
        
                if ( !isset( $res[ $key ] ) ) continue;
                
                $this->listeningLists[ $key ]['value'] = $res[ $key ];
        
                if ( isset( $this->listeningLists[ $key ]['callback'] ) ) {
                    $this->listeningLists[ $key ]['callback']( $this, $key);
                }
                
                $this->saveCache($key,$res[ $key ]);
            }
            
        }catch (\Throwable $th){
            Log::log(LogLevel::ERROR, sprintf('Etcd listen failed: %s', $th));
            usleep($this->listenerConfig->getFailedTimeout() * 1000);
        }
     
        
    }
    
    protected function saveCache(string $key, string $value): bool
    {
        
        $savePath = $this->listenerConfig->getSavePath();
        if ('' === $savePath) {
            return false;
        }
        
        $fileName = $savePath . '/' . 'etcd';
        if (!is_dir($fileName)) {
            mkdir($fileName, 0777, true);
        }
        $fileName .= '/' . $key;
        file_put_contents($fileName, $value);
        file_put_contents($fileName . '.meta', json_encode([ 'lastUpdateTime' => time()]));
        return true;
    }
    
    protected function loadCache(string $key,int $fileCacheTime = 0): bool
    {
        $savePath = $this->listenerConfig->getSavePath();
        if ('' === $savePath) {
            return false;
        }
        
        $fileName = $savePath . '/' . 'etcd/' . $key;
        if (!is_file($fileName)) {
            return false;
        }
        $metaFileName = $fileName . '.meta';
        if (is_file($metaFileName)) {
            $value = file_get_contents($metaFileName);
            if (false === $value) {
                throw new EtcdException(sprintf('Failed to read the contents of file %s', $metaFileName));
            }
            $meta = json_decode($value, true);
            if (!$meta) {
                return false;
            }
        } else {
            $meta = [];
        }
        if ($fileCacheTime > 0 && (time() - ($meta['lastUpdateTime'] ?? 0) > $fileCacheTime)) {
            return false;
        }
        $value = file_get_contents($fileName);
        if (false === $value) {
            throw new EtcdException(sprintf('Failed to read the contents of file %s', $fileName));
        }
        return true;
    }
    
    
    
    
}
