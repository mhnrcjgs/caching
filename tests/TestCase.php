<?php

use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Support\Facades\Log;


abstract class TestCase extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->setUpDatabase();
        $this->migrateTables();
    }


    protected function makePost() {
        $post = new Post;
        $post->title = 'Some title here';
        $post->save();
        return $post;
    }

    private function setUpDatabase()
    {
        $database = new DB;

        $database->addConnection([
            'driver' => 'mysql',
            'host' => 'localhost',
            'port' => '3306',
            'database' => 'caching',
            'username' => 'root',
            'password' => 'secret',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]);

        $database->bootEloquent();

        $database->setAsGlobal();

    }

    private function migrateTables()
    {

        DB::schema()->dropIfExists('posts');

        DB::schema()->create('posts', function ($table) {
            $table->increments('id');
            $table->string('title');
            $table->timestamps();
        });
    }
}

class Post extends \Illuminate\Database\Eloquent\Model {

    use Dakine\Matryoshka\Cacheable;

}