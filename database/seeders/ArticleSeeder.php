<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;
class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        $categories = Category::all();

        $articles = [
[
                'title' => 'Tech Trends 2025',
                'content' => 'Exploring the latest in technology...',
                'category_id' => $categories->where('name', 'Technology')->first()->id,
                'user_id' => $admin->id,
            ],
            [
                'title' => 'Science Breakthroughs',
                'content' => 'New discoveries in science...',
                'category_id' => $categories->where('name', 'Science')->first()->id,
                'user_id' => $admin->id,
            ],
        ];
        foreach($articles as $article){
            Article::create($article);
        }
    }
}
