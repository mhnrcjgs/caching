<?php


class RussianCachingTest extends TestCase
{

    public function test_it_caches_the_given_key()
    {
        $post = $this->makePost();

        $cache = new \Illuminate\Cache\Repository(
            new Illuminate\Cache\ArrayStore
        );

        $russian_caching = new \Dakine\Matryoshka\RussianCaching($cache);

        $russian_caching->put($post->getCacheKey(), '<div>my fragment</div>');

        $this->assertTrue($russian_caching->has($post->getCacheKey()));

    }


}