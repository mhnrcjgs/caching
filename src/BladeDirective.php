<?php


namespace Dakine\Matryoshka;


use Illuminate\Support\Facades\Log;

class BladeDirective
{

    protected $keys = [];
    /**
     * @var RussianCaching
     */
    private $cache;

    public function __construct(RussianCaching $cache)
    {

        $this->cache = $cache;
    }

    public function setUp($model)
    {
        ob_start();

        $this->keys[] = $key = $model->getCacheKey();

        return $this->cache->has($key);

    }

    public function tearDown()
    {

        return $this->cache->put(array_pop($this->keys), ob_get_clean());

    }

}