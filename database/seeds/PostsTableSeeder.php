<?php

use Illuminate\Database\Seeder;
use App\Model\Post;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = factory(Post::class)->times(50)->make();
        Post::insert($posts->toArray());
    }
}
