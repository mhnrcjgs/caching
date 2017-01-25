<?php


namespace Dakine\Matryoshka;


use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Support\Facades\Log;

class RussianCaching
{

    private $cache;

    public function __construct(Cache $cache)
    {

        $this->cache = $cache;
    }

    public function put($key, $fragment)
    {
        $key = $this->normalizeCacheKey($key);

        return $this->cache->rememberForever($key, function () use ($fragment) {
            return $fragment;
        });
    }

    public function has($key)
    {
        $key = $this->normalizeCacheKey($key);

        return $this->cache->has($key);
    }

    private function normalizeCacheKey($key)
    {
        if ($key instanceof \Illuminate\Database\Eloquent\Model)
        {
            return $key->getCacheKey();
        }

        return $key;
    }

}