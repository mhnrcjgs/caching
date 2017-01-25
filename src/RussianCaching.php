<?php


namespace Dakine\Matryoshka;


use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class RussianCaching
{

    protected static $key = [];

    public static function setUp($model)
    {

        static::$key[] = $key = $model->getCacheKey();

        Log::debug('KEY: '.$key);

        ob_start();

        Log::debug(Cache::get($key));

        return false; //Cache::has($key);

    }

    public static function tearDown()
    {
        $key = array_pop(static::$key);

        $html = ob_get_clean();

        return Cache::rememberForever($key, function () use ($html) {
            return $html;
        });

    }

}