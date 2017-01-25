<?php


class BladeDirectiveTest extends TestCase
{

    public function test_sets_up_the_opening_cache_directive()
    {

        $directive = $this->createNewCacheDirective();

        $isCached = $directive->setUp($this->makePost());

        $this->assertFalse($isCached);

        echo '<div>frag</div>';

        $cacheFragment = $directive->tearDown();

        $this->assertEquals('<div>frag</div>', $cacheFragment);
    }

    private function createNewCacheDirective()
    {

        $cache = new \Illuminate\Cache\Repository(
            new \Illuminate\Cache\ArrayStore
        );

        $cache = new \Dakine\Matryoshka\RussianCaching($cache);

        return new \Dakine\Matryoshka\BladeDirective($cache);
    }

}