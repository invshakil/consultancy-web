<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(KeywordSeeder::class);
        $this->call(ArticleSeeder::class);
        $this->call(DeviceSeeder::class);
        $this->call(FavoriteSeeder::class);
        $this->call(ArticleKeywordSeeder::class);
        $this->call(ArticleCategorySeeder::class);
    }
}
