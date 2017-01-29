<?php

use Illuminate\Database\Seeder;
use App\Category;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get(database_path('data/news.json'));
        $data = json_decode($json);

        /**
         * @var Category $news
         */
        $news = Category::firstOrNew(['name' => Category::NAME_NEWS]);
        $news->save();

        foreach ($data as $obj) {
            $created_at = \Carbon\Carbon::createFromTimestamp($obj->created);
            $updated_at = \Carbon\Carbon::createFromTimestamp($obj->updated);

            \App\Article::insert(array([
                'id' => $obj->id,
                'title' => $obj->title,
                'body' => $obj->body,
                'image_url' => $obj->image_url,
                'short_description' => $obj->short_description,
                'category_id' => $news->id,
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ]));
        }
    }
}
